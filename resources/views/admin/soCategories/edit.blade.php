@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header" style="background-color: #005600; color:white;">
        <strong>EDIT SO CATEGORY</strong>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.so-categories.update", [$soCategory->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="category_name">{{ trans('cruds.soCategory.fields.category_name') }}</label>
                <input class="form-control {{ $errors->has('category_name') ? 'is-invalid' : '' }}" type="text" name="category_name" id="category_name" value="{{ old('category_name', $soCategory->category_name) }}" required>
                @if($errors->has('category_name'))
                    <span class="text-danger">{{ $errors->first('category_name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.soCategory.fields.category_name_helper') }}</span>
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