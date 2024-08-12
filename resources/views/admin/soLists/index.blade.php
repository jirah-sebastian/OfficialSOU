@extends('layouts.admin')
@section('content')
    @can('so_list_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                @if (auth()->user()->createdBySoLists()->count() == 0 && auth()->user()->is_press)
                    <a class="btn btn-warning" href="{{ route('admin.so-lists.create') }}">
                        <i class="fas fa-plus-circle"></i><b> {{ trans('global.add') }} {{ trans('cruds.soList.title_singular') }}</b>
                    </a>
                @endif

            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header" style="background-color: #005600; color:white;">
            <strong>STUDENT ORGANIZATIONS LIST</strong>
        </div>

        <div class="card-body">
            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-SoList">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.soList.fields.id') }}
                        </th>
                        <th width="10">
                            #
                        </th>
                        
                        <th>
                            {{ trans('cruds.soRegistration.fields.so_list') }}
                        </th>
                        {{-- <th>
                        {{ trans('cruds.soList.fields.organization_admin') }}
                    </th> --}}
                        <th>
                            {{ trans('cruds.soList.fields.so_category') }}
                        </th>
                        <th>
                            SO President
                        </th>
                        <th>
                            SO Adviser
                        </th>
                        <th>
                            Logo
                        </th>
                        <th>
                            {{ trans('cruds.soList.fields.overview') }}
                        </th>
                        {{-- <th>
                        {{ trans('cruds.soList.fields.expired_at') }}
                    </th> --}}

                        <th>
                            Status
                        </th>
                        <th>
                            {{ trans('cruds.soList.fields.remark') }}
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
                        <select class="search">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach ($users as $key => $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select class="search">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach ($so_categories as $key => $item)
                                <option value="{{ $item->category_name }}">{{ $item->category_name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
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
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
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
            @can('so_list_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.so-lists.massDestroy') }}",
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
                ajax: "{{ route('admin.so-lists.index') }}",
                columns: [{
                        data: 'placeholder',
                        name: 'placeholder'
                    }, //0
                    {
                        data: 'id',
                        name: 'id',
                        visible: false
                    }, //1

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
                        data: 'so_name',
                        name: 'so_name',
                        render: function(data, type, row) {
                            return '<a href="/admin/so-lists/' + row.id + '" style="color: green;">' +
                                row.so_name + '</a>';
                        }
                    },

                    // { data: 'organization_admin', name: 'organization_admins.name' },//3
                    {
                        data: 'so_category_category_name',
                        name: 'so_category.category_name'
                    }, //4
                    {
                        data: 'created_by_name',
                        name: 'created_by.name'
                    }, //8
                    {
                        data: 'adviser',
                        name: 'adviser'
                    }, //8
                    {
                        data: 'banner',
                        name: 'banner',
                        sortable: false,
                        searchable: false
                    }, //5
                    {
                        data: 'overview',
                        name: 'overview',
                        visible: false
                    }, //6
                    // { data: 'expired_at', name: 'expired_at' },//7

                    {
                        data: 'approved',
                        name: 'approved'
                    }, //9
                    {
                        data: 'remark',
                        name: 'remark',
                        visible: false
                    }, //10
                    // { data: 'actions', name: '{{ trans('global.actions') }}' }//11
                ],
                orderCellsTop: true,
                order: [
                    [1, 'desc']
                ],
                pageLength: 25,
            };
            let table = $('.datatable-SoList').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

            let visibleColumnsIndexes = [];
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
