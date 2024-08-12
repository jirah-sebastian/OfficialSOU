@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header" style="background-color: #005600; color:white;">
            <strong>EDIT ANNOUNCEMENT</strong>
        </div>

        <div class="card-body">


            <form method="POST" action="{{ route('admin.announcements.update', [$announcement->id]) }}"
                enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label for="title">{{ trans('cruds.announcement.fields.title') }}</label>
                    <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title"
                        id="title" value="{{ old('title', $announcement->title) }}" required>
                    @if ($errors->has('title'))
                        <span class="text-danger">This field is required.</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.announcement.fields.title_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="content">{{ trans('cruds.announcement.fields.content') }}</label>
                    <textarea class="form-control ckeditor {{ $errors->has('content') ? 'is-invalid' : '' }}" name="content" id="content">{!! old('content', $announcement->content) !!}</textarea>
                    @if ($errors->has('content'))
                        <span class="text-danger">This field is required.</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.announcement.fields.content_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="photo">{{ trans('cruds.announcement.fields.photo') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('photo') ? 'is-invalid' : '' }}" id="photo-dropzone">
                    </div>
                    @if ($errors->has('photo'))
                        <span class="text-danger">This field is required.</span>
                    @endif
                    <span class="text-muted" style="font-size: small;">Image must not exceed 3 MB in size</span>
                    <span class="help-block">{{ trans('cruds.announcement.fields.photo_helper') }}</span>
                </div>
                <div class="form-group">
                    <div class="form-check {{ $errors->has('is_published') ? 'is-invalid' : '' }}">
                        <input type="hidden" name="is_published" value="0">
                        <input class="form-check-input" type="checkbox" name="is_published" id="is_published" value="1"
                            {{ $announcement->is_published || old('is_published', 0) === 1 ? 'checked' : '' }}>
                            
                            <label class="form-check-label" for="is_published">Accessible to the Public</label>
                    </div>
                    @if ($errors->has('is_published'))
                        <span class="text-danger">{{ $errors->first('is_published') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.announcement.fields.is_published_helper') }}</span>
                </div>
                <div class="form-group">
                    <button class="btn btn-success" type="submit">
                        <i class="fas fa-save"></i><b> {{ trans('global.save') }}</b>
                    </button>
                    {{-- @if ($announcement->deleted_at)
                <a href="{{route('admin.announcement.restore',[$announcement->id, 'restore'])}}" class="btn btn-primary"><i class="fa fa-sync-alt"></i>&nbsp;<b>Restore</b></a>
                @else
                <a href="{{route('admin.announcement.restore',[$announcement->id, 'delete'])}}" class="btn btn-danger"><i class="fa fa-trash"></i>&nbsp;<b>Archive</b></a>
                @endif --}}
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
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
                                            '{{ route('admin.announcements.storeCKEditorImages') }}',
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
                                        data.append('crud_id', '{{ $announcement->id ?? 0 }}');
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
        Dropzone.options.photoDropzone = {
            url: '{{ route('admin.announcements.storeMedia') }}',
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
                $('form').find('input[name="photo"]').remove()
                $('form').append('<input type="hidden" name="photo" value="' + response.name + '">')
            },
            removedfile: function(file) {
                file.previewElement.remove()
                if (file.status !== 'error') {
                    $('form').find('input[name="photo"]').remove()
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function() {
                var myDropzone = this; // Store a reference to the Dropzone object
                var errorMessageShown = false; // Track if error message has been shown


                // Add event listener for when files are added
                myDropzone.on("addedfile", function(file) {
                    // Remove any previous error messages
                    $('.text-danger').remove();

                    // Check if the file type is acceptable
                    var acceptedTypes = ['image/jpeg', 'image/png'];
                    if (!acceptedTypes.includes(file.type)) {
                        $('#photo-dropzone').addClass('is-invalid');
                        $('#photo-dropzone').parent().append(
                            '<span class="text-danger">Only JPEG and PNG file is accepted. </span>'
                        );
                        return;
                    }

                    // Check if the file size exceeds 1MB
                    if (file.size > 3 * 1024 * 1024) {
                        $('#photo-dropzone').addClass('is-invalid');
                        $('#photo-dropzone').parent().append(
                            '<span class="text-danger">File size must not exceed 3 MB. </span>');
                        return;
                    }

                    // If more than one file is added, show an error message
                    if (myDropzone.files.length > 1) {
                        $('#photo-dropzone').addClass('is-invalid');
                        $('#photo-dropzone').parent().append(
                            '<span class="text-danger">Only one file is allowed. </span>'
                        );
                        myDropzone.removeFile(file); // Remove the invalid file
                        return;
                    }

                    // If file meets requirements, remove any error messages and classes
                    $('#photo-dropzone').removeClass('is-invalid');
                });


                @if (isset($announcement) && $announcement->photo)
                    var file = {!! json_encode($announcement->photo) !!}
                    this.options.addedfile.call(this, file)
                    this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="photo" value="' + file.file_name + '">')
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
                    "Ensure all fields are completed and that the specified requirements and format have been followed."
                );
            } else {
                // If there are no errors, remove the error message
                $('.text-danger').remove();
            }
        });
    </script>
@endsection
