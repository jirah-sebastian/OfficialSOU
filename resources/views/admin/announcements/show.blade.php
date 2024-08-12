@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header" style="background-color: #005600; color:white;">
            <strong>VIEW ANNOUNCEMENT</strong>
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.announcements.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <div class="form-group">
                    @if (!auth()->user()->is_pres)
                        @if (!$announcement->deleted_at)
                            <a href="{{ route('admin.announcements.edit', $announcement->id) }}" class="btn btn-warning"><i
                                    class="fa fa-edit"><b></i>Edit</b></a>
                        @endif
                        @if ($announcement->deleted_at)
                            <a href="{{ route('admin.announcement.restore', [$announcement->id, 'restore']) }}"
                                class="btn btn-success"><i class="fa fa-sync-alt"></i>&nbsp;<b>Restore</b></a>
                        @else
                            <a href="{{ route('admin.announcement.restore', [$announcement->id, 'delete']) }}"
                                class="btn btn-danger"><i class="fa fa-trash"></i>&nbsp;<b>Archive</b></a>
                        @endif
                    @endif
                </div>


                <table class="table table-bordered table-striped">
                    <tbody>
                        {{-- <tr>
                        <th>
                            {{ trans('cruds.announcement.fields.id') }}
                        </th>
                        <td>
                            {{ $announcement->id }}
                        </td>
                    </tr> --}}
                        <tr>
                            <th class="custom-th-width">
                                {{ trans('cruds.announcement.fields.title') }}
                            </th>
                            <td>
                                {{ $announcement->title }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Announcement {{ trans('cruds.announcement.fields.content') }}
                            </th>
                            <td>
                                {!! $announcement->content !!}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.announcement.fields.photo') }}
                            </th>
                            <td>
                                @if ($announcement->photo)
                                    <a href="{{ $announcement->photo->getUrl() }}" target="_blank"
                                        style="display: inline-block">
                                        <img src="{{ $announcement->photo->getUrl('thumb') }}">
                                    </a>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Date Created
                            </th>
                            <td>
                                {{ $announcement->created_at ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.announcement.fields.is_published') }}
                            </th>
                            <td>
                                {{-- <input type="checkbox" disabled="disabled" {{ $announcement->is_published ? 'checked' : '' }}> --}}
                                {{ $announcement->is_published }}
                            </td>
                        </tr>

                        @if ($announcement->updated_at)
                            <tr>
                                <th>
                                    Updated At
                                </th>
                                <td>
                                    {{ $announcement->updated_at ?? '' }}
                                </td>
                            </tr>
                        @endif
                        {{-- <tr>
                        <th>
                            {{ trans('cruds.announcement.fields.created_by') }}
                        </th>
                        <td>
                            {{ $announcement->created_by->name ?? '' }}
                        </td>
                    </tr> --}}

                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <style>
        .custom-th-width {
            width: 100px;
        }
    </style>

@endsection
