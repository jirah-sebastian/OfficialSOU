@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header" style="background-color: #005600; color:white;">
      <strong>ADD ABOUT</strong>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.abouts.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="title">{{ trans('cruds.about.fields.title') }}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', '') }}" required>
                @if($errors->has('title'))
                    <span class="text-danger">This is a required field.</span>
                @endif
                <span class="help-block">{{ trans('cruds.about.fields.title_helper') }}</span>
            </div>
            {{-- <div class="form-group">
                <label for="side_view_content">{{ trans('cruds.about.fields.side_view_content') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('side_view_content') ? 'is-invalid' : '' }}" name="side_view_content" id="side_view_content">{!! old('side_view_content') !!}</textarea>
                @if($errors->has('side_view_content'))
                    <span class="text-danger">{{ $errors->first('side_view_content') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.about.fields.side_view_content_helper') }}</span>
            </div> --}}
            <div class="form-group">
                <label for="main_content">{{ trans('cruds.about.fields.main_content') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('main_content') ? 'is-invalid' : '' }}" name="main_content" id="main_content">{!! old('main_content') !!}</textarea>
                @if($errors->has('main_content'))
                    <span class="text-danger">This is a required field.</span>
                @endif
                <span class="help-block">{{ trans('cruds.about.fields.main_content_helper') }}</span>
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
    $(document).ready(function () {
  function SimpleUploadAdapter(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
      return {
        upload: function() {
          return loader.file
            .then(function (file) {
              return new Promise(function(resolve, reject) {
                // Init request
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '{{ route('admin.abouts.storeCKEditorImages') }}', true);
                xhr.setRequestHeader('x-csrf-token', window._token);
                xhr.setRequestHeader('Accept', 'application/json');
                xhr.responseType = 'json';

                // Init listeners
                var genericErrorText = `Couldn't upload file: ${ file.name }.`;
                xhr.addEventListener('error', function() { reject(genericErrorText) });
                xhr.addEventListener('abort', function() { reject() });
                xhr.addEventListener('load', function() {
                  var response = xhr.response;

                  if (!response || xhr.status !== 201) {
                    return reject(response && response.message ? `${genericErrorText}\n${xhr.status} ${response.message}` : `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`);
                  }

                  $('form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');

                  resolve({ default: response.url });
                });

                if (xhr.upload) {
                  xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                      loader.uploadTotal = e.total;
                      loader.uploaded = e.loaded;
                    }
                  });
                }

                // Send request
                var data = new FormData();
                data.append('upload', file);
                data.append('crud_id', '{{ $about->id ?? 0 }}');
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

@endsection