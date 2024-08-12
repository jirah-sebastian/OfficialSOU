@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.organizationApplicationForm.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.organization-application-forms.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="filename">{{ trans('cruds.organizationApplicationForm.fields.filename') }}</label>
                <input class="form-control {{ $errors->has('filename') ? 'is-invalid' : '' }}" type="text" name="filename" id="filename" value="{{ old('filename', '') }}">
                @if($errors->has('filename'))
                    <span class="text-danger">{{ $errors->first('filename') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.organizationApplicationForm.fields.filename_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="application_form">{{ trans('cruds.organizationApplicationForm.fields.application_form') }}</label>
                <div class="needsclick dropzone {{ $errors->has('application_form') ? 'is-invalid' : '' }}" id="application_form-dropzone">
                </div>
                @if($errors->has('application_form'))
                    <span class="text-danger">{{ $errors->first('application_form') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.organizationApplicationForm.fields.application_form_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="organization_id">{{ trans('cruds.organizationApplicationForm.fields.organization') }}</label>
                <select class="form-control select2 {{ $errors->has('organization') ? 'is-invalid' : '' }}" name="organization_id" id="organization_id">
                    @foreach($organizations as $id => $entry)
                        <option value="{{ $id }}" {{ old('organization_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('organization'))
                    <span class="text-danger">{{ $errors->first('organization') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.organizationApplicationForm.fields.organization_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection

@section('scripts')
<script>
    Dropzone.options.applicationFormDropzone = {
    url: '{{ route('admin.organization-application-forms.storeMedia') }}',
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
      $('form').find('input[name="application_form"]').remove()
      $('form').append('<input type="hidden" name="application_form" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="application_form"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($organizationApplicationForm) && $organizationApplicationForm->application_form)
      var file = {!! json_encode($organizationApplicationForm->application_form) !!}
          this.options.addedfile.call(this, file)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="application_form" value="' + file.file_name + '">')
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