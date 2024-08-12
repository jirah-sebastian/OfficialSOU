@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header" style="background-color: #005600; color:white;">
            <strong>SHOW RESOURCE</strong>
        </div>


        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.resources.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                @if (!auth()->user()->is_pres)
                    <div class="form-group">
                        @if (!$resource->deleted_at)
                            <a href="{{ route('admin.resources.edit', $resource->id) }}" class="btn btn-warning"><i
                                    class="fa fa-edit"></i><b>Edit</b></a>
                        @endif
                        @if ($resource->deleted_at)
                            <a href="{{ route('admin.resource.restore', [$resource->id, 'restore']) }}"
                                class="btn btn-success"><i class="fa fa-sync-alt"></i>&nbsp;<b>Restore</b></a>
                        @else
                            <a href="{{ route('admin.resource.restore', [$resource->id, 'delete']) }}"
                                class="btn btn-danger"><i class="fa fa-trash"></i>&nbsp;<b>Archive</b></a>
                        @endif
                    </div>
                @endif
                <table class="table table-bordered table-striped">
                    <tbody>
                        {{-- <tr>
                        <th>
                            {{ trans('cruds.resource.fields.id') }}
                        </th>
                        <td>
                            {{ $resource->id }}
                        </td>
                    </tr> --}}
                        <tr>
                            <th class="custom-th-width">
                                {{ trans('cruds.resource.fields.title') }}
                            </th>
                            <td>
                                {{ $resource->title }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.resource.fields.file') }}
                            </th>
                            <td>
                                @if ($resource->file)
                                    <a href="{{ asset($resource->file->getUrl()) }}" target="_blank">
                                        {{ trans('global.view_file') }}
                                    </a>

                                    </a>
                                @endif
                            </td>
                        </tr>
                        {{-- <tr>
                        <th>
                            {{ trans('cruds.resource.fields.is_published') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $resource->is_published ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.resource.fields.created_by') }}
                        </th>
                        <td>
                            {{ $resource->created_by->name ?? '' }}
                        </td>
                    </tr> --}}
                        <tr>
                            <th>
                                Date Uploaded
                            </th>
                            <td>
                                {{ $resource->created_at ?? '' }}
                            </td>
                        </tr>

                        @if ($resource->updated_at)
                        <tr>
                            <th>
                                Updated At
                            </th>
                            <td>
                                {{ $resource->updated_at ?? '' }}
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>

            </div>
        </div>
    </div>


    <style>
        .custom-th-width {
            width: 150px;
        }
    </style>
@endsection
