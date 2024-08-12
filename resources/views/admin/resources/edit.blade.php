@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header" style="background-color: #005600; color:white;">
            <strong>EDIT RESOURCE</strong>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.resources.update', [$resource->id]) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label for="title">{{ trans('cruds.resource.fields.title') }}</label>
                    <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title"
                        id="title" value="{{ old('title', $resource->title) }}" required>
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
                <div class="form-group">
                    {{-- <div class="form-check {{ $errors->has('is_published') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="is_published" value="0">
                    <input class="form-check-input" type="checkbox" name="is_published" id="is_published" value="1" {{ $resource->is_published || old('is_published', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_published">{{ trans('cruds.resource.fields.is_published') }}</label>
                </div>
                @if ($errors->has('is_published'))
                    <span class="text-danger">{{ $errors->first('is_published') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.resource.fields.is_published_helper') }}</span>
            </div> --}}

                    <div class="form-group">
                        <button class="btn btn-success" type="submit">
                            <i class="fas fa-save"></i><b> {{ trans('global.save') }}</b>
                        </button>
                    </div>
            </form>
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

        // Add event listener for form submission
        $('form').submit(function(event) {
            // Check if there are any validation errors
            var validationErrors = $('.text-danger').length > 0;

            // Check if there are any empty dropzones
            var emptyDropzones = $('.dz-message').filter(function() {
                return $(this).siblings('.dz-preview').length === 0; // Check if there are no file previews
            }).length > 0;

            // If there are validation errors or empty dropzones, prevent form submission
            if (validationErrors || emptyDropzones) {
                event.preventDefault();

                // Show an alert message indicating the error
                alert(
                    "Ensure all fields are completed."
                );
            } else {
                // If there are no errors, remove the error message
                $('.text-danger').remove();
            }
        });
    </script>
@endsection
