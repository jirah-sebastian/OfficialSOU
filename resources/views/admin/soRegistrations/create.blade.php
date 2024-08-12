@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header" style="background-color: #005600; color:white;">
        <strong>ADD MEMBER</strong>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.so-registrations.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="profile_picture">{{ trans('cruds.soRegistration.fields.profile_picture') }}</label>
                <div class="needsclick dropzone {{ $errors->has('profile_picture') ? 'is-invalid' : '' }}" id="profile_picture-dropzone">
                </div>
                @if($errors->has('profile_picture'))
                    <span class="text-danger">{{ $errors->first('profile_picture') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.soRegistration.fields.profile_picture_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="full_name">{{ trans('cruds.soRegistration.fields.full_name') }}</label>
                <input class="form-control {{ $errors->has('full_name') ? 'is-invalid' : '' }}" type="text" name="full_name" id="full_name" value="{{ old('full_name', '') }}">
                @if($errors->has('full_name'))
                    <span class="text-danger">{{ $errors->first('full_name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.soRegistration.fields.full_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="email">{{ trans('cruds.soRegistration.fields.email') }}</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email') }}">
                @if($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.soRegistration.fields.email_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="so_list_id">{{ trans('cruds.soRegistration.fields.so_list') }}</label>
                <select class="form-control select2 {{ $errors->has('so_list') ? 'is-invalid' : '' }}" name="so_list_id" id="so_list_id">
                    @foreach($so_lists as $id => $entry)
                        <option value="{{ $id }}" {{ old('so_list_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('so_list'))
                    <span class="text-danger">{{ $errors->first('so_list') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.soRegistration.fields.so_list_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.soRegistration.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\SoRegistration::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <span class="text-danger">{{ $errors->first('status') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.soRegistration.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.soRegistration.fields.membership_type') }}</label>
                <select class="form-control {{ $errors->has('membership_type') ? 'is-invalid' : '' }}" name="membership_type" id="membership_type">
                    <option value disabled {{ old('membership_type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\SoRegistration::MEMBERSHIP_TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('membership_type', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('membership_type'))
                    <span class="text-danger">{{ $errors->first('membership_type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.soRegistration.fields.membership_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="title_id">{{ trans('cruds.soRegistration.fields.title') }}</label>
                <select class="form-control select2 {{ $errors->has('title') ? 'is-invalid' : '' }}" name="title_id" id="title_id">
                    @foreach($titles as $id => $entry)
                        <option value="{{ $id }}" {{ old('title_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('title'))
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.soRegistration.fields.title_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="profile_form">{{ trans('cruds.soRegistration.fields.profile_form') }}</label>
                <div class="needsclick dropzone {{ $errors->has('profile_form') ? 'is-invalid' : '' }}" id="profile_form-dropzone">
                </div>
                @if($errors->has('profile_form'))
                    <span class="text-danger">{{ $errors->first('profile_form') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.soRegistration.fields.profile_form_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="parent_consent_form">{{ trans('cruds.soRegistration.fields.parent_consent_form') }}</label>
                <div class="needsclick dropzone {{ $errors->has('parent_consent_form') ? 'is-invalid' : '' }}" id="parent_consent_form-dropzone">
                </div>
                @if($errors->has('parent_consent_form'))
                    <span class="text-danger">{{ $errors->first('parent_consent_form') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.soRegistration.fields.parent_consent_form_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="data_privacy_form">{{ trans('cruds.soRegistration.fields.data_privacy_form') }}</label>
                <div class="needsclick dropzone {{ $errors->has('data_privacy_form') ? 'is-invalid' : '' }}" id="data_privacy_form-dropzone">
                </div>
                @if($errors->has('data_privacy_form'))
                    <span class="text-danger">{{ $errors->first('data_privacy_form') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.soRegistration.fields.data_privacy_form_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-primary" type="submit">
                    {{ trans('global.save') }}
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
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="profile_picture"]').remove()
      $('form').append('<input type="hidden" name="profile_picture" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="profile_picture"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($soRegistration) && $soRegistration->profile_picture)
      var file = {!! json_encode($soRegistration->profile_picture) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="profile_picture" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
    error: function (file, response) {
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
    maxFilesize: 2, // MB
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2
    },
    success: function (file, response) {
      $('form').find('input[name="profile_form"]').remove()
      $('form').append('<input type="hidden" name="profile_form" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="profile_form"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($soRegistration) && $soRegistration->profile_form)
      var file = {!! json_encode($soRegistration->profile_form) !!}
          this.options.addedfile.call(this, file)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="profile_form" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
     error: function (file, response) {
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
    Dropzone.options.parentConsentFormDropzone = {
    url: '{{ route('admin.so-registrations.storeMedia') }}',
    maxFilesize: 2, // MB
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2
    },
    success: function (file, response) {
      $('form').find('input[name="parent_consent_form"]').remove()
      $('form').append('<input type="hidden" name="parent_consent_form" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="parent_consent_form"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($soRegistration) && $soRegistration->parent_consent_form)
      var file = {!! json_encode($soRegistration->parent_consent_form) !!}
          this.options.addedfile.call(this, file)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="parent_consent_form" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
     error: function (file, response) {
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
    Dropzone.options.dataPrivacyFormDropzone = {
    url: '{{ route('admin.so-registrations.storeMedia') }}',
    maxFilesize: 2, // MB
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2
    },
    success: function (file, response) {
      $('form').find('input[name="data_privacy_form"]').remove()
      $('form').append('<input type="hidden" name="data_privacy_form" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="data_privacy_form"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($soRegistration) && $soRegistration->data_privacy_form)
      var file = {!! json_encode($soRegistration->data_privacy_form) !!}
          this.options.addedfile.call(this, file)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="data_privacy_form" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
     error: function (file, response) {
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
@endsection