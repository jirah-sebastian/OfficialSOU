@extends('layouts.admin')
@section('content')
    @can('so_registration_create')
        {{-- <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.so-registrations.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.soRegistration.title_singular') }}
            </a>
        </div>
    </div> --}}
    @endcan
    <div class="card">
        <div class="card-header" style="font-weight: bold; background-color: #005600; color:white;">
            SO MEMBERS LIST
        </div>

        <div class="card-body">
            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-SoRegistration">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th width="10">
                            #
                        </th>
                        <th>
                            {{ trans('cruds.soList.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.soRegistration.fields.profile_picture') }}
                        </th>
                        <th>
                            {{ trans('cruds.soRegistration.fields.full_name') }}
                        </th>
                        <th>
                            {{ trans('cruds.soRegistration.fields.email') }}
                        </th>
                        <th>
                            {{ trans('cruds.soRegistration.fields.so_list') }}
                        </th>
                        <th>
                            {{ trans('cruds.soRegistration.fields.membership_type') }}
                        </th>
                        <th>
                            {{ trans('cruds.soRegistration.fields.position') }}
                        </th>
                        <th>
                            {{ trans('cruds.soRegistration.fields.president_approval') }}
                        </th>
                        <th>
                            {{ trans('cruds.soRegistration.fields.admin_approval') }}
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
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons);

            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            const soListId = urlParams.get('so_list');

            let dtOverrideGlobals = {
                buttons: dtButtons,
                processing: true,
                serverSide: true,
                retrieve: true,
                aaSorting: [],
                ajax: "/admin/so-registrations?so_list=" + soListId,
                columns: [{
                        data: null,
                        defaultContent: '',
                        orderable: false
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
                        data: 'profile_picture',
                        name: 'profile_picture',
                        sortable: false,
                        searchable: false
                    },
                    {
                        data: 'full_name',
                        name: 'full_name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'so_list_so_name',
                        name: 'so_list.so_name'
                    },
                    {
                        data: 'membership_type',
                        name: 'membership_type'
                    },
                    {
                        data: 'position',
                        name: 'position'
                    },
                    {
                        data: 'president_approval',
                        name: 'president_approval'
                    },
                    {
                        data: 'admin_approval',
                        name: 'admin_approval'
                    },
                ],
                orderCellsTop: true,
                order: [1, 'desc'],
                pageLength: 25,
            };

            let table = $('.datatable-SoRegistration').DataTable(dtOverrideGlobals);

            @can('so_registration_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.so-registrations.massDestroy') }}",
                    className: 'btn-danger',
                    action: function(e, dt, node, config) {
                        var ids = $.map(dt.rows({
                            selected: true
                        }).data(), function(entry) {
                            return entry.id;
                        });

                        if (ids.length === 0) {
                            alert('{{ trans('global.datatables.zero_selected') }}');
                            return;
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
                                    location.reload();
                                });
                        }
                    }
                };
                dtButtons.push(deleteButton);
            @endcan

            // Add event listener for search input
            $('.datatable thead input').on('input', function() {
                let searchValue = this.value.trim();

                // Search through all visible columns
                table.columns().every(function() {
                    if (this.visible()) {
                        this.search(searchValue, true, false).draw();
                    }
                });
            });

            // Handle tab shown event to adjust column widths
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function() {
                $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
            });
        });
    </script>
@endsection
