@extends('layouts.admin')
@section('content')
    @can('so_category_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-warning" href="{{ route('admin.so-categories.create') }}">
                    <i class="fas fa-plus-circle"></i><b> {{ trans('global.add') }} {{ trans('cruds.soCategory.title_singular') }} </b>
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header" style="background-color: #005600; color:white;">
            <strong>SO CATEGORIES LIST</strong>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover datatable datatable-SoCategory">
                    <thead>
                        <tr>
                            <th width="10"></th>
                            <th>{{ trans('cruds.soCategory.fields.category_name') }}</th>
                            <th>{{ trans('global.status') }}</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($soCategories as $key => $soCategory)
                            <tr data-entry-id="{{ $soCategory->id }}">
                                <td></td>
                                <td>
                                    <a href="{{ route('admin.so-categories.show', $soCategory->id) }}" style="color: green;">
                                        {{ $soCategory->category_name ?? '' }}
                                    </a>
                                </td>
                                
                                <td>
                                    @if ($soCategory->deleted_at)
                                        <span class="badge badge-dark">Archived</span>
                                    @else
                                        <span class="badge badge-success">Available</span>
                                    @endif
                                </td>
                                <td>
                                    @can('so_category_edit')
                                        <a class="btn btn-xs btn-warning"
                                            href="{{ route('admin.so-categories.edit', $soCategory->id) }}">
                                            <i class="fa fa-edit"></i> {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @if ($soCategory->deleted_at)
                                    <form action="{{ route('admin.so-categories.restore', [$soCategory->id, 'restore']) }}" method="GET" style="display: inline-block;">
                                        @csrf
                                        <button type="submit" class="btn btn-xs btn-success">
                                            <i class="fa fa-sync-alt"></i> {{ trans('global.restore') }}
                                        </button>
                                    </form>
                                @else
                                    @can('so_category_delete')
                                        <form action="{{ route('admin.so-categories.destroy', $soCategory->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-xs btn-danger">
                                                <i class="fa fa-trash"></i> {{ trans('global.delete') }}
                                            </button>
                                        </form>
                                    @endcan
                                @endif
                                
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    <script>
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('so_category_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.so-categories.massDestroy') }}",
                    className: 'btn-danger',
                    action: function(e, dt, node, config) {
                        var ids = $.map(dt.rows({
                            selected: true
                        }).nodes(), function(entry) {
                            return $(entry).data('entry-id')
                        });

                        if (ids.length === 0) {
                            alert('{{ trans('global.datatables.zero_selected') }}')

                            return
                        }

                        if (confirm('{{ trans('global.areYouSure') }}')) {
                            $.ajax({
                                    headers: {
                                        'x-csrf-token': _token
                                    },
                                    method: 'POST',
                                    url: config.url,
                                    data: {
                                        ids: ids,
                                        _method: 'DELETE'
                                    }
                                })
                                .done(function() {
                                    location.reload()
                                })
                        }
                    }
                }
                dtButtons.push(deleteButton)
            @endcan

            $.extend(true, $.fn.dataTable.defaults, {
                orderCellsTop: true,
                order: [
                    [1, 'desc']
                ],
                pageLength: 25,
            });
            let table = $('.datatable-SoCategory:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        })
    </script>
@endsection