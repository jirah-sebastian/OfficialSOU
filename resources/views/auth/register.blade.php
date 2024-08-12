@extends('sois.layouts.app')
@section('content')
    <div class="page-title">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-xs-12">
                    <span class="page-title-text">Register</span>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="page-content-items">
            <div class="row">
                <div id="au-about" class="section-title col-xl-12 col-md-12 col-xs-12">
                    <span></span>
                </div>
            </div>

            <div class="row">
                <div class="page-cont section-cont col-xl-12 col-md-12 col-xs-12">
                    <div class="flexbox-gen left m-b-2">
                        <div class="column dp-xs-none">
                            <div class="img-wrapper-black-sub">
                                <img style="display: block;
                                height: 400px;
                                width: 400px;
                                margin-left: auto;
                                margin-right: auto;"
                                    src="../assets/img/sou/sou logo.png">
                                <p class="caption">CLSU Main Gate</p>
                            </div>
                        </div>

                        <div class="column p-5">
                            <div class="text-wrapper">
                                <h1> Student Organization </h1>

                                <p class="text-muted">Only Student Organization Presidents can Register for an Account</p>

                                @if (session('message'))
                                    <div class="alert alert-info" role="alert">
                                        {{ session('message') }}
                                    </div>
                                @endif

                                <form id="regForm" method="POST" action="{{ route('register') }}">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="profile">{{ trans('cruds.user.fields.profile') }} <small>(2x2
                                                Picture)</small></label>
                                        <div class="needsclick dropzone {{ $errors->has('profile') ? 'is-invalid' : '' }}"
                                            id="profile-dropzone">
                                            <input type="file" name="profile" id="profile" style="display: none;">
                                        </div>
                                        @if ($errors->has('profile'))
                                            <span class="text-danger">{{ $errors->first('profile') }}</span>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.user.fields.profile_helper') }}</span>
                                        <span class="text-muted" style="font-size: small;">Image must not exceed 1 MB in
                                            size</span>
                                    </div>


                                    <div class="form-group">
                                        <label for="email">{{ trans('global.user_name') }} <small>(Last Name, First Name,
                                                M.I.)</small></label>
                                        <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                            type="text" name="name" id="name" value="{{ old('name') }}"
                                            required>
                                        @if ($errors->has('name'))
                                            @if ($errors->first('name') === 'The name field is required.')
                                                <span class="text-danger">This field is required.</span>
                                            @else
                                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                            @endif
                                        @endif

                                    </div>
                                    <div class="form-group">
                                        <label for="email">{{ trans('global.login_email') }} <small>(CLSU Email
                                                Address)</small></label>
                                        <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                            type="email" name="email" id="email" value="{{ old('email') }}"
                                            required>
                                        @if ($errors->has('email'))
                                            @if ($errors->first('email') === 'The email field is required.')
                                                <span class="text-danger">This field is required.</span>
                                            @else
                                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                            @endif
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="so_name">Student Organization</label>
                                        <input class="form-control {{ $errors->has('so_name') ? 'is-invalid' : '' }}"
                                            type="text" name="so_name" id="so_name" value="{{ old('so_name') }}"
                                            required>
                                        @if ($errors->has('so_name'))
                                            @if ($errors->first('so_name') === 'The so name field is required.')
                                                <span class="text-danger">This field is required.</span>
                                            @else
                                                <span class="text-danger">{{ $errors->first('so_name') }}</span>
                                            @endif
                                        @endif
                                    </div>

                                    {{-- <div class="form-group">
                                        <label for="course">{{ trans('cruds.user.fields.course') }}</label>
                                        <input class="form-control {{ $errors->has('course') ? 'is-invalid' : '' }}"
                                            type="text" name="course" id="course" value="{{ old('course') }}"
                                            required>
                                        @if ($errors->has('course'))
                                            @if ($errors->first('course') === 'The course field is required.')
                                                <span class="text-danger">This field is required.</span>
                                            @else
                                                <span class="text-danger">{{ $errors->first('course') }}</span>
                                            @endif
                                        @endif
                                        <span class="help-block">{{ trans('cruds.user.fields.course_helper') }}</span>
                                        <span class="text-muted" style="font-size: small;">Do not abbreviate course.</span>
                                    </div>
                                     --}}

                                     <div class="form-group">
                                        <label for="course">{{ trans('cruds.user.fields.course') }}</label>
                                        <select class="form-control pointer {{ $errors->has('course') ? 'is-invalid' : '' }}" name="course" id="course" required>
                                            <option value="" disabled selected>{{ trans('global.pleaseSelect') }}</option>
                                            @foreach(\App\Models\User::COURSE_SELECT as $key => $value)
                                                <option value="{{ $key }}" {{ old('course') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('course'))
                                            @if ($errors->first('course') === 'The course field is required.')
                                                <span class="text-danger">This field is required.</span>
                                            @else
                                                <span class="text-danger">{{ $errors->first('course') }}</span>
                                            @endif
                                        @endif
                                        <span class="help-block">{{ trans('cruds.user.fields.course_helper') }}</span>
                                    
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>{{ trans('cruds.user.fields.year') }}</label>
                                        <select class="form-control {{ $errors->has('year') ? 'is-invalid' : '' }}"
                                            name="year" id="year" required>
                                            <option value disabled {{ old('year', null) === null ? 'selected' : '' }}>
                                                {{ trans('global.pleaseSelect') }}</option>
                                            @foreach (App\Models\User::YEAR_SELECT as $key => $label)
                                                <option value="{{ $key }}">{{ $label }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('year'))
                                            @if ($errors->first('year') === 'The year field is required.')
                                                <span class="text-danger">This field is required.</span>
                                            @else
                                                <span class="text-danger">{{ $errors->first('year') }}</span>
                                            @endif
                                        @endif
                                        <span class="help-block">{{ trans('cruds.user.fields.year_helper') }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label>{{ trans('cruds.user.fields.gender') }}</label>
                                        <select class="form-control {{ $errors->has('gender') ? 'is-invalid' : '' }}"
                                            name="gender" id="gender" required>
                                            <option value disabled {{ old('gender', null) === null ? 'selected' : '' }}>
                                                {{ trans('global.pleaseSelect') }}</option>
                                            @foreach (App\Models\User::GENDER_SELECT as $key => $label)
                                                <option value="{{ $key }}">{{ $label }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('gender'))
                                            @if ($errors->first('gender') === 'The gender field is required.')
                                                <span class="text-danger">This field is required.</span>
                                            @else
                                                <span class="text-danger">{{ $errors->first('gender') }}</span>
                                            @endif
                                        @endif
                                        <span class="help-block">{{ trans('cruds.user.fields.gender_helper') }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="religion">{{ trans('cruds.user.fields.religion') }}</label>
                                        <input class="form-control {{ $errors->has('religion') ? 'is-invalid' : '' }}"
                                            type="text" name="religion" id="religion" value="{{ old('religion') }}"
                                            required>
                                        @if ($errors->has('religion'))
                                            @if ($errors->first('religion') === 'The religion field is required.')
                                                <span class="text-danger">This field is required.</span>
                                            @else
                                                <span class="text-danger">{{ $errors->first('religion') }}</span>
                                            @endif
                                        @endif
                                        <span class="help-block">{{ trans('cruds.user.fields.religion_helper') }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="nationality">{{ trans('cruds.user.fields.nationality') }}</label>
                                        <input class="form-control {{ $errors->has('nationality') ? 'is-invalid' : '' }}"
                                            type="text" name="nationality" id="nationality"
                                            value="{{ old('nationality') }}" required>
                                        @if ($errors->has('nationality'))
                                            @if ($errors->first('nationality') === 'The nationality field is required.')
                                                <span class="text-danger">This field is required.</span>
                                            @else
                                                <span class="text-danger">{{ $errors->first('nationality') }}</span>
                                            @endif
                                        @endif
                                        <span
                                            class="help-block">{{ trans('cruds.user.fields.nationality_helper') }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="birthdate">{{ trans('cruds.user.fields.birthdate') }}
                                            <small>(YYYY-MM-DD)</small></label>
                                        <input
                                            class="form-control date {{ $errors->has('birthdate') ? 'is-invalid' : '' }}"
                                            type="text" name="birthdate" id="birthdate"
                                            value="{{ old('birthdate') }}" required>
                                        @if ($errors->has('birthdate'))
                                            @if ($errors->first('birthdate') === 'The birthdate field is required.')
                                                <span class="text-danger">This field is required.</span>
                                            @else
                                                <span class="text-danger">{{ $errors->first('birthdate') }}</span>
                                            @endif
                                        @endif
                                        <span class="help-block">{{ trans('cruds.user.fields.birthdate_helper') }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="birthplace">{{ trans('cruds.user.fields.birthplace') }}
                                            <small>(Municipality/City, Province)</small></label>
                                        <input class="form-control {{ $errors->has('birthplace') ? 'is-invalid' : '' }}"
                                            type="text" name="birthplace" id="birthplace"
                                            value="{{ old('birthplace') }}" required>
                                        @if ($errors->has('birthplace'))
                                            @if ($errors->first('birthplace') === 'The birthplace field is required.')
                                                <span class="text-danger">This field is required.</span>
                                            @else
                                                <span class="text-danger">{{ $errors->first('birthplace') }}</span>
                                            @endif
                                        @endif
                                        <span class="help-block">{{ trans('cruds.user.fields.birthplace_helper') }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="present_address">{{ trans('cruds.user.fields.present_address') }}
                                            <small>(Street, Barangay, Municipality/City, Province, Zip Code)</small></label>
                                        <input
                                            class="form-control {{ $errors->has('present_address') ? 'is-invalid' : '' }}"
                                            type="text" name="present_address" id="present_address"
                                            value="{{ old('present_address') }}" required>
                                        @if ($errors->has('present_address'))
                                            @if ($errors->first('present_address') === 'The present address field is required.')
                                                <span class="text-danger">This field is required.</span>
                                            @else
                                                <span class="text-danger">{{ $errors->first('present_address') }}</span>
                                            @endif
                                        @endif
                                        <span
                                            class="help-block">{{ trans('cruds.user.fields.present_address_helper') }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="home_address">{{ trans('cruds.user.fields.home_address') }}
                                            <small>(Street, Barangay, Municipality/City, Province, Zip Code)</small></label>
                                        <input class="form-control {{ $errors->has('home_address') ? 'is-invalid' : '' }}"
                                            type="text" name="home_address" id="home_address"
                                            value="{{ old('home_address') }}" required>
                                        @if ($errors->has('home_address'))
                                            @if ($errors->first('home_address') === 'The home address field is required.')
                                                <span class="text-danger">This field is required.</span>
                                            @else
                                                <span class="text-danger">{{ $errors->first('home_address') }}</span>
                                            @endif
                                        @endif
                                        <span
                                            class="help-block">{{ trans('cruds.user.fields.home_address_helper') }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="contact_no">{{ trans('cruds.user.fields.contact_no') }}</label>
                                        <input class="form-control {{ $errors->has('contact_no') ? 'is-invalid' : '' }}"
                                            type="text" name="contact_no" id="contact_no"
                                            value="{{ old('contact_no') }}" required>
                                        @if ($errors->has('contact_no'))
                                            @if ($errors->first('contact_no') === 'The contact no field is required.')
                                                <span class="text-danger">This field is required.</span>
                                            @else
                                                <span class="text-danger">{{ $errors->first('contact_no') }}</span>
                                            @endif
                                        @endif
                                        <span class="help-block">{{ trans('cruds.user.fields.contact_no_helper') }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="father_name">{{ trans('cruds.user.fields.father_name') }} <small>(Last
                                                Name, First Name, M.I.)</small></label>
                                        <input class="form-control {{ $errors->has('father_name') ? 'is-invalid' : '' }}"
                                            type="text" name="father_name" id="father_name"
                                            value="{{ old('father_name') }}" required>
                                        @if ($errors->has('father_name'))
                                            @if ($errors->first('father_name') === 'The father name field is required.')
                                                <span class="text-danger">This field is required.</span>
                                            @else
                                                <span class="text-danger">{{ $errors->first('father_name') }}</span>
                                            @endif
                                        @endif
                                        <span
                                            class="help-block">{{ trans('cruds.user.fields.father_name_helper') }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label
                                            for="father_contact_no">{{ trans('cruds.user.fields.father_contact_no') }}</label>
                                        <input
                                            class="form-control {{ $errors->has('father_contact_no') ? 'is-invalid' : '' }}"
                                            type="text" name="father_contact_no" id="father_contact_no"
                                            value="{{ old('father_contact_no') }}" required>
                                        @if ($errors->has('father_contact_no'))
                                            @if ($errors->first('father_contact_no') === 'The father contact no field is required.')
                                                <span class="text-danger">This field is required.</span>
                                            @else
                                                <span class="text-danger">{{ $errors->first('father_contact_no') }}</span>
                                            @endif
                                        @endif
                                        <span
                                            class="help-block">{{ trans('cruds.user.fields.father_contact_no_helper') }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="mother_name">{{ trans('cruds.user.fields.mother_name') }} <small>(Last
                                                Name, First Name, M.I.)</small></label>
                                        <input class="form-control {{ $errors->has('mother_name') ? 'is-invalid' : '' }}"
                                            type="text" name="mother_name" id="mother_name"
                                            value="{{ old('mother_name') }}" required>
                                        @if ($errors->has('mother_name'))
                                            @if ($errors->first('mother_name') === 'The mother name field is required.')
                                                <span class="text-danger">This field is required.</span>
                                            @else
                                                <span class="text-danger">{{ $errors->first('mother_name') }}</span>
                                            @endif
                                        @endif
                                        <span
                                            class="help-block">{{ trans('cruds.user.fields.mother_name_helper') }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label
                                            for="mothers_contact_no">{{ trans('cruds.user.fields.mothers_contact_no') }}</label>
                                        <input
                                            class="form-control {{ $errors->has('mothers_contact_no') ? 'is-invalid' : '' }}"
                                            type="text" name="mothers_contact_no" id="mothers_contact_no"
                                            value="{{ old('mothers_contact_no') }}" required>
                                        @if ($errors->has('mothers_contact_no'))
                                            @if ($errors->first('mothers_contact_no') === 'The mother contact no field is required.')
                                                <span class="text-danger">This field is required.</span>
                                            @else
                                                <span
                                                    class="text-danger">{{ $errors->first('mothers_contact_no') }}</span>
                                            @endif
                                        @endif
                                        <span
                                            class="help-block">{{ trans('cruds.user.fields.mothers_contact_no_helper') }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label
                                            for="source_of_financial_support">{{ trans('cruds.user.fields.source_of_financial_support') }}</label>
                                        <input
                                            class="form-control {{ $errors->has('source_of_financial_support') ? 'is-invalid' : '' }}"
                                            type="text" name="source_of_financial_support"
                                            id="source_of_financial_support"
                                            value="{{ old('source_of_financial_support') }}" required>
                                        @if ($errors->has('source_of_financial_support'))
                                            @if ($errors->first('source_of_financial_support') === 'The source of financial support field is required.')
                                                <span class="text-danger">This field is required.</span>
                                            @else
                                                <span
                                                    class="text-danger">{{ $errors->first('source_of_financial_support') }}</span>
                                            @endif
                                        @endif
                                        <span
                                            class="help-block">{{ trans('cruds.user.fields.source_of_financial_support_helper') }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="talent_skills">{{ trans('cruds.user.fields.talent_skills') }}</label>
                                        <input
                                            class="form-control {{ $errors->has('talent_skills') ? 'is-invalid' : '' }}"
                                            type="text" name="talent_skills" id="talent_skills"
                                            value="{{ old('talent_skills') }}" required>
                                        @if ($errors->has('talent_skills'))
                                            @if ($errors->first('talent_skills') === 'The talent skills field is required.')
                                                <span class="text-danger">This field is required.</span>
                                            @else
                                                <span class="text-danger">{{ $errors->first('talent_skills') }}</span>
                                            @endif
                                        @endif
                                        <span
                                            class="help-block">{{ trans('cruds.user.fields.talent_skills_helper') }}</span>
                                    </div>

                                    <div class="form-group">
                                        <label for="password">{{ trans('global.login_password') }}</label>
                                        <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                            type="password" name="password" id="password"
                                            pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required
                                            value="{{ old('password') }}">
                                            <small id="passwordErrorMessage" class="text-muted" >
                                                Password must contain at least one digit, one lowercase letter, one uppercase
                                                letter, and be at least 8 characters long.
                                            </small>
                                            
                                        @if ($errors->has('password'))
                                            @if ($errors->first('password') === 'The password field is required.')
                                                <span class="text-danger">This field is required.</span>
                                            @else
                                                <span class="text-danger">{{ $errors->first('password') }}</span>
                                            @endif
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label
                                            for="password_confirmation">{{ trans('global.login_password_confirmation') }}</label>
                                        <input class="form-control" type="password" name="password_confirmation"
                                            id="password_confirmation" value="{{ old('password_confirmation') }}"
                                            required>
                                        <small id="passwordConfirmationError" class="text-danger" style="display: none;">
                                            Password confirmation does not match the password.
                                        </small>
                                    </div>
                                    <div class="form-group">
                                        <label for="date_filed">{{ trans('cruds.user.fields.date_filed') }}</label>
                                        <input
                                            class="form-control date {{ $errors->has('date_filed') ? 'is-invalid' : '' }}"
                                            type="text" name="date_filed" id="date_filed"
                                            value="{{ old('date_filed', date('Y-m-d')) }}" readonly>
                                        @if ($errors->has('date_filed'))
                                            <span class="text-danger">{{ $errors->first('date_filed') }}</span>
                                        @endif
                                        <span
                                            class="help-block">{{ trans('cruds.user.fields.date_filed_helper') }}</span>
                                    </div>

                                    <div class="form-group">
                                        <label for="privacy_policy" style="text-align: justify;">
                                            <input type="checkbox" id="privacy_policy" name="privacy_policy" required>
                                            By checking this box, I acknowledge that I consent to the collection and
                                            processing of my personal information in accordance with the Data Privacy Act
                                            (RA 10173) of the Philippines.
                                        </label>
                                    </div>


                                    <button class="btn btn-block btn-primary">
                                        {{ trans('global.register') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
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
        Dropzone.options.profileDropzone = {
            url: '{{ route('admin.users.storeMedia') }}',
            maxFilesize: 1, // MB
            acceptedFiles: '.jpeg,.jpg,.png',
            maxFiles: 1,
            addRemoveLinks: true,
            clickable: '#profile-dropzone', // Define the clickable area
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 1,
                //   width: 600,
                //   height: 600
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
                    // Check if profile picture is empty
                    if (myDropzone.getQueuedFiles().length === 0 && myDropzone.getAcceptedFiles().length ===
                        0) {
                        // Prevent form submission
                        event.preventDefault();

                        // Show error message only if not already shown
                        if (!errorMessageShown) {
                            $('#profile-dropzone').addClass('is-invalid');
                            // $('#profile-dropzone').parent().append(
                            //     '<span class="text-danger">Profile picture is required.</span>');
                            alert(
                                'Please make sure you filled all the fields and follow the correct format and requirements.'
                            );
                            errorMessageShown = true; // Set flag to true
                        }

                        // Scroll to the profile picture section
                        $('html, body').animate({
                            scrollTop: $("#profile-dropzone").offset().top
                        }, 100);
                    } else {
                        // Check if there are any other validation errors
                        var otherValidationErrors = $('.text-danger').not('#profile-dropzone').length > 0;

                        if (!otherValidationErrors) {
                            // If dropzone is not empty and there are no other errors, remove the error message
                            $('.text-danger').remove();
                        }
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
            success: function(file, response) {
                $('form').find('input[name="profile"]').remove()
                $('form').append('<input type="hidden" name="profile" value="' + response.name + '">')

                $('form').append('<img src="" alt="">')
            },
            removedfile: function(file) {
                file.previewElement.remove()
                if (file.status !== 'error') {
                    $('form').find('input[name="profile"]').remove()
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            error: function(file, response) {
                if ($.type(response) === 'string') {
                    var message = response; // Dropzone sends its own error messages as a string
                } else {
                    var message = response.errors.file;
                }
                file.previewElement.classList.add('dz-error');
                _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]');
                _results = [];
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    node = _ref[_i];
                    _results.push(node.textContent = message);
                }

                return _results;
            }
        };

        $(document).ready(function() {
            $('#password').on('input', function() {
                var password = $(this).val();
                var isValid = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/.test(password);
                var errorMessage = $('#passwordErrorMessage');

                if (isValid) {
                    $(this).removeClass('is-invalid');
                    errorMessage.hide();
                } else {
                    $(this).addClass('is-invalid');
                    errorMessage.show();
                }
            });

            $('#password_confirmation').on('input', function() {
                var password = $('#password').val();
                var confirmPassword = $(this).val();
                var passwordConfirmationError = $('#passwordConfirmationError');

                if (confirmPassword.length > 0 && password !== confirmPassword) {
                    passwordConfirmationError.show();
                } else {
                    passwordConfirmationError.hide();
                }
            });
        });


        // Function to show the confirmation modal
        function showConfirmationModal() {
            $('#confirmModal').modal('show'); // Show the confirmation modal
        }

        // Function to hide the confirmation modal
        function hideConfirmationModal() {
            $('#confirmModal').modal('hide'); // Hide the confirmation modal
        }

        // Function to check if dropzone is empty
        function isDropzoneEmpty() {
            // Check if dropzone has any files
            return ($('#profile-dropzone .dz-preview').length === 0);
        }

        // Add event listener to submit button
        $('form').submit(function(event) {
            // Check if all fields are filled
            var allFieldsFilled = true;
            $('input[type="text"], textarea').each(function() {
                if ($(this).val() === '') {
                    allFieldsFilled = false;
                    return false; // Exit the loop if any field is empty
                }
            });

            // Check if dropzone is empty
            var dropzoneEmpty = isDropzoneEmpty();

            // Check if there are any validation errors
            var validationErrors = $('.text-danger').length > 0;

            // Check if the course field meets the minimum character requirement
            var courseValid = $('#course').val().length >= 15;

            if (allFieldsFilled && !dropzoneEmpty && !validationErrors && courseValid) {
                event.preventDefault(); // Prevent default form submission
                showConfirmationModal(); // Call function to show confirmation modal
            } else {
                // Prevent form submission
                event.preventDefault();

                // If there are validation errors, scroll to the first error message
                if (validationErrors) {
                    var firstError = $('.text-danger').first();
                    $('html, body').animate({
                        scrollTop: firstError.offset()
                            .top // Scroll to the top position of the first error message
                    }, 1000);
                } else {
                    // Determine the type of error and show appropriate alert message
                    if (!allFieldsFilled) {
                        alert('Please fill in all fields.');
                    } else if (!courseValid) {
                        alert('Please ensure the course is not abbreviated.');
                    } else {
                        alert(
                            'Please make sure you filled all the fields and follow the correct format and requirements.'
                        );
                    }

                    // Find the first empty field
                    var firstEmptyField = $('input[type="text"], textarea').filter(function() {
                        return $(this).val() === '' || ($(this).attr('id') === 'course' && $(this).val()
                            .length < 15);
                    }).first();

                    // Scroll to the empty field with animation
                    $('html, body').animate({
                        scrollTop: firstEmptyField.offset()
                            .top // Scroll to the top position of the empty field
                    }, 100); // You can adjust the animation speed (1000 milliseconds = 1 second)
                }
            }
        });



        // Add event listener to confirm submit button in the modal
        $('#confirmSubmit').click(function() {
            hideConfirmationModal(); // Hide the modal
            $('#regForm').off('submit').submit(); // Submit the form
        });

        // Add event listener to cancel submit button in the modal
        $('#cancelSubmit').click(function() {
            hideConfirmationModal(); // Hide the modal
        });

        // Add event listener to close button
        $('#closeModalBtn').click(function() {
            hideConfirmationModal(); // Hide the modal
        });
    </script>
    <script>
        // Add the email validation script here
        $('#email').on('input', function() {
            var email = $(this).val();
            if (!isValidEmail(email)) {
                $(this).addClass('is-invalid');
                $(this).parent().find('.text-danger').remove();
                $(this).parent().append('<span class="text-danger">Invalid email address.</span>');
                // Scroll to the email input field
                $('html, body').animate({
                    scrollTop: $(this).offset().top - 100 // Adjust the offset as needed
                }, 100);
            } else {
                $(this).removeClass('is-invalid');
                $(this).parent().find('.text-danger').remove();
            }
        });

        function isValidEmail(email) {
           /* var emailRegex = /.*clsu2\.edu\.ph$/i; */
            return emailRegex.test(email);
        }

        // Add the course validation script here
        $('#course').on('input', function() {
            var course = $(this).val();
            if (course.length < 15) {
                $(this).addClass('is-invalid');
                $(this).parent().find('.text-danger').remove();
                $(this).parent().append('<span class="text-danger">Please follow the requested format.</span>');
                // Scroll to the course input field
                $('html, body').animate({
                    scrollTop: $(this).offset().top - 100 // Adjust the offset as needed
                }, 100);
            } else {
                $(this).removeClass('is-invalid');
                $(this).parent().find('.text-danger').remove();
            }
        });

        // Add event listener for form submission
        $('form').submit(function(event) {
            var course = $('#course').val();
            if (course.length < 15) {
                event.preventDefault(); // Prevent form submission if course length is less than 6 characters
                $('#course').addClass('is-invalid');
                $('#course').parent().find('.text-danger').remove();
                $('#course').parent().append(
                    '<span class="text-danger">Please follow the requested format.</span>');
                // Scroll to the course input field
                $('html, body').animate({
                    scrollTop: $('#course').offset().top - 100 // Adjust the offset as needed
                }, 100);
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const confirmSubmitBtn = document.getElementById('confirmSubmit');
            const closeModalBtn = document.getElementById('closeModalBtn');
            const cancelSubmitBtn = document.getElementById('cancelSubmit');
            const submitBtn = document.getElementById('submitBtn');
            const privacyPolicyCheckbox = document.getElementById('privacy_policy');
            const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));

            submitBtn.addEventListener('click', function() {
                if (privacyPolicyCheckbox.checked) {
                    confirmModal.show();
                } else {
                    alert('Please agree to the privacy policy.');
                }
            });

            confirmSubmitBtn.addEventListener('click', function() {
                // Here you can submit the form
                document.getElementById('regForm').submit();
            });

            closeModalBtn.addEventListener('click', function() {
                confirmModal.hide();
            });

            cancelSubmitBtn.addEventListener('click', function() {
                confirmModal.hide();
            });
        });
    </script>
      <style>
        .pointer {
            cursor: pointer;
        }
    </style>
@endsection
