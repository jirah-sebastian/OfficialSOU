@extends('layouts.admin')
@section('content')
    @can('announcement_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-warning" href="{{ route('admin.announcements.create') }}">
                    <i class="fas fa-plus-circle"></i><b> {{ trans('global.add') }} {{ trans('cruds.announcement.title_singular') }} </b>
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header" style="background-color: #005600; color:white;">
            <strong>ANNOUNCEMENTS LIST</strong>
        </div>

        <div class="card-body">
            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Announcement">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th width="10">
                            #
                        </th>
                        <th>
                            {{ trans('cruds.announcement.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.announcement.fields.title') }}
                        </th>
                        <th>
                            {{ trans('cruds.announcement.fields.photo') }}
                        </th>
                        <th>
                            {{ trans('cruds.announcement.fields.is_published') }}
                        </th>
                        <th>
                            Status
                        </th>
                        {{-- <th>
                            {{ trans('cruds.announcement.fields.created_by') }}
                        </th>
                        {{-- <th>
                        &nbsp;
                    </th> --}}
                    </tr>
                    {{-- <tr>
                    <td>
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                        <select class="search">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach ($users as $key => $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                    </td>
                </tr> --}}
                </thead>
            </table>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script>
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('announcement_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.announcements.massDestroy') }}",
                    className: 'btn-danger',
                    action: function(e, dt, node, config) {
                        var ids = $.map(dt.rows({
                            selected: true
                        }).data(), function(entry) {
                            return entry.id
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

            let dtOverrideGlobals = {
                buttons: dtButtons,
                processing: true,
                serverSide: true,
                retrieve: true,
                aaSorting: [],
                ajax: "{{ route('admin.announcements.index') }}",
                columns: [{
                        data: 'placeholder',
                        name: 'placeholder'
                    },
                    {
                        data: 'number',
                        name: 'number',
                        searchable: false,
                        orderable: false,
                        render: function(data, type, row, meta) {
                            return '<div class="text-center">' + (meta.row + meta.settings._iDisplayStart + 1) + '</div>';
                        }
                    },
                    {
                        data: 'id',
                        name: 'id',
                        visible: false
                    },
                    {
                        data: 'title',
                        name: 'title',
                        render: function(data, type, row) {
                            return '<a href="/admin/announcements/' + row.id +
                                '" style="color: green;">' + row.title + '</a>';
                        }
                    },

                    {
                        data: 'photo',
                        name: 'photo',
                        sortable: false,
                        searchable: false
                    },
                    {
                        data: 'is_published',
                        name: 'is_published'
                    },
                    {
                        data: 'status',
                        name: 'status',

                        render: function(data, type, row) {
                            if (row.status === 'Archived') {
                                return '<span class="badge badge-dark">Archived</span>';
                            } else {
                                return '<span class="badge badge-success">' + (row.status ?? '') +
                                    '</span>';
                            }
                        }
                    },

                    /*{
                        data: 'created_by_name',
                        name: 'created_by.name'
                    }, */
                    // { data: 'actions', name: '{{ trans('global.actions') }}' }
                ],
                orderCellsTop: true,
                order: [
                    [1, 'desc']
                ],
                pageLength: 25,
            };
            let table = $('.datatable-Announcement').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

            let visibleColumnsIndexes = null;
            $('.datatable thead').on('input', '.search', function() {
                let strict = $(this).attr('strict') || false
                let value = strict && this.value ? "^" + this.value + "$" : this.value

                let index = $(this).parent().index()
                if (visibleColumnsIndexes !== null) {
                    index = visibleColumnsIndexes[index]
                }

                table
                    .column(index)
                    .search(value, strict)
                    .draw()
            });
            table.on('column-visibility.dt', function(e, settings, column, state) {
                visibleColumnsIndexes = []
                table.columns(":visible").every(function(colIdx) {
                    visibleColumnsIndexes.push(colIdx);
                });
            })
        });
    </script>
@endsection
