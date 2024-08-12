@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header" style="background-color: #005600; color:white;">
                <strong>MY PROFILE</strong>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route("profile.password.updateProfile") }}">
                    @csrf
                    @if ($user->profile)
                    <div class="text-center">
                        <a href="{{ $user->profile->getUrl() }}" target="_blank">
                            <img class="profile-user-img img-fluid rounded-circle" 
                                 src="{{ $user->profile->getUrl() }}" 
                                 alt="User profile picture" 
                                 style="width: 200px; height: 200px; display: block; margin: 0 auto;">
                        </a>
                    </div>
                @endif
                    <div class="form-group">
                        <label class="required" for="name">{{ trans('cruds.user.fields.name') }}</label>
                        <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}" required {{ auth()->user()->is_pres ? 'disabled' : '' }}>
                        @if($errors->has('name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="required" for="title">{{ trans('cruds.user.fields.email') }}</label>
                        <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="text" name="email" id="email" value="{{ old('email', auth()->user()->email) }}" required {{ auth()->user()->is_pres ? 'disabled' : '' }}>
                        @if($errors->has('email'))
                            <div class="invalid-feedback">
                                {{ $errors->first('email') }}
                            </div>
                        @endif
                    </div>

                    @if ($user->roles->contains('id', 3))
                    <div class="form-group">
                        <label class="required" for="so_name">SO Name</label>
                        <input class="form-control {{ $errors->has('so_name') ? 'is-invalid' : '' }}" type="text" name="so_name" id="so_name" value="{{ old('so_name', auth()->user()->so_name) }}" required {{ auth()->user()->is_pres ? 'disabled' : '' }}>
                        @if($errors->has('so_name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('so_name') }}
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="course">{{ trans('cruds.user.fields.course') }}</label>
                        <input required class="form-control {{ $errors->has('course') ? 'is-invalid' : '' }}" type="text" name="course" id="course" value="{{ old('course', auth()->user()->course) }}" disabled>
                        @if($errors->has('course'))
                            <span class="text-danger">{{ $errors->first('course') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.course_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.user.fields.year') }}</label>
                        <select required class="form-control {{ $errors->has('year') ? 'is-invalid' : '' }}" name="year" id="year" disabled >
                            <option value disabled {{ old('year', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                            @foreach(App\Models\User::YEAR_SELECT as $key => $label)
                                <option value="{{ $key }}" {{ old('year', auth()->user()->year) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('year'))
                            <span class="text-danger">{{ $errors->first('year') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.year_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="religion">{{ trans('cruds.user.fields.religion') }}</label>
                        <input required class="form-control {{ $errors->has('religion') ? 'is-invalid' : '' }}" type="text" name="religion" id="religion" value="{{ old('religion', auth()->user()->religion) }} " disabled>
                        @if($errors->has('religion'))
                            <span class="text-danger">{{ $errors->first('religion') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.religion_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="nationality">{{ trans('cruds.user.fields.nationality') }}</label>
                        <input required class="form-control {{ $errors->has('nationality') ? 'is-invalid' : '' }}" type="text" name="nationality" id="nationality" value="{{ old('nationality', auth()->user()->nationality) }} "disabled>
                        @if($errors->has('nationality'))
                            <span class="text-danger">{{ $errors->first('nationality') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.nationality_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="birthdate">{{ trans('cruds.user.fields.birthdate') }}</label>
                        <input required class="form-control date {{ $errors->has('birthdate') ? 'is-invalid' : '' }}" type="text" name="birthdate" id="birthdate" value="{{ old('birthdate', auth()->user()->birthdate) }}" disabled>
                        @if($errors->has('birthdate'))
                            <span class="text-danger">{{ $errors->first('birthdate') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.birthdate_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="birthplace">{{ trans('cruds.user.fields.birthplace') }}</label>
                        <input required class="form-control {{ $errors->has('birthplace') ? 'is-invalid' : '' }}" type="text" name="birthplace" id="birthplace" value="{{ old('birthplace', auth()->user()->birthplace) }}" disabled>
                        @if($errors->has('birthplace'))
                            <span class="text-danger">{{ $errors->first('birthplace') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.birthplace_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="present_address">{{ trans('cruds.user.fields.present_address') }}</label>
                        <input required class="form-control {{ $errors->has('present_address') ? 'is-invalid' : '' }}" type="text" name="present_address" id="present_address" value="{{ old('present_address', auth()->user()->present_address) }}" disabled>
                        @if($errors->has('present_address'))
                            <span class="text-danger">{{ $errors->first('present_address') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.present_address_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="home_address">{{ trans('cruds.user.fields.home_address') }}</label>
                        <input required class="form-control {{ $errors->has('home_address') ? 'is-invalid' : '' }}" type="text" name="home_address" id="home_address" value="{{ old('home_address', auth()->user()->home_address) }}" disabled>
                        @if($errors->has('home_address'))
                            <span class="text-danger">{{ $errors->first('home_address') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.home_address_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="contact_no">{{ trans('cruds.user.fields.contact_no') }}</label>
                        <input required class="form-control {{ $errors->has('contact_no') ? 'is-invalid' : '' }}" type="text" name="contact_no" id="contact_no" value="{{ old('contact_no', auth()->user()->contact_no) }}" disabled>
                        @if($errors->has('contact_no'))
                            <span class="text-danger">{{ $errors->first('contact_no') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.contact_no_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="father_name">{{ trans('cruds.user.fields.father_name') }}</label>
                        <input required class="form-control {{ $errors->has('father_name') ? 'is-invalid' : '' }}" type="text" name="father_name" id="father_name" value="{{ old('father_name', auth()->user()->father_name) }}" disabled>
                        @if($errors->has('father_name'))
                            <span class="text-danger">{{ $errors->first('father_name') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.father_name_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="father_contact_no">{{ trans('cruds.user.fields.father_contact_no') }}</label>
                        <input required class="form-control {{ $errors->has('father_contact_no') ? 'is-invalid' : '' }}" type="text" name="father_contact_no" id="father_contact_no" value="{{ old('father_contact_no', auth()->user()->father_contact_no) }}" disabled>
                        @if($errors->has('father_contact_no'))
                            <span class="text-danger">{{ $errors->first('father_contact_no') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.father_contact_no_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="mother_name">{{ trans('cruds.user.fields.mother_name') }}</label>
                        <input required class="form-control {{ $errors->has('mother_name') ? 'is-invalid' : '' }}" type="text" name="mother_name" id="mother_name" value="{{ old('mother_name', auth()->user()->mother_name) }}" disabled>
                        @if($errors->has('mother_name'))
                            <span class="text-danger">{{ $errors->first('mother_name') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.mother_name_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="mothers_contact_no">{{ trans('cruds.user.fields.mothers_contact_no') }}</label>
                        <input required class="form-control {{ $errors->has('mothers_contact_no') ? 'is-invalid' : '' }}" type="text" name="mothers_contact_no" id="mothers_contact_no" value="{{ old('mothers_contact_no', auth()->user()->mothers_contact_no) }}" disabled>
                        @if($errors->has('mothers_contact_no'))
                            <span class="text-danger">{{ $errors->first('mothers_contact_no') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.mothers_contact_no_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="source_of_financial_support">{{ trans('cruds.user.fields.source_of_financial_support') }}</label>
                        <input required class="form-control {{ $errors->has('source_of_financial_support') ? 'is-invalid' : '' }}" type="text" name="source_of_financial_support" id="source_of_financial_support" value="{{ old('source_of_financial_support', auth()->user()->source_of_financial_support) }}" disabled>
                        @if($errors->has('source_of_financial_support'))
                            <span class="text-danger">{{ $errors->first('source_of_financial_support') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.source_of_financial_support_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="talent_skills">{{ trans('cruds.user.fields.talent_skills') }}</label>
                        <input required class="form-control {{ $errors->has('talent_skills') ? 'is-invalid' : '' }}" type="text" name="talent_skills" id="talent_skills" value="{{ old('talent_skills', auth()->user()->talent_skills) }}" disabled>
                        @if($errors->has('talent_skills'))
                            <span class="text-danger">{{ $errors->first('talent_skills') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.talent_skills_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="date_filed">{{ trans('cruds.user.fields.date_filed') }}</label>
                        <input required class="form-control date {{ $errors->has('date_filed') ? 'is-invalid' : '' }}" type="text" name="date_filed" id="date_filed" value="{{ old('date_filed', auth()->user()->date_filed) }}" disabled>
                        @if($errors->has('date_filed'))
                            <span class="text-danger">{{ $errors->first('date_filed') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.date_filed_helper') }}</span>
                    </div>
                    @endif
                    @if ($user->roles->contains('id', 2))
                    <div class="form-group">

                                <button class="btn btn-primary" type="submit">
                                    {{ trans('global.save') }}
                                </button>
                    </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header" style="background-color: #005600; color:white;">
                <strong>CHANGE PASSWORD</strong>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route("profile.password.update") }}">
                    @csrf
                    <div class="form-group">
                        <label class="required" for="password">New {{ trans('cruds.user.fields.password') }}</label>
                        <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password" name="password" id="password" required>
                        <small class="text-danger" id="passwordErrorMessage" style="display: none;">
                            Password must contain at least one digit, one lowercase letter, one uppercase letter, and be at least 8 characters long.
                        </small>
                        @if($errors->has('password'))
                            <div class="invalid-feedback">
                                {{ $errors->first('password') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="required" for="password_confirmation">Repeat New {{ trans('cruds.user.fields.password') }}</label>
                        <input class="form-control" type="password" name="password_confirmation" id="password_confirmation" required>
                        <small class="text-danger" id="passwordConfirmationError" style="display: none;">
                            Password confirmation does not match the password.
                        </small>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-success" type="submit">
                            {{ trans('global.save') }}
                        </button>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
</div>
{{-- @if (!auth()->user()->is_pres)
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                {{ trans('global.delete_account') }}
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route("profile.password.destroyProfile") }}" onsubmit="return prompt('{{ __('global.delete_account_warning') }}') == '{{ auth()->user()->email }}'">
                    @csrf
                    <div class="form-group">
                        <button class="btn btn-danger" type="submit">
                            {{ trans('global.delete') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endif --}}

<script>
    document.getElementById('password').addEventListener('input', function() {
        var password = this.value;
        var isValid = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/.test(password);
        var errorMessage = document.getElementById('passwordErrorMessage');
        if (isValid) {
            this.removeAttribute('title');
            errorMessage.style.display = 'none';
        } else {
            this.setAttribute('title',
                'Password must contain at least one digit, one lowercase letter, one uppercase letter, and be at least 8 characters long.'
            );
            errorMessage.style.display = 'block';
        }
    });

    document.getElementById('password_confirmation').addEventListener('input', function() {
        var password = document.getElementById('password').value;
        var confirmPassword = this.value;
        var passwordConfirmationError = document.getElementById('passwordConfirmationError');
        // Check if passwords match
        if (password !== confirmPassword) {
            // Show error message
            passwordConfirmationError.style.display = 'block';
        } else {
            // Hide error message
            passwordConfirmationError.style.display = 'none';
        }
    });
    
</script>
@endsection