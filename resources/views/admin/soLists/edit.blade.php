@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header" style="background-color: #005600; color:white;">
            <strong>EDIT STUDENT ORGANIZATION</strong>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.so-lists.update', [$soList->id]) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label for="so_name">{{ trans('cruds.soList.fields.so_name') }}</label>
                    <input class="form-control {{ $errors->has('so_name') ? 'is-invalid' : '' }}" type="text"
                        name="so_name" id="so_name" value="{{ old('so_name', $soList->so_name) }}" required>
                    @if ($errors->has('so_name'))
                        <span class="text-danger">This field is required.</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.soList.fields.so_name_helper') }}</span>
                </div>

                <div class="form-group">
                    <label for="so_category_id">{{ trans('cruds.soList.fields.so_category') }}</label>
                    <select class="form-control select2 {{ $errors->has('so_category') ? 'is-invalid' : '' }}"
                        name="so_category_id" id="so_category_id" required>
                        @foreach ($so_categories as $id => $entry)
                            @if ($id != '')
                                <option value="{{ $id }}"
                                    {{ (old('so_category_id') ? old('so_category_id') : $soList->so_category->id ?? '') == $id ? 'selected' : '' }}>
                                    {{ $entry }}
                                </option>
                            @endif
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
                        name="overview" id="overview" value="{{ old('overview', $soList->overview) }}" required>
                    @if ($errors->has('overview'))
                        <span class="text-danger">This field is required.</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.soList.fields.overview_helper') }}</span>
                    <small id="characterLimitMessage" class="text-muted" style="display: none;">Maximum 500 characters
                        allowed</small>
                </div>

                <div class="form-group">
                    <label for="information">{{ trans('cruds.soList.fields.information') }}</label>
                    <textarea class="form-control ckeditor {{ $errors->has('information') ? 'is-invalid' : '' }}" name="information"
                        id="information">{!! old('information', $soList->information) !!}</textarea>
                    @if ($errors->has('information'))
                        <span class="text-danger">This field is required.</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.soList.fields.information_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="anniversary_date">Date of Anniversary</label>
                    <input class="form-control date {{ $errors->has('anniversary_date') ? 'is-invalid' : '' }}"
                        type="text" name="anniversary_date" id="anniversary_date"
                        value="{{ old('anniversary_date', $soList->anniversary_date) }}" required>
                    @if ($errors->has('anniversary_date'))
                        <span class="text-danger">This field is required.</span>
                    @endif
                    {{-- <span class="help-block">{{ trans('cruds.soList.fields.anniversary_date_helper') }}</span> --}}
                </div>
                {{-- <div class="form-group">
                <label for="expired_at">{{ trans('cruds.soList.fields.expired_at') }}</label>
                <input class="form-control date {{ $errors->has('expired_at') ? 'is-invalid' : '' }}" type="text" name="expired_at" id="expired_at" value="{{ old('expired_at', $soList->expired_at) }}">
                @if ($errors->has('expired_at'))
                    <span class="text-danger">{{ $errors->first('expired_at') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.soList.fields.expired_at_helper') }}</span>
            </div> --}}


                <div class="form-group">
                    <label for="created_by_id">Organization President</label>
                    <select class="form-control select2 {{ $errors->has('created_by') ? 'is-invalid' : '' }}"
                        name="created_by_id" id="created_by_id" required>
                        @foreach ($created_bies as $id => $entry)
                            @if ($id != '')
                                <option value="{{ $id }}"
                                    {{ (old('created_by_id') ? old('created_by_id') : $soList->created_by->id ?? '') == $id ? 'selected' : '' }}>
                                    {{ $entry }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                    @if ($errors->has('created_by'))
                        <span class="text-danger">This field is required.</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.soList.fields.created_by_helper') }}</span>
                </div>

                {{-- <div class="form-group">
                <div class="form-check {{ $errors->has('approve') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="approve" value="0">
                    <input class="form-check-input" type="checkbox" name="approve" id="approve" value="1" {{ $soList->approve || old('approve', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="approve">{{ trans('cruds.soList.fields.approve') }}</label>
                </div>
                @if ($errors->has('approve'))
                    <span class="text-danger">{{ $errors->first('approve') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.soList.fields.approve_helper') }}</span>
            </div> --}}

            <div class="form-group">
                <label for="adviser">Name of Adviser</label>
                <input class="form-control {{ $errors->has('adviser') ? 'is-invalid' : '' }}" type="text"
                    name="adviser" id="adviser" value="{{ old('adviser', $soList->adviser) }}" required>
                @if ($errors->has('adviser'))
                    <span class="text-danger">This field is required.</span>
                @endif
            </div>

            <div class="form-group">
                <label for="adviserEmail">Email of Adviser</label>
                <input class="form-control {{ $errors->has('adviserEmail') ? 'is-invalid' : '' }}" type="text"
                    name="adviserEmail" id="adviserEmail" value="{{ old('adviserEmail', $soList->adviserEmail) }}" required>
                @if ($errors->has('adviserEmail'))
                    <span class="text-danger">This field is required.</span>
                @endif
            </div>

            <div class="form-group">
                <label for="adviserCollege">College of Adviser</label>
                <input class="form-control {{ $errors->has('adviserCollege') ? 'is-invalid' : '' }}" type="text"
                    name="adviserCollege" id="adviserCollege" value="{{ old('adviserCollege', $soList->adviserCollege) }}" required>
                @if ($errors->has('adviserCollege'))
                    <span class="text-danger">This field is required.</span>
                @endif
            </div>

            <div class="form-group">
                <label for="adviserYears"> Number of Years as Adviser</label>
                <input class="form-control {{ $errors->has('adviserYears') ? 'is-invalid' : '' }}" type="text"
                    name="adviserYears" id="adviserYears" value="{{ old('adviserYears', $soList->adviserYears) }}" required>
                @if ($errors->has('adviserYears'))
                    <span class="text-danger">This field is required.</span>
                @endif
            </div>

            <div class="form-group">
                <label for="adviserField">Adviser's Major Field of Specialization</label>
                <input class="form-control {{ $errors->has('adviserField') ? 'is-invalid' : '' }}" type="text"
                    name="adviserField" id="adviserField" value="{{ old('adviserField', $soList->adviserField) }}" required>
                @if ($errors->has('adviserField'))
                    <span class="text-danger">This field is required.</span>
                @endif
            </div>

                @if ($soList->remark)
                    <div class="form-group">
                        <label for="remark">{{ trans('cruds.soList.fields.remark') }}s</label>
                        <input class="form-control {{ $errors->has('remark') ? 'is-invalid' : '' }}" type="text"
                            name="remark" id="remark" value="{{ old('remark', $soList->remark) }}">
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
                    // Check if there are any validation errors
                    var validationErrors = $('.text-danger').length > 0;

                    // If there are validation errors, prevent form submission
                    if (validationErrors) {
                        event.preventDefault();

                        // Scroll to the profile picture section
                        $('html, body').animate({
                            scrollTop: $("#banner-dropzone").offset().top
                        }, 100);
                    } else {
                        // If there are no errors, remove the error message
                        $('.text-danger').remove();
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

            document.getElementById('overview').addEventListener('input', function() {
                var overviewLength = this.value.length;
                var characterLimitMessage = document.getElementById('characterLimitMessage');
                if (overviewLength > 500) {
                    characterLimitMessage.style.display = 'block';
                } else {
                    characterLimitMessage.style.display = 'none';
                }
            });
        });
    </script>
@endsection
