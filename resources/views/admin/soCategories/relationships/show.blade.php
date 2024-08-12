@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header bg-success text-white">
        {{ trans('global.show') }} {{ trans('cruds.soCategory.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.so-categories.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.soCategory.fields.category_name') }}
                        </th>
                        <td>
                            {{ $soCategory->category_name }}
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="table-responsive">
                <form action="{{ route('admin.so-lists.massDestroy') }}" method="POST" id="mass_destroy_form">
                    @csrf
                    @method('DELETE')

                    <table class="table table-bordered table-striped table-hover datatable datatable-soCategorySoLists">
                        <thead>
                            <tr>
                                <th width="10">
                                    
                                </th>
                                <th>{{ trans('cruds.soList.fields.so_name') }}</th>
                                <th>{{ trans('cruds.soList.fields.org_pres') }}</th>
                                <th>{{ trans('cruds.soList.fields.so_category') }}</th>
                                <th>{{ trans('cruds.soList.fields.logo') }}</th>
                                <th>{{ trans('cruds.soList.fields.overview') }}</th>
                                {{-- <th>{{ trans('cruds.soList.fields.expired_at') }}</th> --}}
                                {{-- <th>{{ trans('cruds.soList.fields.created_by') }}</th> --}}
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($soCategory->soCategorySoLists as $key => $soList)
                                <tr data-entry-id="{{ $soList->id }}">
                                    <td>
                                        <input type="checkbox" name="ids[]" value="{{ $soList->id }}">
                                    </td>
                                    <td><a href="{{ route('admin.so-lists.show', $soList->id) }}">{{ $soList->so_name ?? '' }}</a></td>
                                    <td>{{ $soList->created_by->name ?? '' }}</td>
                                    <td>{{ $soList->so_category->category_name ?? '' }}</td>
                                    <td>
                                        @if($soList->banner)
                                            <a href="{{ $soList->banner->getUrl() }}" target="_blank" style="display: inline-block">
                                                <img src="{{ $soList->banner->getUrl('thumb') }}">
                                            </a>
                                        @endif
                                    </td>
                                    <td>{{ $soList->overview ?? '' }}</td>
                                    {{-- <td>{{ $soList->expired_at ?? '' }}</td> --}}
                                    <td>
                                        {{-- @can('so_list_show')
                                            <a class="btn btn-xs btn-primary" href="{{ route('admin.so-lists.show', $soList->id) }}">
                                                {{ trans('global.view') }}
                                            </a>
                                        @endcan --}}
                                        @can('so_list_edit')
                                            <a class="btn btn-xs btn-info" href="{{ route('admin.so-lists.edit', $soList->id) }}">
                                                {{ trans('global.edit') }}
                                            </a>
                                        @endcan
                                        @can('so_list_delete')
                                            <form action="{{ route('admin.so-lists.destroy', $soList->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('#select_all').click(function () {
            $('input[type="checkbox"]').prop('checked', this.checked);
        });

        $('.datatable-soCategorySoLists').DataTable({
            order: [[1, 'desc']],
            pageLength: 25,
        });

        $('#mass_destroy').on('submit', function (e) {
            if (confirm('{{ trans('global.areYouSure') }}')) {
                return true;
            } else {
                e.preventDefault();
            }
        });
    });
</script>
@endpush
