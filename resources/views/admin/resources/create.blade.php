@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header" style="background-color: #005600; color:white;">
            <strong>ADD RESOURCE</strong>
        </div>

        <div class="card-body">
            <form id="resForm" method="POST" action="{{ route('admin.resources.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="title">{{ trans('cruds.resource.fields.title') }}</label>
                    <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title"
                        id="title" value="{{ old('title', '') }}" required>
                    @if ($errors->has('title'))
                        <span class="text-danger">This field is required.</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.resource.fields.title_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="file">{{ trans('cruds.resource.fields.file') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('file') ? 'is-invalid' : '' }}" id="file-dropzone">
                    </div>
                    @if ($errors->has('file'))
                        <span class="text-danger">This field is required.</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.resource.fields.file_helper') }}</span>
                </div>
                {{-- <div class="form-group">
                <div class="form-check {{ $errors->has('is_published') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="is_published" value="0">
                    <input class="form-check-input" type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_published">{{ trans('cruds.resource.fields.is_published') }}</label>
                </div>
                @if ($errors->has('is_published'))
                    <span class="text-danger">{{ $errors->first('is_published') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.resource.fields.is_published_helper') }}</span>
            </div> --}}
                <div class="form-group">
                    <input type="hidden" name="created_by_id" id="created_by_id" value="{{ auth()->id() }}">
                </div>
                <div class="form-group">
                    <button class="btn btn-success" type="submit">
                        <i class="fas fa-save"></i><b> {{ trans('global.save') }}</b>
                    </button>
                </div>
            </form>
        </div>
    </div>


    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: green;">
                    <h5 class="modal-title" id="confirmModalLabel"
                        style="font-weight: bold; font-size: 18px; color: white;">
                        Confirm Submission</h5>
                    <button id="closeModalBtn" type="button" class="close" aria-label="Close" style="color: white;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="font-size: 16px;">
                    Are you sure all the information provided is correct?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="confirmSubmit">Yes</button>
                    <button type="button" class="btn btn-danger" id="cancelSubmit" data-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        Dropzone.options.fileDropzone = {
            url: '{{ route('admin.resources.storeMedia') }}',
            maxFilesize: 10, // MB
            maxFiles: 1,
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 10
            },
            success: function(file, response) {
                $('form').find('input[name="file"]').remove()
                $('form').append('<input type="hidden" name="file" value="' + response.name + '">')
            },
            removedfile: function(file) {
                file.previewElement.remove()
                if (file.status !== 'error') {
                    $('form').find('input[name="file"]').remove()
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function() {
                @if (isset($resource) && $resource->file)
                    var file = {!! json_encode($resource->file) !!}
                    this.options.addedfile.call(this, file)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="file" value="' + file.file_name + '">')
                    this.options.maxFiles = this.options.maxFiles - 1
                @endif
            },
            error: function(file, response) {
                if ($.type(response) === 'string') {
                    var message = response //dropzone sends it's own error messages in string
                } else {
                    var message = response.errors.file
                }
                file.previewElement.classList.add('dz-error')
                _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                _results = []
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    node = _ref[_i]
                    _results.push(node.textContent = message)
                }

                return _results
            }
        }

        $(document).ready(function() {
            // Function to show the confirmation modal
            function showConfirmationModal() {
                console.log("Showing confirmation modal");
                $('#confirmModal').modal('show'); // Show the confirmation modal
            }

            // Function to hide the confirmation modal
            function hideConfirmationModal() {
                $('#confirmModal').modal('hide'); // Hide the confirmation modal
            }

            // Function to check for validation errors
            function hasValidationErrors() {
                // Check if there are any validation error messages
                return $('.text-danger').length > 0;
            }

            // Function to check if all dropzones are filled
            function areAllDropzonesFilled() {
                var allFilled = true;
                $('.dropzone').each(function() {
                    if ($(this).find('.dz-preview').length === 0) {
                        allFilled = false;
                        return false; // Break out of the loop early
                    }
                });
                return allFilled;
            }

            // Add event listener to submit button
            $('form').submit(function(event) {
                // Check for validation errors and empty dropzones
                if (hasValidationErrors() || !areAllDropzonesFilled()) {
                    hideConfirmationModal
                        (); // Hide the modal if there are validation errors or empty dropzones
                } else {
                    showConfirmationModal(); // Show the confirmation modal
                    event.preventDefault(); // Prevent default form submission
                }
            });

            // Add event listener to confirm submit button in the modal
            $('#confirmSubmit').click(function() {
                hideConfirmationModal(); // Hide the modal
                $('#resForm').off('submit').submit(); // Submit the form
            });

            // Add event listener to cancel submit button in the modal
            $('#cancelSubmit').click(function() {
                hideConfirmationModal(); // Hide the modal
            });

            // Add event listener to close button
            $('#closeModalBtn').click(function() {
                hideConfirmationModal(); // Hide the modal
            });
        });
    </script>
@endsection
