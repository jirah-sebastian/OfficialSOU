@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header" style="background-color: #005600; color:white;">
            <strong>VIEW ABOUT</strong>
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    {{-- <a class="btn btn-default" href="{{ route('admin.abouts.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>  --}}

                    {{-- <a class="btn btn-success" href="{{ route('admin.abouts.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.about.title_singular') }}
                </a> --}}
                    <div class="form-group" style="margin-top: 10px;">
                        @if ($about->title && $about->main_content)
                            @can('about_edit')
                                <a class="btn btn-warning" href="{{ route('admin.abouts.edit', $about->id) }}">
                                    <i class="fa fa-edit"></i><b>{{ trans('global.edit') }}</b>
                                </a>
                            @endcan
                        @endif

                        {{-- @can('about_delete')
                        <form action="{{ route('admin.abouts.destroy', $about->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="submit" class="btn btn-danger" value="{{ trans('global.delete') }}">
                        </form>
                    @endcan --}}
                    </div>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                        {{-- <tr>
                        <th>
                            {{ trans('cruds.about.fields.id') }}
                        </th>
                        <td>
                            {{ $about->id }}
                        </td>
                    </tr> --}}
                        <tr>
                            <th>
                                {{ trans('cruds.about.fields.title') }}
                            </th>
                            <td>
                                {{ $about->title }}
                            </td>
                        </tr>
                        {{-- <tr>
                        <th>
                            {{ trans('cruds.about.fields.side_view_content') }}
                        </th>
                        <td>
                            {!! $about->side_view_content !!}
                        </td>
                    </tr> --}}
                        <tr>
                            <th>
                                {{ trans('cruds.about.fields.main_content') }}
                            </th>
                            <td>
                                {!! $about->main_content !!}
                            </td>
                        </tr>
                    </tbody>
                </table>
                {{-- <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.abouts.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div> --}}
            </div>
        </div>
    </div>
@endsection
