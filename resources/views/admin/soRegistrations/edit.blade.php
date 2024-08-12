@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header" style="background-color: #005600; color:white;">
            <strong>EDIT SO MEMBER</strong>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.so-registrations.update', [$soRegistration->id]) }}"
                enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label class="required"
                        for="profile_picture">{{ trans('cruds.soRegistration.fields.profile_picture') }}<small>
                            (2x2Picture)</small></label>
                    <div class="needsclick dropzone {{ $errors->has('profile_picture') ? 'is-invalid' : '' }}"
                        id="profile_picture-dropzone">
                    </div>
                    @if ($errors->has('profile_picture'))
                        <span class="text-danger">{{ $errors->first('profile_picture') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.soRegistration.fields.profile_picture_helper') }}</span>
                    <span class="text-muted" style="font-size: small;">Image must not exceed 1 MB in
                        size</span>
                </div>
                <div class="form-group">
                    <label for="full_name">{{ trans('cruds.soRegistration.fields.full_name') }} <small>(Last
                            Name, First Name, M.I.)</small></label>
                    <input class="form-control {{ $errors->has('full_name') ? 'is-invalid' : '' }}" type="text"
                        name="full_name" id="full_name" value="{{ old('full_name', $soRegistration->full_name) }}" required>
                    @if ($errors->has('full_name'))
                        <span class="text-danger">{{ $errors->first('full_name') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.soRegistration.fields.full_name_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="email">{{ trans('cruds.soRegistration.fields.email') }} <small>(CLSU
                            Email Address)</small></label>
                    <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email"
                        name="email" id="email" value="{{ old('email', $soRegistration->email) }}" required>
                    @if ($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.soRegistration.fields.email_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="so_list_id">{{ trans('cruds.soRegistration.fields.so_list') }}</label>
                    <select class="form-control select2 {{ $errors->has('so_list') ? 'is-invalid' : '' }}" disabled
                        name="so_list_id" id="so_list_id" required>
                        @foreach ($so_lists as $id => $entry)
                            <option value="{{ $id }}"
                                {{ (old('so_list_id') ? old('so_list_id') : $soRegistration->so_list->id ?? '') == $id ? 'selected' : '' }}>
                                {{ $entry }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('so_list'))
                        <span class="text-danger">{{ $errors->first('so_list') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.soRegistration.fields.so_list_helper') }}</span>
                </div>

               <div class="form-group">
    <label for="course">{{ trans('cruds.soRegistration.fields.course') }}</label>
    <select class="form-control {{ $errors->has('course') ? 'is-invalid' : '' }}" name="course" id="course" required>
        <option value="" disabled selected>Select Course</option>
        @foreach(\App\Models\SoRegistration::COURSE_SELECT as $key => $value)
            <option value="{{ $key }}" {{ old('course', $soRegistration->course) == $key ? 'selected' : '' }}>{{ $value }}</option>
        @endforeach
    </select>
    @if ($errors->has('course'))
        <span class="text-danger">{{ $errors->first('course') }}</span>
    @endif
   
    <span class="help-block">{{ trans('cruds.soRegistration.fields.course_helper') }}</span>
</div>


                <div class="form-group">
                    <label>{{ trans('cruds.soRegistration.fields.year') }}</label>
                    <select class="form-control {{ $errors->has('year') ? 'is-invalid' : '' }}" name="year"
                        id="year" required>
                        <option value disabled {{ old('year', null) === null ? 'selected' : '' }}>
                            {{ trans('global.pleaseSelect') }}</option>
                        @foreach (App\Models\SoRegistration::YEAR_SELECT as $key => $label)
                            <option value="{{ $key }}"
                                {{ old('year', $soRegistration->year) === (string) $key ? 'selected' : '' }}>
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
                    <select class="form-control {{ $errors->has('gender') ? 'is-invalid' : '' }}" name="gender"
                        id="gender" required>
                        <option value disabled {{ old('gender', null) === null ? 'selected' : '' }}>
                            {{ trans('global.pleaseSelect') }}</option>
                        @foreach (App\Models\SoRegistration::GENDER_SELECT as $key => $label)
                            <option value="{{ $key }}"
                                {{ old('gender', $soRegistration->gender) === (string) $key ? 'selected' : '' }}>
                                {{ $label }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('gender'))
                        <span class="text-danger">{{ $errors->first('gender') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.soRegistration.fields.gender_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="religion">{{ trans('cruds.soRegistration.fields.religion') }}</label>
                    <input class="form-control {{ $errors->has('religion') ? 'is-invalid' : '' }}" type="text"
                        name="religion" id="religion" value="{{ old('religion', $soRegistration->religion) }}" required>
                    @if ($errors->has('religion'))
                        <span class="text-danger">{{ $errors->first('religion') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.soRegistration.fields.religion_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="nationality">{{ trans('cruds.soRegistration.fields.nationality') }}</label>
                    <input class="form-control {{ $errors->has('nationality') ? 'is-invalid' : '' }}" type="text"
                        name="nationality" id="nationality" value="{{ old('nationality', $soRegistration->nationality) }}"
                        required>
                    @if ($errors->has('nationality'))
                        <span class="text-danger">{{ $errors->first('nationality') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.soRegistration.fields.nationality_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="birthdate">{{ trans('cruds.soRegistration.fields.birthdate') }}
                        <small>(YYYY-MM-DD)</small></label></label>
                    <input class="form-control date {{ $errors->has('birthdate') ? 'is-invalid' : '' }}" type="text"
                        name="birthdate" id="birthdate" value="{{ old('birthdate', $soRegistration->birthdate) }}"
                        required>
                    @if ($errors->has('birthdate'))
                        <span class="text-danger">{{ $errors->first('birthdate') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.soRegistration.fields.birthdate_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="birthplace">{{ trans('cruds.soRegistration.fields.birthplace') }}
                        <small>(Municipality/City, Province)</small></label>
                    <input class="form-control {{ $errors->has('birthplace') ? 'is-invalid' : '' }}" type="text"
                        name="birthplace" id="birthplace" value="{{ old('birthplace', $soRegistration->birthplace) }}"
                        required>
                    @if ($errors->has('birthplace'))
                        <span class="text-danger">{{ $errors->first('birthplace') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.soRegistration.fields.birthplace_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="present_address">{{ trans('cruds.soRegistration.fields.present_address') }}
                        <small>(Street, Barangay, Municipality/City, Province, Zip Code)</small></label>
                    <input class="form-control {{ $errors->has('present_address') ? 'is-invalid' : '' }}" type="text"
                        name="present_address" id="present_address"
                        value="{{ old('present_address', $soRegistration->present_address) }}" required>
                    @if ($errors->has('present_address'))
                        <span class="text-danger">{{ $errors->first('present_address') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.soRegistration.fields.present_address_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="home_address">{{ trans('cruds.soRegistration.fields.home_address') }} <small>(Street,
                            Barangay, Municipality/City, Province, Zip Code)</small></label>
                    <input class="form-control {{ $errors->has('home_address') ? 'is-invalid' : '' }}" type="text"
                        name="home_address" id="home_address"
                        value="{{ old('home_address', $soRegistration->home_address) }}" required>
                    @if ($errors->has('home_address'))
                        <span class="text-danger">{{ $errors->first('home_address') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.soRegistration.fields.home_address_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="contact_no">{{ trans('cruds.soRegistration.fields.contact_no') }}</label>
                    <input class="form-control {{ $errors->has('contact_no') ? 'is-invalid' : '' }}" type="text"
                        name="contact_no" id="contact_no" value="{{ old('contact_no', $soRegistration->contact_no) }}"
                        required>
                    @if ($errors->has('contact_no'))
                        <span class="text-danger">{{ $errors->first('contact_no') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.soRegistration.fields.contact_no_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="father_name">{{ trans('cruds.soRegistration.fields.father_name') }} <small>(Last
                            Name, First Name, M.I.)</small></label>
                    <input class="form-control {{ $errors->has('father_name') ? 'is-invalid' : '' }}" type="text"
                        name="father_name" id="father_name"
                        value="{{ old('father_name', $soRegistration->father_name) }}" required>
                    @if ($errors->has('father_name'))
                        <span class="text-danger">{{ $errors->first('father_name') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.soRegistration.fields.father_name_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="father_contact_no">{{ trans('cruds.soRegistration.fields.father_contact_no') }}</label>
                    <input class="form-control {{ $errors->has('father_contact_no') ? 'is-invalid' : '' }}"
                        type="text" name="father_contact_no" id="father_contact_no"
                        value="{{ old('father_contact_no', $soRegistration->father_contact_no) }}" required>
                    @if ($errors->has('father_contact_no'))
                        <span class="text-danger">{{ $errors->first('father_contact_no') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.soRegistration.fields.father_contact_no_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="mother_name">{{ trans('cruds.soRegistration.fields.mother_name') }} <small>(Last
                            Name, First Name, M.I.)</small></label>
                    <input class="form-control {{ $errors->has('mother_name') ? 'is-invalid' : '' }}" type="text"
                        name="mother_name" id="mother_name"
                        value="{{ old('mother_name', $soRegistration->mother_name) }}" required>
                    @if ($errors->has('mother_name'))
                        <span class="text-danger">{{ $errors->first('mother_name') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.soRegistration.fields.mother_name_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="mother_contact_no">{{ trans('cruds.soRegistration.fields.mother_contact_no') }}</label>
                    <input class="form-control {{ $errors->has('mother_contact_no') ? 'is-invalid' : '' }}"
                        type="text" name="mother_contact_no" id="mother_contact_no"
                        value="{{ old('mother_contact_no', $soRegistration->mother_contact_no) }}" required>
                    @if ($errors->has('mother_contact_no'))
                        <span class="text-danger">{{ $errors->first('mother_contact_no') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.soRegistration.fields.mother_contact_no_helper') }}</span>
                </div>
                <div class="form-group">
                    <label
                        for="source_of_financial_support">{{ trans('cruds.soRegistration.fields.source_of_financial_support') }}</label>
                    <input class="form-control {{ $errors->has('source_of_financial_support') ? 'is-invalid' : '' }}"
                        type="text" name="source_of_financial_support" id="source_of_financial_support"
                        value="{{ old('source_of_financial_support', $soRegistration->source_of_financial_support) }}"
                        required>
                    @if ($errors->has('source_of_financial_support'))
                        <span class="text-danger">{{ $errors->first('source_of_financial_support') }}</span>
                    @endif
                    <span
                        class="help-block">{{ trans('cruds.soRegistration.fields.source_of_financial_support_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="talent_skills">{{ trans('cruds.soRegistration.fields.talent_skills') }}</label>
                    <input class="form-control {{ $errors->has('talent_skills') ? 'is-invalid' : '' }}" type="text"
                        name="talent_skills" id="talent_skills"
                        value="{{ old('talent_skills', $soRegistration->talent_skills) }}" required>
                    @if ($errors->has('talent_skills'))
                        <span class="text-danger">{{ $errors->first('talent_skills') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.soRegistration.fields.talent_skills_helper') }}</span>
                </div>

                <div class="form-group">
                    <label>{{ trans('cruds.soRegistration.fields.membership_type') }}</label>
                    <select class="form-control {{ $errors->has('membership_type') ? 'is-invalid' : '' }}"
                        name="membership_type" id="membership_type" required>
                        <option value disabled {{ old('membership_type', null) === null ? 'selected' : '' }}>
                            {{ trans('global.pleaseSelect') }}</option>
                        @foreach (App\Models\SoRegistration::MEMBERSHIP_TYPE_SELECT as $key => $label)
                            <option value="{{ $key }}"
                                {{ old('membership_type', $soRegistration->membership_type) === (string) $key ? 'selected' : '' }}>
                                {{ $label }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('membership_type'))
                        <span class="text-danger">{{ $errors->first('membership_type') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.soRegistration.fields.membership_type_helper') }}</span>
                </div>

                <div class="form-group">
                    <label for="position">{{ trans('cruds.soRegistration.fields.position') }}</label>
                    <input class="form-control {{ $errors->has('position') ? 'is-invalid' : '' }}" type="text"
                        name="position" id="position" value="{{ old('position', $soRegistration->position) }}">
                    @if ($errors->has('position'))
                        <span class="text-danger">{{ $errors->first('position') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.soRegistration.fields.position_helper') }}</span>
                </div>
                {{-- <div class="form-group">
                    <label for="title_id">{{ trans('cruds.soRegistration.fields.title') }}</label>
                    <select class="form-control select2 {{ $errors->has('title') ? 'is-invalid' : '' }}" name="title_id"
                        id="title_id">
                        @foreach ($titles as $id => $entry)
                            <option value="{{ $id }}"
                                {{ (old('title_id') ? old('title_id') : $soRegistration->title->id ?? '') == $id ? 'selected' : '' }}>
                                {{ $entry }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('title'))
                        <span class="text-danger">{{ $errors->first('title') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.soRegistration.fields.title_helper') }}</span>
                </div> --}}
                <div class="form-group">
                    <label for="profile_form">{{ trans('cruds.soRegistration.fields.profile_form') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('profile_form') ? 'is-invalid' : '' }}"
                        id="profile_form-dropzone">
                    </div>
                    @if ($errors->has('profile_form'))
                        <span class="text-danger">{{ $errors->first('profile_form') }}</span>
                    @endif
                    <span class="text-muted" style="font-size: small;">Only PDF file allowed (Max. 3 MB) </span>
                    <span class="help-block">{{ trans('cruds.soRegistration.fields.profile_form_helper') }}</span>
                </div>
                <div class="form-group">
                    <label
                        for="parent_consent_form">{{ trans('cruds.soRegistration.fields.parent_consent_form') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('parent_consent_form') ? 'is-invalid' : '' }}"
                        id="parent_consent_form-dropzone">
                    </div>
                    @if ($errors->has('parent_consent_form'))
                        <span class="text-danger">{{ $errors->first('parent_consent_form') }}</span>
                    @endif
                    <span class="text-muted" style="font-size: small;">Only PDF file allowed (Max. 3 MB) </span>
                    <span class="help-block">{{ trans('cruds.soRegistration.fields.parent_consent_form_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="data_privacy_form">{{ trans('cruds.soRegistration.fields.data_privacy_form') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('data_privacy_form') ? 'is-invalid' : '' }}"
                        id="data_privacy_form-dropzone">
                    </div>
                    @if ($errors->has('data_privacy_form'))
                        <span class="text-danger">{{ $errors->first('data_privacy_form') }}</span>
                    @endif
                    <span class="text-muted" style="font-size: small;">Only PDF file allowed (Max. 3 MB) </span>
                    <span class="help-block">{{ trans('cruds.soRegistration.fields.data_privacy_form_helper') }}</span>
                </div>

                <div class="form-group">
                    <label for="med_cert">Medical Certificate</label>
                    <div class="needsclick dropzone {{ $errors->has('med_cert') ? 'is-invalid' : '' }}"
                        id="med_cert-dropzone">
                    </div>
                    @if ($errors->has('med_cert'))
                        <span class="text-danger">{{ $errors->first('med_cert') }}</span>
                    @endif
                    <span class="text-muted" style="font-size: small;">Only PDF file allowed (Max. 3 MB) </span>
                </div>
                <div class="form-group">
                    <label for="date_filed">{{ trans('cruds.soRegistration.fields.date_filed') }}</label>
                    <input class="form-control date {{ $errors->has('date_filed') ? 'is-invalid' : '' }}" type="text"
                        name="date_filed" id="date_filed" value="{{ old('date_filed', $soRegistration->date_filed) }}"
                        readonly>
                    @if ($errors->has('date_filed'))
                        <span class="text-danger">{{ $errors->first('date_filed') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.soRegistration.fields.date_filed_helper') }}</span>
                </div>
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
                // width: 1024,
                // height: 1024
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

                @if (isset($soRegistration) && $soRegistration->med_cert)
                    var file = {!! json_encode($soRegistration->med_cert) !!}
                    this.options.addedfile.call(this, file)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="med_cert" value="' + file.file_name +
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
