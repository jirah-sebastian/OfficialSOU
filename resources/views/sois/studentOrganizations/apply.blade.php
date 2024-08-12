@extends('sois.layouts.app')
@section('styles')
    <style>
        .hidden {
            display: none;
        }
    </style>
@endsection
@section('content')
    <div class="page-title">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-xs-12">
                    <span class="page-title-text">Application</span>
                </div>
            </div>
        </div>
    </div>

    <div class="page-main">
        <div class="container">
            <div class="row">
                <div class="col-3"></div>
                <div class="col-6 align-self-end">


                    <div class="card mt-5">
                        <div class="card-header" style="background-color: #005600; color: white;">
                            <strong>Student Membership Application</strong>
                        </div>
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div class="card-body">
                            <form id="appForm" method="POST" action="{{ route('admin.so-registrations.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="profile_picture">{{ trans('cruds.soRegistration.fields.profile_picture') }}
                                        <small>(2x2Picture)</small></label>
                                    <div class="needsclick dropzone {{ $errors->has('profile_picture') ? 'is-invalid' : '' }}"
                                        id="profile_picture-dropzone">
                                    </div>
                                    @if ($errors->has('profile_picture'))
                                        <span class="text-danger">{{ $errors->first('profile_picture') }}</span>
                                    @endif
                                    <span
                                        class="help-block">{{ trans('cruds.soRegistration.fields.profile_picture_helper') }}</span>
                                    <span class="text-muted" style="font-size: small;">Image must not exceed 1 MB in
                                        size</span>
                                </div>

                                <div class="form-group">
                                    <label for="full_name">{{ trans('cruds.soRegistration.fields.full_name') }} <small>(Last
                                            Name, First Name,
                                            M.I.)</small></label>
                                    <input class="form-control {{ $errors->has('full_name') ? 'is-invalid' : '' }}"
                                        type="text" name="full_name" required id="full_name"
                                        value="{{ old('full_name', '') }}">
                                    @if ($errors->has('full_name'))
                                        <span class="text-danger">{{ $errors->first('full_name') }}</span>
                                    @endif
                                    <span
                                        class="help-block">{{ trans('cruds.soRegistration.fields.full_name_helper') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="email">{{ trans('cruds.soRegistration.fields.email') }} <small>(CLSU
                                            Email
                                            Address)</small></label>
                                    <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                        type="email" name="email" id="email" required value="{{ old('email') }}">
                                    @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.soRegistration.fields.email_helper') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="so_list_id">{{ trans('cruds.soRegistration.fields.so_list') }}</label>
                                    <select class="form-control select2 {{ $errors->has('so_list') ? 'is-invalid' : '' }}"
                                        name="so_list_id" required id="so_list_id">
                                        @foreach ($so_lists as $id => $entry)
                                            <option value="{{ $id }}"
                                                {{ request()->id == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('so_list'))
                                        <span class="text-danger">{{ $errors->first('so_list') }}</span>
                                    @endif
                                    <span
                                        class="help-block">{{ trans('cruds.soRegistration.fields.so_list_helper') }}</span>
                                </div>

                                <div class="form-group">
                                    <label for="course">{{ trans('cruds.soRegistration.fields.course') }}</label>
                                    <select class="form-control {{ $errors->has('course') ? 'is-invalid' : '' }}"
                                        name="course" id="course" required>
                                        <option value="" disabled selected>{{ trans('global.pleaseSelect') }}</option>
                                        @foreach (\App\Models\SoRegistration::COURSE_SELECT as $key => $value)
                                            <option value="{{ $key }}"
                                                {{ old('course') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('course'))
                                        <span class="text-danger">{{ $errors->first('course') }}</span>
                                    @endif
                                    <span
                                        class="help-block">{{ trans('cruds.soRegistration.fields.course_helper') }}</span>
                                </div>


                                <div class="form-group">
                                    <label>{{ trans('cruds.soRegistration.fields.year') }}</label>
                                    <select class="form-control {{ $errors->has('year') ? 'is-invalid' : '' }}"
                                        name="year" id="year" required>
                                        <option value disabled {{ old('year', null) === null ? 'selected' : '' }}>
                                            {{ trans('global.pleaseSelect') }}</option>
                                        @foreach (App\Models\SoRegistration::YEAR_SELECT as $key => $label)
                                            <option value="{{ $key }}"
                                                {{ old('year', '') === (string) $key ? 'selected' : '' }}>
                                                {{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('year'))
                                        <span class="text-danger">{{ $errors->first('year') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.soRegistration.fields.year_helper') }}</span>
                                </div>
                                <div class="form-group">
                                    <label>{{ trans('cruds.soRegistration.fields.gender') }}</label>
                                    <select class="form-control {{ $errors->has('gender') ? 'is-invalid' : '' }}"
                                        name="gender" id="gender" required>
                                        <option value disabled {{ old('gender', null) === null ? 'selected' : '' }}>
                                            {{ trans('global.pleaseSelect') }}</option>
                                        @foreach (App\Models\SoRegistration::GENDER_SELECT as $key => $label)
                                            <option value="{{ $key }}"
                                                {{ old('gender', '') === (string) $key ? 'selected' : '' }}>
                                                {{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('gender'))
                                        <span class="text-danger">{{ $errors->first('gender') }}</span>
                                    @endif
                                    <span
                                        class="help-block">{{ trans('cruds.soRegistration.fields.gender_helper') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="religion">{{ trans('cruds.soRegistration.fields.religion') }}</label>
                                    <input class="form-control {{ $errors->has('religion') ? 'is-invalid' : '' }}"
                                        type="text" name="religion" id="religion" value="{{ old('religion', '') }}"
                                        required>
                                    @if ($errors->has('religion'))
                                        <span class="text-danger">{{ $errors->first('religion') }}</span>
                                    @endif
                                    <span
                                        class="help-block">{{ trans('cruds.soRegistration.fields.religion_helper') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="nationality">{{ trans('cruds.soRegistration.fields.nationality') }}</label>
                                    <input class="form-control {{ $errors->has('nationality') ? 'is-invalid' : '' }}"
                                        type="text" name="nationality" id="nationality" required
                                        value="{{ old('nationality', '') }}">
                                    @if ($errors->has('nationality'))
                                        <span class="text-danger">{{ $errors->first('nationality') }}</span>
                                    @endif
                                    <span
                                        class="help-block">{{ trans('cruds.soRegistration.fields.nationality_helper') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="birthdate">{{ trans('cruds.soRegistration.fields.birthdate') }}
                                        <small>(YYYY-MM-DD)</small></label>
                                    <input class="form-control date {{ $errors->has('birthdate') ? 'is-invalid' : '' }}"
                                        type="text" name="birthdate" id="birthdate" required
                                        value="{{ old('birthdate') }}">
                                    @if ($errors->has('birthdate'))
                                        <span class="text-danger">{{ $errors->first('birthdate') }}</span>
                                    @endif
                                    <span
                                        class="help-block">{{ trans('cruds.soRegistration.fields.birthdate_helper') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="birthplace">{{ trans('cruds.soRegistration.fields.birthplace') }}
                                        <small>(Municipality/City, Province)</small></label>
                                    <input class="form-control {{ $errors->has('birthplace') ? 'is-invalid' : '' }}"
                                        type="text" name="birthplace" id="birthplace" required
                                        value="{{ old('birthplace', '') }}">
                                    @if ($errors->has('birthplace'))
                                        <span class="text-danger">{{ $errors->first('birthplace') }}</span>
                                    @endif
                                    <span
                                        class="help-block">{{ trans('cruds.soRegistration.fields.birthplace_helper') }}</span>
                                </div>
                                <div class="form-group">
                                    <label
                                        for="present_address">{{ trans('cruds.soRegistration.fields.present_address') }}
                                        <small>(Street, Barangay, Municipality/City, Province, Zip Code)</small></label>
                                    <input class="form-control {{ $errors->has('present_address') ? 'is-invalid' : '' }}"
                                        type="text" name="present_address" required id="present_address"
                                        value="{{ old('present_address', '') }}">
                                    @if ($errors->has('present_address'))
                                        <span class="text-danger">{{ $errors->first('present_address') }}</span>
                                    @endif
                                    <span
                                        class="help-block">{{ trans('cruds.soRegistration.fields.present_address_helper') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="home_address">{{ trans('cruds.soRegistration.fields.home_address') }}
                                        <small>(Street, Barangay, Municipality/City, Province, Zip Code)</small></label>
                                    <input class="form-control {{ $errors->has('home_address') ? 'is-invalid' : '' }}"
                                        type="text" name="home_address" required id="home_address"
                                        value="{{ old('home_address', '') }}">
                                    @if ($errors->has('home_address'))
                                        <span class="text-danger">{{ $errors->first('home_address') }}</span>
                                    @endif
                                    <span
                                        class="help-block">{{ trans('cruds.soRegistration.fields.home_address_helper') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="contact_no">{{ trans('cruds.soRegistration.fields.contact_no') }}</label>
                                    <input class="form-control {{ $errors->has('contact_no') ? 'is-invalid' : '' }}"
                                        type="text" name="contact_no" required id="contact_no"
                                        value="{{ old('contact_no', '') }}">
                                    @if ($errors->has('contact_no'))
                                        <span class="text-danger">{{ $errors->first('contact_no') }}</span>
                                    @endif
                                    <span
                                        class="help-block">{{ trans('cruds.soRegistration.fields.contact_no_helper') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="father_name">{{ trans('cruds.soRegistration.fields.father_name') }}
                                        <small>(Last
                                            Name, First Name, M.I.)</small></label>
                                    <input class="form-control {{ $errors->has('father_name') ? 'is-invalid' : '' }}"
                                        type="text" name="father_name" required id="father_name"
                                        value="{{ old('father_name', '') }}">
                                    @if ($errors->has('father_name'))
                                        <span class="text-danger">{{ $errors->first('father_name') }}</span>
                                    @endif
                                    <span
                                        class="help-block">{{ trans('cruds.soRegistration.fields.father_name_helper') }}</span>
                                </div>
                                <div class="form-group">
                                    <label
                                        for="father_contact_no">{{ trans('cruds.soRegistration.fields.father_contact_no') }}</label>
                                    <input
                                        class="form-control {{ $errors->has('father_contact_no') ? 'is-invalid' : '' }}"
                                        type="text" name="father_contact_no" required id="father_contact_no"
                                        value="{{ old('father_contact_no', '') }}">
                                    @if ($errors->has('father_contact_no'))
                                        <span class="text-danger">{{ $errors->first('father_contact_no') }}</span>
                                    @endif
                                    <span
                                        class="help-block">{{ trans('cruds.soRegistration.fields.father_contact_no_helper') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="mother_name">{{ trans('cruds.soRegistration.fields.mother_name') }}
                                        <small>(Last
                                            Name, First Name, M.I.)</small></label>
                                    <input class="form-control {{ $errors->has('mother_name') ? 'is-invalid' : '' }}"
                                        type="text" name="mother_name" id="mother_name" required
                                        value="{{ old('mother_name', '') }}">
                                    @if ($errors->has('mother_name'))
                                        <span class="text-danger">{{ $errors->first('mother_name') }}</span>
                                    @endif
                                    <span
                                        class="help-block">{{ trans('cruds.soRegistration.fields.mother_name_helper') }}</span>
                                </div>
                                <div class="form-group">
                                    <label
                                        for="mother_contact_no">{{ trans('cruds.soRegistration.fields.mother_contact_no') }}</label>
                                    <input
                                        class="form-control {{ $errors->has('mother_contact_no') ? 'is-invalid' : '' }}"
                                        type="text" name="mother_contact_no" required id="mother_contact_no"
                                        value="{{ old('mother_contact_no', '') }}">
                                    @if ($errors->has('mother_contact_no'))
                                        <span class="text-danger">{{ $errors->first('mother_contact_no') }}</span>
                                    @endif
                                    <span
                                        class="help-block">{{ trans('cruds.soRegistration.fields.mother_contact_no_helper') }}</span>
                                </div>
                                <div class="form-group">
                                    <label
                                        for="source_of_financial_support">{{ trans('cruds.soRegistration.fields.source_of_financial_support') }}</label>
                                    <input
                                        class="form-control {{ $errors->has('source_of_financial_support') ? 'is-invalid' : '' }}"
                                        type="text" name="source_of_financial_support" required
                                        id="source_of_financial_support"
                                        value="{{ old('source_of_financial_support', '') }}">
                                    @if ($errors->has('source_of_financial_support'))
                                        <span
                                            class="text-danger">{{ $errors->first('source_of_financial_support') }}</span>
                                    @endif
                                    <span
                                        class="help-block">{{ trans('cruds.soRegistration.fields.source_of_financial_support_helper') }}</span>
                                </div>
                                <div class="form-group">
                                    <label
                                        for="talent_skills">{{ trans('cruds.soRegistration.fields.talent_skills') }}</label>
                                    <input class="form-control {{ $errors->has('talent_skills') ? 'is-invalid' : '' }}"
                                        type="text" name="talent_skills" id="talent_skills" required
                                        value="{{ old('talent_skills', '') }}">
                                    @if ($errors->has('talent_skills'))
                                        <span class="text-danger">{{ $errors->first('talent_skills') }}</span>
                                    @endif
                                    <span
                                        class="help-block">{{ trans('cruds.soRegistration.fields.talent_skills_helper') }}</span>
                                </div>

                                <div class="form-group">
                                    <label>{{ trans('cruds.soRegistration.fields.membership_type') }}</label>
                                    <select
                                        class="form-control {{ $errors->has('membership_type') ? 'is-invalid' : '' }}"
                                        name="membership_type" id="membership_type" required>
                                        <option value disabled
                                            {{ old('membership_type', null) === null ? 'selected' : '' }}>
                                            {{ trans('global.pleaseSelect') }}</option>
                                        @foreach (App\Models\SoRegistration::MEMBERSHIP_TYPE_SELECT as $key => $label)
                                            <option value="{{ $key }}"
                                                {{ old('membership_type', '') === (string) $key ? 'selected' : '' }}>
                                                {{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('membership_type'))
                                        <span class="text-danger">{{ $errors->first('membership_type') }}</span>
                                    @endif
                                    <span
                                        class="help-block">{{ trans('cruds.soRegistration.fields.membership_type_helper') }}</span>
                                </div>
                                <div class="form-group hidden" id="position_div">
                                    <label for="position">{{ trans('cruds.soRegistration.fields.position') }}</label>
                                    <input class="form-control {{ $errors->has('position') ? 'is-invalid' : '' }}"
                                        type="text" name="position" id="position"
                                        value="{{ old('position', '') }}">
                                    @if ($errors->has('position'))
                                        <span class="text-danger">{{ $errors->first('position') }}</span>
                                    @endif
                                    <span
                                        class="help-block">{{ trans('cruds.soRegistration.fields.position_helper') }}</span>
                                </div>

                                <div class="form-group">
                                    <label for="profile_form">Member Profile Form (Scanned Copy) </label>
                                    <div class="needsclick dropzone {{ $errors->has('profile_form') ? 'is-invalid' : '' }}"
                                        id="profile_form-dropzone" required>
                                    </div>
                                    @if ($errors->has('profile_form'))
                                        <span class="text-danger">{{ $errors->first('profile_form') }}</span>
                                    @endif
                                    <span
                                        class="help-block">{{ trans('cruds.soRegistration.fields.profile_form_helper') }}</span>
                                    <span class="text-muted" style="font-size: small;">Only PDF file allowed (Max. 3 MB)
                                    </span>
                                </div>
                                <div class="form-group">
                                    <label for="parent_consent_form">Parent Consent Form (Scanned Copy)</label>
                                    <div class="needsclick dropzone {{ $errors->has('parent_consent_form') ? 'is-invalid' : '' }}"
                                        id="parent_consent_form-dropzone" required>
                                    </div>
                                    @if ($errors->has('parent_consent_form'))
                                        <span class="text-danger">{{ $errors->first('parent_consent_form') }}</span>
                                    @endif
                                    <span
                                        class="help-block">{{ trans('cruds.soRegistration.fields.parent_consent_form_helper') }}</span>
                                    <span class="text-muted" style="font-size: small;">Only PDF file allowed (Max. 3 MB)
                                    </span>
                                </div>
                                <div class="form-group">
                                    <label for="data_privacy_form">Data Privacy Form (Scanned Copy)</label>
                                    <div class="needsclick dropzone {{ $errors->has('data_privacy_form') ? 'is-invalid' : '' }}"
                                        id="data_privacy_form-dropzone" required>
                                    </div>
                                    @if ($errors->has('data_privacy_form'))
                                        <span class="text-danger">{{ $errors->first('data_privacy_form') }}</span>
                                    @endif
                                    <span
                                        class="help-block">{{ trans('cruds.soRegistration.fields.data_privacy_form_helper') }}</span>
                                    <span class="text-muted" style="font-size: small;">Only PDF file allowed (Max. 3 MB)
                                    </span>
                                </div>

                                <div class="form-group">
                                    <label for="med_cert">Medical Certificate (Scanned Copy)</label>
                                    <div class="needsclick dropzone {{ $errors->has('med_cert') ? 'is-invalid' : '' }}"
                                        id="med_cert-dropzone" required>
                                    </div>
                                    @if ($errors->has('med_cert'))
                                        <span class="text-danger">{{ $errors->first('med_cert') }}</span>
                                    @endif
                                    {{-- <span
                                        class="help-block">{{ trans('cruds.soRegistration.fields.data_privacy_form_helper') }}</span> --}}
                                    <span class="text-muted" style="font-size: small;">Only PDF file allowed (Max. 3 MB)
                                    </span>
                                </div>

                                <div class="form-group">
                                    <label for="date_filed">{{ trans('cruds.soRegistration.fields.date_filed') }}</label>
                                    <input class="form-control date {{ $errors->has('date_filed') ? 'is-invalid' : '' }}"
                                        type="text" name="date_filed" id="date_filed" required
                                        value="{{ old('date_filed', date('Y-m-d')) }}" readonly>
                                    @if ($errors->has('date_filed'))
                                        <span class="text-danger">{{ $errors->first('date_filed') }}</span>
                                    @endif
                                    <span
                                        class="help-block">{{ trans('cruds.soRegistration.fields.date_filed_helper') }}</span>
                                </div>

                                <div class="form-group">
                                    <label for="privacy_policy" style="text-align: justify;">
                                        <input type="checkbox" id="privacy_policy" name="privacy_policy" required>
                                        By checking this box, I acknowledge that I consent to the collection and
                                        processing of my personal information in accordance with the Data Privacy Act
                                        (RA 10173) of the Philippines.
                                    </label>
                                </div>

                                <div class="form-group">
                                    <button class="btn btn-primary" type="submit">
                                        Submit
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-3"></div>
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
        Dropzone.options.profilePictureDropzone = {
            url: '{{ route('admin.so-registrations.storeMedia') }}',
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
                $('form').find('input[name="profile_picture"]').remove()
                $('form').append('<input type="hidden" name="profile_picture" value="' + response.name + '">')
            },
            removedfile: function(file) {
                file.previewElement.remove()
                if (file.status !== 'error') {
                    $('form').find('input[name="profile_picture"]').remove()
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
                        $('#profile_picture-dropzone').addClass('is-invalid');
                        $('#profile_picture-dropzone').parent().append(
                            '<span class="text-danger">Only JPEG and PNG files are accepted. </span>'
                        );
                        return;
                    }

                    // Check if the file size exceeds 1MB
                    if (file.size > 1024 * 1024) {
                        $('#profile_picture-dropzone').addClass('is-invalid');
                        $('#profile_picture-dropzone').parent().append(
                            '<span class="text-danger">File size must not exceed 1 MB. </span>');
                        return;
                    }

                    // If more than one file is added, show an error message
                    if (myDropzone.files.length > 1) {
                        $('#profile_picture-dropzone').addClass('is-invalid');
                        $('#profile_picture-dropzone').parent().append(
                            '<span class="text-danger">Only one file is allowed. </span>'
                        );
                        myDropzone.removeFile(file); // Remove the invalid file
                        return;
                    }

                    // If file meets requirements, remove any error messages and classes
                    $('#profile_picture-dropzone').removeClass('is-invalid');
                });

                // Add event listener for form submission
                $('form').submit(function(event) {
                    // Check if profile picture is empty
                    if (myDropzone.getQueuedFiles().length === 0 && myDropzone.getAcceptedFiles().length ===
                        0) {
                        // Prevent form submission
                        event.preventDefault();

                        if (!errorMessageShown) {
                            // Create a new error message element
                            var errorMessage = $(
                                '<span class="text-danger">This field is required.</span>');

                            // Append the error message below the Dropzone field
                            $('#profile_picture-dropzone').parent().append(errorMessage);

                            // Set flag to true
                            errorMessageShown = true;
                        }

                        // Scroll to the profile picture section
                        $('html, body').animate({
                            scrollTop: $("#profile_picture-dropzone").offset().top
                        }, 100);
                    } else {
                        // Check if there are any other validation errors
                        var otherValidationErrors = $('.text-danger').not('#profile_form-dropzone')
                            .length > 0;

                        if (!otherValidationErrors) {
                            // If dropzone is not empty and there are no other errors, remove the error message
                            $('.text-danger').remove();
                        }
                    }
                });
                @if (isset($soRegistration) && $soRegistration->profile_picture)
                    var file = {!! json_encode($soRegistration->profile_picture) !!}
                    this.options.addedfile.call(this, file)
                    this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="profile_picture" value="' + file.file_name + '">')
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
    </script>
    <script>
        Dropzone.options.profileFormDropzone = {
            url: '{{ route('admin.so-registrations.storeMedia') }}',
            maxFilesize: 3, // MB
            acceptedFiles: '.pdf',
            maxFiles: 1,
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 3
            },


            success: function(file, response) {
                $('form').find('input[name="profile_form"]').remove()
                $('form').append('<input type="hidden" name="profile_form" value="' + response.name + '">')
            },
            removedfile: function(file) {
                file.previewElement.remove()
                if (file.status !== 'error') {
                    $('form').find('input[name="profile_form"]').remove()
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
                        $('#profile_form-dropzone').addClass('is-invalid');
                        $('#profile_form-dropzone').parent().append(
                            '<span class="text-danger">Only PDF file is accepted. </span>'
                        );
                        return;
                    }

                    // Check if the file size exceeds 1MB
                    if (file.size > 3 * 1024 * 1024) {
                        $('#profile_form-dropzone').addClass('is-invalid');
                        $('#profile_form-dropzone').parent().append(
                            '<span class="text-danger">File size must not exceed 3 MB. </span>');
                        return;
                    }

                    // If more than one file is added, show an error message
                    if (myDropzone.files.length > 1) {
                        $('#profile_form-dropzone').addClass('is-invalid');
                        $('#profile_form-dropzone').parent().append(
                            '<span class="text-danger">Only one file is allowed. </span>'
                        );
                        myDropzone.removeFile(file); // Remove the invalid file
                        return;
                    }

                    // If file meets requirements, remove any error messages and classes
                    $('#profile_form-dropzone').removeClass('is-invalid');
                });

                // Add event listener for form submission
                $('form').submit(function(event) {
                    // Check if profile picture is empty
                    if (myDropzone.getQueuedFiles().length === 0 && myDropzone.getAcceptedFiles().length ===
                        0) {
                        // Prevent form submission
                        event.preventDefault();

                        if (!errorMessageShown) {
                            // Create a new error message element
                            var errorMessage = $(
                                '<span class="text-danger">This field is required.</span>');

                            // Append the error message below the Dropzone field
                            $('#profile_form-dropzone').parent().append(errorMessage);

                            // Set flag to true
                            errorMessageShown = true;
                        }

                        // Scroll to the profile picture section
                        $('html, body').animate({
                            scrollTop: $("#profile_form-dropzone").offset().top
                        }, 100);
                    } else {
                        // Check if there are any other validation errors
                        var otherValidationErrors = $('.text-danger').not('#profile_form-dropzone')
                            .length > 0;

                        if (!otherValidationErrors) {
                            // If dropzone is not empty and there are no other errors, remove the error message
                            $('.text-danger').remove();
                        }
                    }
                });

                @if (isset($soRegistration) && $soRegistration->profile_form)
                    var file = {!! json_encode($soRegistration->profile_form) !!}
                    this.options.addedfile.call(this, file)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="profile_form" value="' + file.file_name + '">')
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


        Dropzone.options.parentConsentFormDropzone = {
            url: '{{ route('admin.so-registrations.storeMedia') }}',
            maxFilesize: 3, // MB
            maxFiles: 1,
            acceptedFiles: '.pdf',
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 3
            },
            success: function(file, response) {
                $('form').find('input[name="parent_consent_form"]').remove()
                $('form').append('<input type="hidden" name="parent_consent_form" value="' + response.name + '">')
            },
            removedfile: function(file) {
                file.previewElement.remove()
                if (file.status !== 'error') {
                    $('form').find('input[name="parent_consent_form"]').remove()
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
                        $('#parent_consent_form-dropzone').addClass('is-invalid');
                        $('#parent_consent_form-dropzone').parent().append(
                            '<span class="text-danger">Only PDF file is accepted. </span>'
                        );
                        return;
                    }

                    // Check if the file size exceeds 1MB
                    if (file.size > 3 * 1024 * 1024) {
                        $('#parent_consent_form-dropzone').addClass('is-invalid');
                        $('#parent_consent_form-dropzone').parent().append(
                            '<span class="text-danger">File size must not exceed 3 MB. </span>');
                        return;
                    }

                    // If more than one file is added, show an error message
                    if (myDropzone.files.length > 1) {
                        $('#parent_consent_form-dropzone').addClass('is-invalid');
                        $('#parent_consent_form-dropzone').parent().append(
                            '<span class="text-danger">Only one file is allowed. </span>'
                        );
                        myDropzone.removeFile(file); // Remove the invalid file
                        return;
                    }


                    // If file meets requirements, remove any error messages and classes
                    $('#parent_consent_form-dropzone').removeClass('is-invalid');
                });

                // Add event listener for form submission
                $('form').submit(function(event) {
                    // Check if profile picture is empty
                    if (myDropzone.getQueuedFiles().length === 0 && myDropzone.getAcceptedFiles().length ===
                        0) {
                        // Prevent form submission
                        event.preventDefault();

                        if (!errorMessageShown) {
                            // Create a new error message element
                            var errorMessage = $(
                                '<span class="text-danger">This field is required.</span>');

                            // Append the error message below the Dropzone field
                            $('#parent_consent_form-dropzone').parent().append(errorMessage);

                            // Set flag to true
                            errorMessageShown = true;
                        }

                        // Scroll to the profile picture section
                        $('html, body').animate({
                            scrollTop: $("#parent_consent_form-dropzone").offset().top
                        }, 100);
                    } else {
                        // Check if there are any other validation errors
                        var otherValidationErrors = $('.text-danger').not('#parent_consent_form-dropzone')
                            .length > 0;

                        if (!otherValidationErrors) {
                            // If dropzone is not empty and there are no other errors, remove the error message
                            $('.text-danger').remove();
                        }
                    }
                });

                @if (isset($soRegistration) && $soRegistration->parent_consent_form)
                    var file = {!! json_encode($soRegistration->parent_consent_form) !!}
                    this.options.addedfile.call(this, file)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="parent_consent_form" value="' + file.file_name +
                        '">')
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



        Dropzone.options.dataPrivacyFormDropzone = {
            url: '{{ route('admin.so-registrations.storeMedia') }}',
            maxFilesize: 3, // MB
            maxFiles: 1,
            acceptedFiles: '.pdf',
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 3
            },
            success: function(file, response) {
                $('form').find('input[name="data_privacy_form"]').remove()
                $('form').append('<input type="hidden" name="data_privacy_form" value="' + response.name + '">')
            },
            removedfile: function(file) {
                file.previewElement.remove()
                if (file.status !== 'error') {
                    $('form').find('input[name="data_privacy_form"]').remove()
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
                        $('#data_privacy_form-dropzone').addClass('is-invalid');
                        $('#data_privacy_form-dropzone').parent().append(
                            '<span class="text-danger">Only PDF file is accepted. </span>'
                        );
                        return;
                    }

                    // Check if the file size exceeds 1MB
                    if (file.size > 3 * 1024 * 1024) {
                        $('#data_privacy_form-dropzone').addClass('is-invalid');
                        $('#data_privacy_form-dropzone').parent().append(
                            '<span class="text-danger">File size must not exceed 3 MB. </span>');
                        return;
                    }

                    // If more than one file is added, show an error message
                    if (myDropzone.files.length > 1) {
                        $('#data_privacy_form-dropzone').addClass('is-invalid');
                        $('#data_privacy_form-dropzone').parent().append(
                            '<span class="text-danger">Only one file is allowed. </span>'
                        );
                        myDropzone.removeFile(file); // Remove the invalid file
                        return;
                    }

                    // If file meets requirements, remove any error messages and classes
                    $('#data_privacy_form-dropzone').removeClass('is-invalid');
                });

                // Add event listener for form submission
                $('form').submit(function(event) {
                    // Check if profile picture is empty
                    if (myDropzone.getQueuedFiles().length === 0 && myDropzone.getAcceptedFiles().length ===
                        0) {
                        // Prevent form submission
                        event.preventDefault();

                        if (!errorMessageShown) {
                            // Create a new error message element
                            var errorMessage = $(
                                '<span class="text-danger">This field is required.</span>');

                            // Append the error message below the Dropzone field
                            $('#data_privacy_form-dropzone').parent().append(errorMessage);

                            // Set flag to true
                            errorMessageShown = true;
                        }

                        // Scroll to the profile picture section
                        $('html, body').animate({
                            scrollTop: $("#data_privacy_form-dropzone").offset().top
                        }, 100);
                    } else {
                        // Check if there are any other validation errors
                        var otherValidationErrors = $('.text-danger').not('#data_privacy_form-dropzone')
                            .length > 0;

                        if (!otherValidationErrors) {
                            // If dropzone is not empty and there are no other errors, remove the error message
                            $('.text-danger').remove();
                        }
                    }
                });

                @if (isset($soRegistration) && $soRegistration->data_privacy_form)
                    var file = {!! json_encode($soRegistration->data_privacy_form) !!}
                    this.options.addedfile.call(this, file)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="data_privacy_form" value="' + file.file_name +
                        '">')
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


        Dropzone.options.medCertDropzone = {
            url: '{{ route('admin.so-registrations.storeMedia') }}',
            maxFilesize: 3, // MB
            maxFiles: 1,
            acceptedFiles: '.pdf',
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 3
            },
            success: function(file, response) {
                $('form').find('input[name="med_cert"]').remove()
                $('form').append('<input type="hidden" name="med_cert" value="' + response.name + '">')
            },
            removedfile: function(file) {
                file.previewElement.remove()
                if (file.status !== 'error') {
                    $('form').find('input[name="med_cert"]').remove()
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
                        $('#med_cert-dropzone').addClass('is-invalid');
                        $('#med_cert-dropzone').parent().append(
                            '<span class="text-danger">Only PDF file is accepted. </span>'
                        );
                        return;
                    }

                    // Check if the file size exceeds 1MB
                    if (file.size > 3 * 1024 * 1024) {
                        $('#med_cert-dropzone').addClass('is-invalid');
                        $('#med_cert-dropzone').parent().append(
                            '<span class="text-danger">File size must not exceed 3 MB. </span>');
                        return;
                    }

                    // If more than one file is added, show an error message
                    if (myDropzone.files.length > 1) {
                        $('#med_cert-dropzone').addClass('is-invalid');
                        $('#med_cert-dropzone').parent().append(
                            '<span class="text-danger">Only one file is allowed. </span>'
                        );
                        myDropzone.removeFile(file); // Remove the invalid file
                        return;
                    }

                    // If file meets requirements, remove any error messages and classes
                    $('#med_cert-dropzone').removeClass('is-invalid');
                });

                // Add event listener for form submission
                $('form').submit(function(event) {
                    // Check if profile picture is empty
                    if (myDropzone.getQueuedFiles().length === 0 && myDropzone.getAcceptedFiles().length ===
                        0) {
                        // Prevent form submission
                        event.preventDefault();

                        if (!errorMessageShown) {
                            // Create a new error message element
                            var errorMessage = $(
                                '<span class="text-danger">This field is required.</span>');

                            // Append the error message below the Dropzone field
                            $('#med_cert-dropzone').parent().append(errorMessage);

                            // Set flag to true
                            errorMessageShown = true;
                        }


                        // Scroll to the profile picture section
                        $('html, body').animate({
                            scrollTop: $("#med_cert-dropzone").offset().top
                        }, 100);
                    } else {
                        // Check if there are any other validation errors
                        var otherValidationErrors = $('.text-danger').not('#med_cert-dropzone')
                            .length > 0;

                        if (!otherValidationErrors) {
                            // If dropzone is not empty and there are no other errors, remove the error message
                            $('.text-danger').remove();
                        }
                    }
                });

                @if (isset($soRegistration) && $soRegistration->med_cert)
                    var file = {!! json_encode($soRegistration->med_cert) !!}
                    this.options.addedfile.call(this, file)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="med_cert="' + file.file_name +
                        '">')
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
            $('#membership_type').change(function() {
                if ($(this).val() === 'Officer') {
                    $('#position_div').removeClass('hidden');

                } else {

                    $('#position_div').addClass('hidden');
                }
            });
        });



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
            var emailRegex = /.*clsu2\.edu\.ph$/i;
            return emailRegex.test(email);
        }

        // Add event listener for form submission
        $('form').submit(function(event) {
            // Check the length of the course input value
            var courseLength = $('#course').val().length;

            // If the course length is less than 15 characters, prevent form submission
            if (courseLength < 15) {
                event.preventDefault(); // Prevent form submission
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
                event.preventDefault(); // Prevent form submission if course length is less than 15 characters
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
                $('#appForm').off('submit').submit(); // Submit the form
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
@endsection
