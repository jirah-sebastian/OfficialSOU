@extends('layouts.admin')
@section('content')
    @can('resource_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-warning" href="{{ route('admin.resources.create') }}">
                    <i class="fas fa-plus-circle"></i><b> {{ trans('global.add') }} {{ trans('cruds.resource.title_singular') }} </b>
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header" style="background-color: #005600; color:white;">
            <strong>RESOURCES LIST</strong>
        </div>

        <div class="card-body">
            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Resource">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th width="10">
                            #
                        </th>
                        <th>
                            {{ trans('cruds.resource.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.resource.fields.title') }}
                        </th>
                        <th>
                            {{ trans('cruds.resource.fields.file') }}
                        </th>

                        <th>
                            Status
                        </th>

                    </tr>

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
            @can('resource_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.resources.massDestroy') }}",
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
                ajax: "{{ route('admin.resources.index') }}",
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
                            return '<a href="/admin/resources/' + row.id + '" style="color: green;">' +
                                row.title + '</a>';
                        }
                    },

                    {
                        data: 'file',
                        name: 'file',
                        sortable: false,
                        searchable: false
                    },
                    // { data: 'is_published', name: 'is_published' },
                    {
                        data: 'status',
                        name: 'status',
                        searchable: false,
                        render: function(data, type, row) {
                            if (row.status == 'Available') {
                                return '<span class="badge badge-success">Available</span>';
                            } else {
                                return '<span class="badge badge-dark">' + (row.status ?? '') +
                                    '</span>';
                            }
                        }
                    }

                    //  { data: 'created_by_name', name: 'created_by.name' },
                    // { data: 'actions', name: '{{ trans('global.actions') }}' }
                ],
                orderCellsTop: true,
                order: [
                    [1, 'desc']
                ],
                pageLength: 25,
            };
            let table = $('.datatable-Resource').DataTable(dtOverrideGlobals);
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
