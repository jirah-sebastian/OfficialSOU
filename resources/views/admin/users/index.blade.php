@extends('layouts.admin')
@section('content')
    @can('user_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-warning" href="{{ route('admin.users.create') }}">
                    <i class="fas fa-plus-circle"></i><b> {{ trans('global.add') }} {{ trans('cruds.user.title_singular') }}</b>
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header" style="background-color: #005600; color:white;">
            <strong>USERS LIST</strong>
        </div>

        <div class="card-body">
            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-User">
                <thead>
                    <tr>
                        <th width="10">
                            
                        </th>
                        <th width="10">
                            #
                        </th>
                        {{-- <th>
                        {{ trans('cruds.user.fields.id') }}
                    </th> --}}
                        <th>
                            {{ trans('cruds.user.fields.name') }}
                        </th>

                        <th>
                            {{ trans('cruds.user.fields.profile') }}
                        </th>
                        <th>
                            {{ trans('cruds.user.fields.email') }}
                        </th>
                        <th>
                            SO Name
                        </th>
                        <th>
                            {{ trans('cruds.user.fields.approved') }}
                        </th>
                        <th>
                            {{ trans('cruds.user.fields.email_verified_at') }}
                        </th>
                        <th>
                            {{ trans('cruds.user.fields.roles') }}
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
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <select class="search">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach ($roles as $key => $item)
                                <option value="{{ $item->title }}">{{ $item->title }}</option>
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
            @can('user_delete')
                let deleteButtonTrans = 'Archive';
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.users.massDestroy') }}",
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
                ajax: "{{ route('admin.users.index') }}",
                columns: [{
                        data: 'placeholder',
                        name: 'placeholder'
                    },
                    // { data: 'id', name: 'id', visible: false },
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
                        data: 'name',
                        name: 'name',
                        render: function(data, type, row) {
                            return '<a href="/admin/users/' + row.id + '" style="color: green;">' + row
                                .name + '</a>';
                        }
                    },

                    {
                        data: 'profile',
                        name: 'profile',
                        sortable: false,
                        searchable: false
                    },

                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'so_name',
                        name: 'so_name'
                    },
                    {
                        data: 'approved',
                        name: 'approved'
                    },
                    {
                        data: 'email_verified_at',
                        name: 'email_verified_at',
                        visible: false
                    },
                    {
                        data: 'roles',
                        name: 'roles.title'
                    },
                    // { data: 'actions', name: '{{ trans('global.actions') }}', visible: false }
                ],
                orderCellsTop: true,
                order: [
                    [1, 'asc']
                ],
                pageLength: 25,
            };
            let table = $('.datatable-User').DataTable(dtOverrideGlobals);
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
