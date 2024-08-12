@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header" style="background-color: #005600; color:white;">
            <strong>CREATE USER</strong>
        </div>

        <div class="card-body">
            <form id="user-form" method="POST" action="{{ route('admin.users.store') }}" enctype="multipart/form-data">
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
                        id="name" value="{{ old('name', '') }}" required>
                    @if ($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.user.fields.name_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="email">{{ trans('cruds.user.fields.email') }}</label>
                    <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email"
                        name="email" id="email" value="{{ old('email') }}" required>
                    @if ($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.user.fields.email_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="password">{{ trans('cruds.user.fields.password') }}</label>
                    <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password"
                        name="password" id="password" required>
                    <small id="passwordErrorMessage" class="text-danger" style="display: none;">
                        Password must contain at least one digit, one lowercase letter, one uppercase letter, and be at
                        least 8 characters long.
                    </small>

                    @if ($errors->has('password'))
                        <span class="text-danger">{{ $errors->first('password') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.user.fields.password_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required"
                        for="password_confirmation">{{ trans('global.login_password_confirmation') }}</label>
                    <input class="form-control" type="password" name="password_confirmation" id="password_confirmation"
                        required>
                    <small id="passwordConfirmationError" class="text-danger" style="display: none;">
                        Password confirmation does not match the password.
                    </small>
                </div>
                <div class="form-group">
                    <label class="required" for="roles">{{ trans('cruds.user.fields.roles') }}</label>
                    <select class="form-control select2 {{ $errors->has('roles') ? 'is-invalid' : '' }}" name="roles[]"
                        id="roles" required>
                        <option value="2" selected>{{ $roles[2] }}</option>
                    </select>
                    @if ($errors->has('roles'))
                        <span class="text-danger">{{ $errors->first('roles') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.user.fields.roles_helper') }}</span>
                </div>

                {{-- <div class="form-group">
                <div class="form-check {{ $errors->has('approved') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="approved" value="0">
                    <input class="form-check-input" type="checkbox" name="approved" id="approved" value="1" {{ old('approved', 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="approved">{{ trans('cruds.user.fields.approved') }}</label>
                </div>
                @if ($errors->has('approved'))
                    <span class="text-danger">{{ $errors->first('approved') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.approved_helper') }}</span>
            </div> --}}
                <div class="form-group">
                    <button class="btn btn-success" type="submit">
                        <i class="fas fa-save"></i><b> {{ trans('global.save') }} </b>
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

                $('form').append('<img src="" alt="">')
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
        document.getElementById('password').addEventListener('input', function() {
            var password = this.value;
            var isValid = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/.test(password);
            var errorMessage = document.getElementById('passwordErrorMessage');
            var formatError = document.getElementById('passwordFormatError');
            if (isValid) {
                this.removeAttribute('title');
                errorMessage.style.display = 'none';
                formatError.style.display = 'none';
            } else {
                this.setAttribute('title',
                    'Password must contain at least one digit, one lowercase letter, one uppercase letter, and be at least 8 characters long.'
                );
                errorMessage.style.display = 'block';
                formatError.style.display = 'block';
            }
        });

        document.getElementById('password_confirmation').addEventListener('input', function() {
            var password = document.getElementById('password').value;
            var confirmPassword = this.value;
            var passwordConfirmationError = document.getElementById('passwordConfirmationError');
            var passwordFormatError = document.getElementById('passwordFormatError');
            // Check if passwords match
            if (password !== confirmPassword) {
                // Show error message
                passwordConfirmationError.style.display = 'block';
            } else {
                // Hide error message
                passwordConfirmationError.style.display = 'none';
            }
        });

        // Validate password format before form submission
        document.getElementById('user-form').addEventListener('submit', function(event) {
            var password = document.getElementById('password').value;
            var isValid = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/.test(password);
            var formatError = document.getElementById('passwordFormatError');
            if (!isValid) {
                event.preventDefault(); // Prevent form submission
                formatError.style.display = 'block'; // Show format error message
            }
        });
    </script>
@endsection
