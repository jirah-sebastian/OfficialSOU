@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header" style="background-color: #005600; color:white;">
            <strong>EDIT ACTIVITY</strong>
        </div>


        <div class="card-body">
            {{-- <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.activities.show', $activity->id) }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div> --}}
            <form id="activityForm" method="POST" action="{{ route('admin.activities.update', [$activity->id]) }}"
                enctype="multipart/form-data">
                @method('PUT')
                @csrf
                {{-- <div class="form-group">
                    <label for="created_by_id">{{ trans('cruds.activity.fields.created_by') }}</label>
                    <select class="form-control select2 {{ $errors->has('created_by') ? 'is-invalid' : '' }}"
                        name="created_by_id" id="created_by_id" disabled>
                        @foreach ($created_bies as $id => $entry)
                            <option value="{{ $id }}"
                                {{ (old('created_by_id') ? old('created_by_id') : $activity->created_by->id ?? '') == $id ? 'selected' : '' }}>
                                {{ $entry }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('created_by'))
                        <span class="text-danger">{{ $errors->first('created_by') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.activity.fields.created_by_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="category_name">Cluster</label>
                    <input class="form-control" type="text" name="category_name" id="category_name"
                        value="{{ $activity->organization->so_category->category_name ?? '' }}" readonly>
                </div> --}}
                <div class="form-group">
                    <label class="required" for="title">{{ trans('cruds.activity.fields.title') }}</label>
                    <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text"
                        name="title" id="title" value="{{ old('title', $activity->title) }}" required>
                    @if ($errors->has('title'))
                        <span class="text-danger">This field is required.</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.activity.fields.title_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="sub_title">{{ trans('cruds.activity.fields.sub_title') }}</label>
                    <input class="form-control {{ $errors->has('sub_title') ? 'is-invalid' : '' }}" type="text"
                        name="sub_title" id="sub_title" value="{{ old('sub_title', $activity->sub_title) }}" required>
                    @if ($errors->has('sub_title'))
                        <span class="text-danger">This field is required.</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.activity.fields.sub_title_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="event_date">{{ trans('cruds.activity.fields.event_date') }}</label>
                    <input class="form-control datetime {{ $errors->has('event_date') ? 'is-invalid' : '' }}"
                        type="text" name="event_date" id="event_date"
                        value="{{ old('event_date', $activity->event_date) }}" required>
                    @if ($errors->has('event_date'))
                        <span class="text-danger">This field is required.</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.activity.fields.event_date_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="event_place">{{ trans('cruds.activity.fields.event_place') }}</label>
                    <input class="form-control {{ $errors->has('event_place') ? 'is-invalid' : '' }}" type="text"
                        name="event_place" id="event_place" value="{{ old('event_place', $activity->event_place) }}"
                        required>
                    @if ($errors->has('event_place'))
                        <span class="text-danger">This field is required.</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.activity.fields.event_place_helper') }}</span>
                </div>
                <div class="form-group">
                    <label>{{ trans('cruds.activity.fields.type_of_activity') }}</label>
                    <select class="form-control {{ $errors->has('type_of_activity') ? 'is-invalid' : '' }}"
                        name="type_of_activity" id="type_of_activity" required>
                        <option value disabled {{ old('type_of_activity', null) === null ? 'selected' : '' }}>
                            {{ trans('global.pleaseSelect') }}</option>
                        @foreach (App\Models\Activity::TYPE_OF_ACTIVITY_SELECT as $key => $label)
                            <option value="{{ $key }}"
                                {{ old('type_of_activity', $activity->type_of_activity) === (string) $key ? 'selected' : '' }}>
                                {{ $label }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('type_of_activity'))
                        <span class="text-danger">This field is required.</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.activity.fields.type_of_activity_helper') }}</span>
                </div>
                
                {{-- <div class="form-group">
                    <label for="sustainable_development_goal">{{ trans('cruds.activity.fields.sustainable_development_goal') }}</label>
                    <input class="form-control {{ $errors->has('sustainable_development_goal') ? 'is-invalid' : '' }}"
                        type="text" name="sustainable_development_goal" id="sustainable_development_goal"
                        value="{{ is_array($activity->sustainable_development_goal) ? '' : old('sustainable_development_goal', $activity->sustainable_development_goal) }}"
                        required>
                    @if ($errors->has('sustainable_development_goal'))
                        <span class="text-danger">This field is required.</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.activity.fields.sustainable_development_goal_helper') }}</span>
                </div> --}}
                

                <script>
                    function toggleSDGCheckboxes() {
                        var checkboxes = document.getElementById('sdg_checkboxes');
                        checkboxes.style.display = checkboxes.style.display === 'none' ? 'block' : 'none';
                    }
                
                    function updateSDGInput() {
                        var selected = [];
                        var checkboxes = document.querySelectorAll('#sdg_checkboxes input[type=checkbox]:checked');
                        checkboxes.forEach(function(checkbox) {
                            selected.push(checkbox.value);
                        });
                        document.getElementById('sustainable_development_goal').value = selected;
                        document.getElementById('sustainable_development_goal_display').value = selected.join(', ');
                    }
                
                    document.addEventListener('DOMContentLoaded', function() {
                        var selected = {!! json_encode(old('sustainable_development_goal', $activity->sustainable_development_goal)) !!};
                        var checkboxes = document.querySelectorAll('#sdg_checkboxes input[type=checkbox]');
                        checkboxes.forEach(function(checkbox) {
                            if (selected.includes(checkbox.value)) {
                                checkbox.checked = true;
                            }
                        });
                        document.getElementById('sustainable_development_goal_display').value = selected.join(', ');
                    });
                </script>
                
                <div class="form-group">
                    <label for="sustainable_development_goal_display">{{ trans('cruds.activity.fields.sustainable_development_goal') }}</label>
                    <input type="text" class="form-control pointer {{ $errors->has('sustainable_development_goal') ? 'is-invalid' : '' }}" 
                           id="sustainable_development_goal_display" onclick="toggleSDGCheckboxes()" placeholder="Select SDGs" required 
                           value="{{ old('sustainable_development_goal_display', $activity->sustainable_development_goal_display) }}" onkeydown="return false">
                    <input type="hidden" name="sustainable_development_goal[]" id="sustainable_development_goal" 
                           value="{{ json_encode(old('sustainable_development_goal', $activity->sustainable_development_goal)) }}">
                    
                    <div id="sdg_checkboxes"  style="display: none; border: 1px solid #ced4da; border-radius: 5px; padding: 10px;">
                        @foreach (App\Models\Activity::SUSTAINABLE_DEVELOPMENT_GOALS as $key => $label)
                            <label>
                                <input type="checkbox" name="sdg_checkbox[]" value="{{ $key }}" onclick="updateSDGInput()"> {{ $label }}
                            </label><br>
                        @endforeach
                    </div>
                    
                    @if ($errors->has('sustainable_development_goal'))
                        <span class="text-danger">{{ $errors->first('sustainable_development_goal') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.activity.fields.sustainable_development_goal_helper') }}</span>
                </div>
                












                
                <div class="form-group">
                    <label>Funding Source</label>
                    <select class="form-control" name="gad_funded">
                        <option value="" disabled {{ $activity->gad_funded ? '' : 'selected' }}>
                            {{ trans('global.pleaseSelect') }}</option>
                        <option value="GAD" {{ $activity->gad_funded === 'GAD' ? 'selected' : '' }}>GAD</option>
                        <option value="SDIA" {{ $activity->gad_funded === 'SDIA' ? 'selected' : '' }}>SDIA</option>
                        <option value="Others"
                            {{ $activity->gad_funded && !in_array($activity->gad_funded, ['GAD Funded', 'SDIA']) ? 'selected' : '' }}>
                            Others</option>
                    </select>
                    @if ($errors->has('gad_funded'))
                        <span class="text-danger">This field is required.</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="permit">{{ trans('cruds.activity.fields.permit') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('permit') ? 'is-invalid' : '' }}" id="permit-dropzone">
                    </div>
                    @if ($errors->has('permit'))
                        <span class="text-danger">This field is required.</span>
                    @endif
                    <span class="text-muted" style="font-size: small;">File must be in pdf and doesn't exceed 3 MB in
                        size</span>
                    <span class="help-block">{{ trans('cruds.activity.fields.permit_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="content_photo">{{ trans('cruds.activity.fields.content_photo') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('content_photo') ? 'is-invalid' : '' }}"
                        id="content_photo-dropzone">
                    </div>
                    @if ($errors->has('content_photo'))
                        <span class="text-danger">This field is required.</span>
                    @endif
                    <span class="text-muted" style="font-size: small;">Image must not exceed 5 MB in size</span>
                    <span class="help-block">{{ trans('cruds.activity.fields.content_photo_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="content">{{ trans('cruds.activity.fields.content') }}</label>
                    <textarea class="form-control ckeditor {{ $errors->has('content') ? 'is-invalid' : '' }}" name="content"
                        id="content">{!! old('content', $activity->content) !!}</textarea>
                    @if ($errors->has('content'))
                        <span class="text-danger">This field is required.</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.activity.fields.content_helper') }}</span>
                </div>

                @if (!auth()->user()->is_pres)
                    {{-- <div class="form-group">
                <label>{{ trans('cruds.activity.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status" @if (auth()->user()->is_pres)
                    disable
                @endif>
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach (App\Models\Activity::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', $activity->status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if ($errors->has('status'))
                    <span class="text-danger">{{ $errors->first('status') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.activity.fields.status_helper') }}</span>
            </div> --}}
                @endif

                @if ($activity->remarks)
                    <div class="form-group">
                        <label for="remarks">{{ trans('cruds.activity.fields.remarks') }}</label>
                        <input class="form-control {{ $errors->has('remarks') ? 'is-invalid' : '' }}" type="text"
                            name="remarks" id="remarks" value="{{ old('remarks', $activity->remarks) }}">
                        @if ($errors->has('remarks'))
                            <span class="text-danger">{{ $errors->first('remarks') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.activity.fields.remarks_helper') }}</span>
                    </div>
                @endif

                {{-- <div class="form-group">
                    <label for="organization_id">{{ trans('cruds.activity.fields.organization') }}</label>
                    <select class="form-control select2 {{ $errors->has('organization') ? 'is-invalid' : '' }}"
                        name="organization_id" id="organization_id" disabled>
                        @foreach ($organizations as $id => $entry)
                            <option value="{{ $id }}"
                                {{ (old('organization_id') ? old('organization_id') : $activity->organization->id ?? '') == $id ? 'selected' : '' }}>
                                {{ $entry }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('organization'))
                        <span class="text-danger">{{ $errors->first('organization') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.activity.fields.organization_helper') }}</span>
                </div>
                 --}}
                <div class="form-group">
                    <button class="btn btn-success" name="action" value="save" type="submit">
                        <i class="fas fa-save"></i><b> {{ trans('global.save') }}</b>
                    </button>
                    {{-- @if (!auth()->user()->is_pres && $activity->status == 'Pending')
                    <button class="btn btn-success" name="action" value="approve" type="submit">Approve</button>
                    <button class="btn btn-danger" name="action" value="reject" type="submit">Reject</button>
                 @endif
                 @if (!auth()->user()->is_pres)
                 @if ($activity->status != 'Archived' && !$activity->deleted_at)
                 <button class="btn btn-danger" name="action" value="delete" type="submit" id="delete">Archive</button>
                 @endif
                 @if ($activity->deleted_at)
                 <button class="btn btn-success" name="action" value="restore" type="submit" id="restore">Retore</button>
                 @endif
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
                                            '{{ route('admin.activities.storeCKEditorImages') }}',
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
                                        data.append('crud_id', '{{ $activity->id ?? 0 }}');
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
        Dropzone.options.permitDropzone = {
            url: '{{ route('admin.activities.storeMedia') }}',
            maxFilesize: 3, // MB
            acceptedFiles: '.pdf',
            maxFiles: 1,
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 2
            },
            success: function(file, response) {
                $('form').find('input[name="permit"]').remove()
                $('form').append('<input type="hidden" name="permit" value="' + response.name + '">')
            },
            removedfile: function(file) {
                file.previewElement.remove()
                if (file.status !== 'error') {
                    $('form').find('input[name="permit"]').remove()
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
                    var acceptedTypes = ['application/pdf'];
                    if (!acceptedTypes.includes(file.type)) {
                        $('#permit-dropzone').addClass('is-invalid');
                        $('#permit-dropzone').parent().append(
                            '<span class="text-danger">Only PDF file is accepted. </span>'
                        );
                        return;
                    }

                    // Check if the file size exceeds 1MB
                    if (file.size > 3 * 1024 * 1024) {
                        $('#permit-dropzone').addClass('is-invalid');
                        $('#permit-dropzone').parent().append(
                            '<span class="text-danger">File size must not exceed 3 MB. </span>');
                        return;
                    }

                    // If more than one file is added, show an error message
                    if (myDropzone.files.length > 1) {
                        $('#permit-dropzone').addClass('is-invalid');
                        $('#permit-dropzone').parent().append(
                            '<span class="text-danger">Only one file is allowed. </span>'
                        );
                        myDropzone.removeFile(file); // Remove the invalid file
                        return;
                    }

                    // If file meets requirements, remove any error messages and classes
                    $('#permit-dropzone').removeClass('is-invalid');
                });


                @if (isset($activity) && $activity->permit)
                    var file = {!! json_encode($activity->permit) !!}
                    this.options.addedfile.call(this, file)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="permit" value="' + file.file_name + '">')
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

        Dropzone.options.contentPhotoDropzone = {
            url: '{{ route('admin.activities.storeMedia') }}',
            maxFilesize: 5, // MB
            acceptedFiles: '.jpeg,.jpg,.png',
            maxFiles: 1,
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 5,
                // width: 4096,
                // height: 4096
            },
            success: function(file, response) {
                $('form').find('input[name="content_photo"]').remove()
                $('form').append('<input type="hidden" name="content_photo" value="' + response.name + '">')
            },
            removedfile: function(file) {
                file.previewElement.remove()
                if (file.status !== 'error') {
                    $('form').find('input[name="content_photo"]').remove()
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
                        $('#content_photo-dropzone').addClass('is-invalid');
                        $('#content_photo-dropzone').parent().append(
                            '<span class="text-danger">Only JPEG and PNG file is accepted. </span>'
                        );
                        return;
                    }

                    // Check if the file size exceeds 1MB
                    if (file.size > 5 * 1024 * 1024) {
                        $('#content_photo-dropzone').addClass('is-invalid');
                        $('#content_photo-dropzone').parent().append(
                            '<span class="text-danger">File size must not exceed 1 MB. </span>');
                        return;
                    }

                    // If more than one file is added, show an error message
                    if (myDropzone.files.length > 1) {
                        $('#content_photo-dropzone').addClass('is-invalid');
                        $('#content_photo-dropzone').parent().append(
                            '<span class="text-danger">Only one file is allowed. </span>'
                        );
                        myDropzone.removeFile(file); // Remove the invalid file
                        return;
                    }

                    // If file meets requirements, remove any error messages and classes
                    $('#content_photo-dropzone').removeClass('is-invalid');
                });


                @if (isset($activity) && $activity->content_photo)
                    var file = {!! json_encode($activity->content_photo) !!}
                    this.options.addedfile.call(this, file)
                    this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="content_photo" value="' + file.file_name + '">')
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

<style>
    .pointer {
        cursor: pointer;
    }
</style>
@endsection
