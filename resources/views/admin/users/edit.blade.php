@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header" style="background-color: #005600; color:white;">
            <strong>EDIT USER</strong>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.users.update', [$user->id]) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label for="profile">{{ trans('cruds.user.fields.profile') }} <small>(2x2 Picture)</small></label>
                    <div class="needsclick dropzone {{ $errors->has('profile') ? 'is-invalid' : '' }}" id="profile-dropzone">
                    </div>
                    @if ($errors->has('profile'))
                        <span class="text-danger">{{ $errors->first('profile') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.user.fields.profile_helper') }}</span>
                    <span class="text-muted" style="font-size: small;">Image must not exceed 1 MB in size</span>
                </div>
                <div class="form-group">
                    <label class="required" for="name">{{ trans('cruds.user.fields.name') }} <small>(Last Name, First
                            Name, M.I.)</small></label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name"
                        id="name" value="{{ old('name', $user->name) }}" required>
                    @if ($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.user.fields.name_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="email">{{ trans('cruds.user.fields.email') }} <small>(CLSU Email
                            Address)</small></label>
                    <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email"
                        name="email" id="email" value="{{ old('email', $user->email) }}" required>
                    @if ($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.user.fields.email_helper') }}</span>
                </div>
                @if ($user->roles->contains(3))
                    <div class="form-group">
                        <label class="required" for="so_name">SO Name</label>
                        <input class="form-control {{ $errors->has('so_name') ? 'is-invalid' : '' }}" type="so_namel"
                            name="so_name" id="so_name" value="{{ old('so_name', $user->so_name) }}" required>
                        @if ($errors->has('so_name'))
                            <span class="text-danger">{{ $errors->first('so_name') }}</span>
                        @endif
                    </div>
                @endif
                {{-- <div class="form-group">
                <label class="required" for="password">{{ trans('cruds.user.fields.password') }}</label>
                <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password" name="password" id="password">
                @if ($errors->has('password'))
                    <span class="text-danger">{{ $errors->first('password') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.password_helper') }}</span>
            </div> --}}
                <div class="form-group">
                    <label class="required" for="roles">{{ trans('cruds.user.fields.roles') }}</label>
                    <select class="form-control select2 {{ $errors->has('roles') ? 'is-invalid' : '' }}" name="roles[]"
                        id="roles" required>
                        @foreach ($roles as $id => $role)
                            @if ($id != 1)
                                <option value="{{ $id }}"
                                    {{ in_array($id, old('roles', [$user->roles->first()->id ?? ''])) || $user->roles->contains($id) ? 'selected' : '' }}>
                                    {{ $role }}</option>
                            @endif
                        @endforeach
                    </select>
                    @if ($errors->has('roles'))
                        <span class="text-danger">{{ $errors->first('roles') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.user.fields.roles_helper') }}</span>
                </div>

                {{-- <div class="form-group">
                <label for="created_by_id">{{ trans('cruds.user.fields.created_by') }}</label>
                <select class="form-control select2 {{ $errors->has('created_by') ? 'is-invalid' : '' }}" name="created_by_id" id="created_by_id">
                    @foreach ($created_bies as $id => $entry)
                        <option value="{{ $id }}" {{ (old('created_by_id') ? old('created_by_id') : $user->created_by->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if ($errors->has('created_by'))
                    <span class="text-danger">{{ $errors->first('created_by') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.created_by_helper') }}</span>
            </div> --}}
                @if ($user->roles->contains(3))
                    <div class="form-group">
                        <label>{{ trans('cruds.user.fields.gender') }}</label>
                        <select class="form-control {{ $errors->has('gender') ? 'is-invalid' : '' }}" name="gender"
                            id="gender" required>
                            <option value disabled {{ old('gender', null) === null ? 'selected' : '' }}>
                                {{ trans('global.pleaseSelect') }}</option>
                            @foreach (App\Models\User::GENDER_SELECT as $key => $label)
                                <option value="{{ $key }}"
                                    {{ old('gender', $user->gender) === (string) $key ? 'selected' : '' }}>
                                    {{ $label }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('gender'))
                            <span class="text-danger">{{ $errors->first('gender') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.gender_helper') }}</span>
                    </div>

                    <div class="form-group">
                        <label for="course">{{ trans('cruds.user.fields.course') }}</label>
                        <select class="form-control {{ $errors->has('course') ? 'is-invalid' : '' }}" name="course" id="course" required>
                            <option value="" disabled>Select Course</option>
                            @foreach(\App\Models\User::COURSE_SELECT as $key => $value)
                                <option value="{{ $key }}" {{ old('course', $user->course) == $key ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('course'))
                            <span class="text-danger">{{ $errors->first('course') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.course_helper') }}</span>
                    </div>
                    

                    <div class="form-group">
                        <label>{{ trans('cruds.user.fields.year') }}</label>
                        <select class="form-control {{ $errors->has('year') ? 'is-invalid' : '' }}" name="year"
                            id="year" required>
                            <option value disabled {{ old('year', null) === null ? 'selected' : '' }}>
                                {{ trans('global.pleaseSelect') }}</option>
                            @foreach (App\Models\User::YEAR_SELECT as $key => $label)
                                <option value="{{ $key }}"
                                    {{ old('year', $user->year) === (string) $key ? 'selected' : '' }}>{{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('year'))
                            <span class="text-danger">{{ $errors->first('year') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.year_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="religion">{{ trans('cruds.user.fields.religion') }}</label>
                        <input class="form-control {{ $errors->has('religion') ? 'is-invalid' : '' }}" type="text"
                            name="religion" id="religion" value="{{ old('religion', $user->religion) }}" required>
                        @if ($errors->has('religion'))
                            <span class="text-danger">{{ $errors->first('religion') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.religion_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="nationality">{{ trans('cruds.user.fields.nationality') }}</label>
                        <input class="form-control {{ $errors->has('nationality') ? 'is-invalid' : '' }}" type="text"
                            name="nationality" id="nationality" value="{{ old('nationality', $user->nationality) }}" required>
                        @if ($errors->has('nationality'))
                            <span class="text-danger">{{ $errors->first('nationality') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.nationality_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="birthdate">{{ trans('cruds.user.fields.birthdate') }}
                            <small>(YYYY-MM-DD)</small></label>
                        <input class="form-control date {{ $errors->has('birthdate') ? 'is-invalid' : '' }}" type="text"
                            name="birthdate" id="birthdate" value="{{ old('birthdate', $user->birthdate) }}" required>
                        @if ($errors->has('birthdate'))
                            <span class="text-danger">{{ $errors->first('birthdate') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.birthdate_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="birthplace">{{ trans('cruds.user.fields.birthplace') }} <small>(Municipality/City,
                                Province)</small></label>
                        <input class="form-control {{ $errors->has('birthplace') ? 'is-invalid' : '' }}" type="text"
                            name="birthplace" id="birthplace" value="{{ old('birthplace', $user->birthplace) }}" required>
                        @if ($errors->has('birthplace'))
                            <span class="text-danger">{{ $errors->first('birthplace') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.birthplace_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="present_address">{{ trans('cruds.user.fields.present_address') }} <small>(Street,
                                Barangay, Municipality/City, Province, Zip Code)</small></label>
                        <input class="form-control {{ $errors->has('present_address') ? 'is-invalid' : '' }}"
                            type="text" name="present_address" id="present_address"
                            value="{{ old('present_address', $user->present_address) }}" required>
                        @if ($errors->has('present_address'))
                            <span class="text-danger">{{ $errors->first('present_address') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.present_address_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="home_address">{{ trans('cruds.user.fields.home_address') }} <small>(Street, Barangay,
                                Municipality/City, Province, Zip Code)</small></label>
                        <input class="form-control {{ $errors->has('home_address') ? 'is-invalid' : '' }}" type="text"
                            name="home_address" id="home_address"
                            value="{{ old('home_address', $user->home_address) }}" required>
                        @if ($errors->has('home_address'))
                            <span class="text-danger">{{ $errors->first('home_address') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.home_address_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="contact_no">{{ trans('cruds.user.fields.contact_no') }}</label>
                        <input class="form-control {{ $errors->has('contact_no') ? 'is-invalid' : '' }}" type="text"
                            name="contact_no" id="contact_no" value="{{ old('contact_no', $user->contact_no) }}" required>
                        @if ($errors->has('contact_no'))
                            <span class="text-danger">{{ $errors->first('contact_no') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.contact_no_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="father_name">{{ trans('cruds.user.fields.father_name') }} <small>(Last Name, First
                                Name, M.I.)</small></label>
                        <input class="form-control {{ $errors->has('father_name') ? 'is-invalid' : '' }}" type="text"
                            name="father_name" id="father_name" value="{{ old('father_name', $user->father_name) }}" required>
                        @if ($errors->has('father_name'))
                            <span class="text-danger">{{ $errors->first('father_name') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.father_name_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="father_contact_no">{{ trans('cruds.user.fields.father_contact_no') }}</label>
                        <input class="form-control {{ $errors->has('father_contact_no') ? 'is-invalid' : '' }}"
                            type="text" name="father_contact_no" id="father_contact_no"
                            value="{{ old('father_contact_no', $user->father_contact_no) }}" required>
                        @if ($errors->has('father_contact_no'))
                            <span class="text-danger">{{ $errors->first('father_contact_no') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.father_contact_no_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="mother_name">{{ trans('cruds.user.fields.mother_name') }} <small>(Last Name, First
                                Name, M.I.)</small></label>
                        <input class="form-control {{ $errors->has('mother_name') ? 'is-invalid' : '' }}" type="text"
                            name="mother_name" id="mother_name" value="{{ old('mother_name', $user->mother_name) }}" required>
                        @if ($errors->has('mother_name'))
                            <span class="text-danger">{{ $errors->first('mother_name') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.mother_name_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="mothers_contact_no">{{ trans('cruds.user.fields.mothers_contact_no') }}</label>
                        <input class="form-control {{ $errors->has('mothers_contact_no') ? 'is-invalid' : '' }}"
                            type="text" name="mothers_contact_no" id="mothers_contact_no"
                            value="{{ old('mothers_contact_no', $user->mothers_contact_no) }}" required>
                        @if ($errors->has('mothers_contact_no'))
                            <span class="text-danger">{{ $errors->first('mothers_contact_no') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.mothers_contact_no_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label
                            for="source_of_financial_support">{{ trans('cruds.user.fields.source_of_financial_support') }}</label>
                        <input class="form-control {{ $errors->has('source_of_financial_support') ? 'is-invalid' : '' }}"
                            type="text" name="source_of_financial_support" id="source_of_financial_support"
                            value="{{ old('source_of_financial_support', $user->source_of_financial_support) }}" required>
                        @if ($errors->has('source_of_financial_support'))
                            <span class="text-danger">{{ $errors->first('source_of_financial_support') }}</span>
                        @endif
                        <span
                            class="help-block">{{ trans('cruds.user.fields.source_of_financial_support_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="talent_skills">{{ trans('cruds.user.fields.talent_skills') }}</label>
                        <input class="form-control {{ $errors->has('talent_skills') ? 'is-invalid' : '' }}"
                            type="text" name="talent_skills" id="talent_skills"
                            value="{{ old('talent_skills', $user->talent_skills) }}" required>
                        @if ($errors->has('talent_skills'))
                            <span class="text-danger">{{ $errors->first('talent_skills') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.talent_skills_helper') }}</span>
                    </div>
                @endif
                {{-- <div class="form-group">
                <label for="date_filed">{{ trans('cruds.user.fields.date_filed') }}</label>
                <input class="form-control date {{ $errors->has('date_filed') ? 'is-invalid' : '' }}" type="text" name="date_filed" id="date_filed" value="{{ old('date_filed', $user->date_filed) }}">
                @if ($errors->has('date_filed'))
                    <span class="text-danger">{{ $errors->first('date_filed') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.date_filed_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="approval_update_at">Approval Date</label>
                <input class="form-control date {{ $errors->has('approval_update_at') ? 'is-invalid' : '' }}" type="text" name="approval_update_at" id="approval_update_at" value="{{ old('approval_update_at', $user->approval_update_at) }}">
                @if ($errors->has('approval_update_at'))
                    <span class="text-danger">{{ $errors->first('approval_update_at') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.approval_update_at_helper') }}</span> --}}
                {{-- </div> --}}

                @if ($user->remark)
                    <div class="form-group">
                        <label for="remark">Remarks</label>
                        <input class="form-control {{ $errors->has('remark') ? 'is-invalid' : '' }}" type="text"
                            name="remark" id="remark" value="{{ old('remark', $user->remark) }}">
                        @if ($errors->has('remark'))
                            <span class="text-danger">{{ $errors->first('remark') }}</span>
                        @endif
                        {{-- <span class="help-block">{{ trans('cruds.user.fields.remark_helper') }}</span> --}}
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
        Dropzone.options.profileDropzone = {
            url: '{{ route('admin.users.storeMedia') }}',
            maxFilesize: 1, // MB
            acceptedFiles: '.jpeg,.jpg,.png',
            maxFiles: 1,
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 1,
                // width: 4096,
                // height: 4096
            },
            success: function(file, response) {
                $('form').find('input[name="profile"]').remove()
                $('form').append('<input type="hidden" name="profile" value="' + response.name + '">')
            },
            removedfile: function(file) {
                file.previewElement.remove()
                if (file.status !== 'error') {
                    $('form').find('input[name="profile"]').remove()
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
                    var acceptedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                    if (!acceptedTypes.includes(file.type)) {
                        $('#profile-dropzone').addClass('is-invalid');
                        $('#profile-dropzone').parent().append(
                            '<span class="text-danger">Only JPEG and PNG files are accepted. </span>'
                        );
                        return;
                    }

                    // Check if the file size exceeds 1MB
                    if (file.size > 1024 * 1024) {
                        $('#profile-dropzone').addClass('is-invalid');
                        $('#profile-dropzone').parent().append(
                            '<span class="text-danger">File size must not exceed 1 MB. </span>');
                        return;
                    }

                    // If more than one file is added, show an error message
                    if (myDropzone.files.length > 1) {
                        $('#profile-dropzone').addClass('is-invalid');
                        $('#profile-dropzone').parent().append(
                            '<span class="text-danger">Only one file is allowed. </span>'
                        );
                        myDropzone.removeFile(file); // Remove the invalid file
                        return;
                    }

                    // If file meets requirements, remove any error messages and classes
                    $('#profile-dropzone').removeClass('is-invalid');
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
                            scrollTop: $("#profile-dropzone").offset().top
                        }, 100);
                    } else {
                        // If there are no errors, remove the error message
                        $('.text-danger').remove();
                    }
                });

                @if (isset($user) && $user->profile)
                    var file = {!! json_encode($user->profile) !!}
                    this.options.addedfile.call(this, file)
                    this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="profile" value="' + file.file_name + '">')
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
