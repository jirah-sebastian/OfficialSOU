@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header" style="background-color: #005600; color:white;">
        <strong>EDIT PERMISSION</strong>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.permissions.update", [$permission->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="title">{{ trans('cruds.permission.fields.title') }}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', $permission->title) }}" required>
                @if($errors->has('title'))
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.permission.fields.title_helper') }}</span>
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