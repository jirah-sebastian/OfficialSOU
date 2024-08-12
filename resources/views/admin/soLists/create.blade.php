@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header" style="background-color: #005600; color:white;">
            <strong>ADD STUDENT ORGANIZATION</strong>
        </div>

        <div class="card-body">
            <div class="alert alert-success" role="alert">
                Register your organization first to access other features.
            </div>


            <form id="soForm" method="POST" action="{{ route('admin.so-lists.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="so_name">{{ trans('cruds.soList.fields.so_name') }}</label>
                    <input class="form-control {{ $errors->has('so_name') ? 'is-invalid' : '' }}" type="text"
                        name="so_name" id="so_name" value="{{ old('so_name', $so_name) }}" readonly>
                    @if ($errors->has('so_name'))
                        <span class="text-danger">{{ $errors->first('so_name') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.soList.fields.so_name_helper') }}</span>
                </div>

                <div class="form-group">
                    <label for="so_category_id">{{ trans('cruds.soList.fields.so_category') }}</label>
                    <select class="form-control select2 {{ $errors->has('so_category') ? 'is-invalid' : '' }}"
                        name="so_category_id" id="so_category_id" required style="width: 100%;">
                        @foreach ($so_categories as $id => $entry)
                            <option value="{{ $id }}" {{ old('so_category_id') == $id ? 'selected' : '' }}>
                                {{ $entry }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('so_category'))
                        <span class="text-danger">This field is required.</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.soList.fields.so_category_helper') }}</span>
                </div>

                <div class="form-group">
                    <label for="banner">Logo</label>
                    <div class="needsclick dropzone {{ $errors->has('banner') ? 'is-invalid' : '' }}" id="banner-dropzone">
                    </div>
                    @if ($errors->has('banner'))
                        <span class="text-danger">This field is required.</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.soList.fields.banner_helper') }}</span>
                    <span class="text-muted" style="font-size: small;">Image must not exceed 3 MB in size</span>
                </div>
                <div class="form-group">
                    <label for="overview">{{ trans('cruds.soList.fields.overview') }}</label>
                    <input class="form-control {{ $errors->has('overview') ? 'is-invalid' : '' }}" type="text"
                        name="overview" id="overview" value="{{ old('overview', '') }}" required maxlength="500">
                    @if ($errors->has('overview'))
                        <span class="text-danger">This field is required.</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.soList.fields.overview_helper') }}</span>
                </div>

                <div class="form-group" style="position: relative;">
                    <label for="information">{{ trans('cruds.soList.fields.information') }}
                        <!-- Tooltip icon -->
                        <i class="fas fa-question-circle danger" id="tooltip-icon"></i></label>
                    <textarea class="form-control ckeditor {{ $errors->has('information') ? 'is-invalid' : '' }}" name="information"
                        id="information">{!! old('information') !!}</textarea>
                    @if ($errors->has('information'))
                        <span class="text-danger">This field is required.</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.soList.fields.information_helper') }}</span>

                    <!-- Tooltip message -->
                    <div id="tooltip-message"
                        style="display: none; position: absolute; top: -10px; left: 210px; right: auto; padding: 5px; background-color: #28a745; color: #fff; border-radius: 5px; z-index: 999;">
                        This field is for providing a brief description or overview of the student organization. You can
                        include details such as the organization's goals, achievements, and any other relevant information.
                    </div>
                </div>

                <div class="form-group">
                    <label for="anniversary_date">Date of Anniversary <small>(YYYY-MM-DD)</small></label>
                    <input class="form-control date {{ $errors->has('anniversary_date') ? 'is-invalid' : '' }}"
                        type="text" name="anniversary_date" id="anniversary_date" value="{{ old('anniversary_date') }}"
                        required>
                    @if ($errors->has('anniversary_date'))
                        <span class="text-danger">This field is required.</span>
                    @endif
                </div>
            
                
              

                <div class="form-group">
                    <label for="adviser">Name of Adviser</label>
                    <input class="form-control {{ $errors->has('adviser') ? 'is-invalid' : '' }}" type="text"
                        name="adviser" id="adviser" value="{{ old('adviser', '') }}" required>
                    @if ($errors->has('adviser'))
                        <span class="text-danger">This field is required.</span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="adviserEmail">Email of Adviser</label>
                    <input class="form-control {{ $errors->has('adviserEmail') ? 'is-invalid' : '' }}" type="text"
                        name="adviserEmail" id="adviserEmail" value="{{ old('adviserEmail', '') }}" required>
                    @if ($errors->has('adviserEmail'))
                        <span class="text-danger">This field is required.</span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="adviserCollege">College of Adviser</label>
                    <input class="form-control {{ $errors->has('adviserCollege') ? 'is-invalid' : '' }}" type="text"
                        name="adviserCollege" id="adviserCollege" value="{{ old('adviserCollege', '') }}" required>
                    @if ($errors->has('adviserCollege'))
                        <span class="text-danger">This field is required.</span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="adviserYears">Number of Years as Adviser</label>
                    <input class="form-control {{ $errors->has('adviserYears') ? 'is-invalid' : '' }}" type="text"
                        name="adviserYears" id="adviserYears" value="{{ old('adviserYears', '') }}" required>
                    @if ($errors->has('adviserYears'))
                        <span class="text-danger">This field is required.</span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="adviserField">Adviser's Major Field of Specialization </label>
                    <input class="form-control {{ $errors->has('adviserField') ? 'is-invalid' : '' }}" type="text"
                        name="adviserField" id="adviserField" value="{{ old('adviserField', '') }}" required>
                    @if ($errors->has('adviserField'))
                        <span class="text-danger">This field is required.</span>
                    @endif
                </div>




                <div class="form-group">
                    <label for="created_by_id">Organization Admin</label>
                    <select class="form-control select2 {{ $errors->has('created_by') ? 'is-invalid' : '' }}"
                        name="created_by_id" id="created_by_id">
                        @foreach ($created_bies as $id => $entry)
                            <option value="{{ $id }}" {{ auth()->id() == $id ? 'selected' : '' }}>
                                {{ $entry }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('created_by'))
                        <span class="text-danger">{{ $errors->first('created_by') }}</span>
                    @endif
                    {{-- <span class="help-block">{{ trans('cruds.soList.fields.created_by_helper') }}</span> --}}
                </div><br>

                @if (!auth()->user()->is_pres)
                    <div class="form-group">
                        <label for="remark">{{ trans('cruds.soList.fields.remark') }}</label>
                        <input class="form-control {{ $errors->has('remark') ? 'is-invalid' : '' }}" type="text"
                            name="remark" id="remark" value="{{ old('remark', '') }}">
                        @if ($errors->has('remark'))
                            <span class="text-danger">{{ $errors->first('remark') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.soList.fields.remark_helper') }}</span>
                    </div>
                @endif
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
                        style="font-weight: bold; font-size: 18px; color: white">
                        Confirm
                        Submission</h5>
                    <button id="closeModalBtn" type="button" class="close" aria-label="Close" style="color: white">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="font-size: 16px;">
                    Are you sure all the information provided is correct? You cannot edit it once submitted.
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
        Dropzone.options.bannerDropzone = {
            url: '{{ route('admin.so-lists.storeMedia') }}',
            maxFilesize: 3, // MB
            acceptedFiles: '.jpeg,.jpg,.png',
            maxFiles: 1,
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 3,
                // width: 4096,
                // height: 4096
            },
            success: function(file, response) {
                $('form').find('input[name="banner"]').remove()
                $('form').append('<input type="hidden" name="banner" value="' + response.name + '">')
            },
            removedfile: function(file) {
                file.previewElement.remove()
                if (file.status !== 'error') {
                    $('form').find('input[name="banner"]').remove()
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function() {
                var myDropzone = this;
                var errorMessageShown = false;


                // Add event listener for when files are added
                myDropzone.on("addedfile", function(file) {
                    $('.text-danger').remove();

                    // Check if the file type is acceptable
                    var acceptedTypes = ['image/jpeg', 'image/png'];
                    if (!acceptedTypes.includes(file.type)) {
                        $('#banner-dropzone').addClass('is-invalid');
                        $('#banner-dropzone').parent().append(
                            '<span class="text-danger">Only JPEG and PNG file is accepted. </span>'
                        );
                        return;
                    }

                    // Check if the file size exceeds 1MB
                    if (file.size > 3 * 1024 * 1024) {
                        $('#banner-dropzone').addClass('is-invalid');
                        $('#banner-dropzone').parent().append(
                            '<span class="text-danger">File size must not exceed 3 MB. </span>');
                        return;
                    }

                    // If more than one file is added, show an error message
                    if (myDropzone.files.length > 1) {
                        $('#banner-dropzone').addClass('is-invalid');
                        $('#banner-dropzone').parent().append(
                            '<span class="text-danger">Only one file is allowed. </span>'
                        );
                        myDropzone.removeFile(file); // Remove the invalid file
                        return;
                    }

                    // If file meets requirements, remove any error messages and classes
                    $('#banner-dropzone').removeClass('is-invalid');
                });


                // Add event listener for form submission
                $('form').submit(function(event) {

                    if (myDropzone.getQueuedFiles().length === 0 && myDropzone.getAcceptedFiles().length ===
                        0) {

                        event.preventDefault();

                        $('.text-danger').remove();

                        var errorMessage = $(
                            '<span class="text-danger">Please ensure that you upload a file or follow the requested format.</span>'
                        );

                        $('#banner-dropzone').parent().append(errorMessage);

                        errorMessageShown = true;

                        $('html, body').animate({
                            scrollTop: $("#banner-dropzone").offset().top
                        }, 100);
                    } else {
                        var otherValidationErrors = $('.text-danger').not('#banner-dropzone')
                            .length > 0;

                        if (!otherValidationErrors) {
                            $('.text-danger').remove();
                        }
                    }
                });

                @if (isset($soList) && $soList->banner)
                    var file = {!! json_encode($soList->banner) !!}
                    this.options.addedfile.call(this, file)
                    this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="banner" value="' + file.file_name + '">')
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
                $('#soForm').off('submit').submit(); // Submit the form
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
    <script>
        $(document).ready(function() {
            function SimpleUploadAdapter(editor) {
                editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
                    return {
                        upload: function() {
                            return loader.file
                                .then(function(file) {
                                    return new Promise(function(resolve, reject) {
                                        // Init request
                                        var xhr = new XMLHttpRequest();
                                        xhr.open('POST',
                                            '{{ route('admin.so-lists.storeCKEditorImages') }}',
                                            true);
                                        xhr.setRequestHeader('x-csrf-token', window._token);
                                        xhr.setRequestHeader('Accept', 'application/json');
                                        xhr.responseType = 'json';

                                        // Init listeners
                                        var genericErrorText =
                                            `Couldn't upload file: ${ file.name }.`;
                                        xhr.addEventListener('error', function() {
                                            reject(genericErrorText)
                                        });
                                        xhr.addEventListener('abort', function() {
                                            reject()
                                        });
                                        xhr.addEventListener('load', function() {
                                            var response = xhr.response;

                                            if (!response || xhr.status !== 201) {
                                                return reject(response && response
                                                    .message ?
                                                    `${genericErrorText}\n${xhr.status} ${response.message}` :
                                                    `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`
                                                );
                                            }

                                            $('form').append(
                                                '<input type="hidden" name="ck-media[]" value="' +
                                                response.id + '">');

                                            resolve({
                                                default: response.url
                                            });
                                        });

                                        if (xhr.upload) {
                                            xhr.upload.addEventListener('progress', function(
                                                e) {
                                                if (e.lengthComputable) {
                                                    loader.uploadTotal = e.total;
                                                    loader.uploaded = e.loaded;
                                                }
                                            });
                                        }

                                        // Send request
                                        var data = new FormData();
                                        data.append('upload', file);
                                        data.append('crud_id', '{{ $soList->id ?? 0 }}');
                                        xhr.send(data);
                                    });
                                })
                        }
                    };
                }
            }

            var allEditors = document.querySelectorAll('.ckeditor');
            for (var i = 0; i < allEditors.length; ++i) {
                ClassicEditor.create(
                    allEditors[i], {
                        extraPlugins: [SimpleUploadAdapter]
                    }
                );
            }
        });
    </script>

    <script>
        document.getElementById('tooltip-icon').addEventListener('mouseover', function() {
            document.getElementById('tooltip-message').style.display = 'block';
        });

        document.getElementById('tooltip-icon').addEventListener('mouseout', function() {
            document.getElementById('tooltip-message').style.display = 'none';
        });
    </script>
@endsection
