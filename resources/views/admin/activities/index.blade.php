@extends('layouts.admin')
@section('content')
    @can('activity_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-warning" href="{{ route('admin.activities.create') }}">
                    <i class="fas fa-plus-circle"></i><b> {{ trans('global.add') }} {{ trans('cruds.activity.title_singular') }}</b>
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header" style="background-color: #005600; color:white;">
            <strong>ACTIVITIES LIST</strong>
        </div>

        <div class="card-body">
            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Activity">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th width="10">
                            #
                        </th>
                        <th>
                            {{ trans('cruds.activity.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.activity.fields.title') }}
                        </th>
                        <th>
                            SO Cluster
                        </th>
                        <th>
                            {{ trans('cruds.activity.fields.organization') }}
                        </th>
                        <th>
                            {{ trans('cruds.activity.fields.sub_title') }}
                        </th>
                        <th>
                            {{ trans('cruds.activity.fields.event_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.activity.fields.event_place') }}
                        </th>
                        <th>
                            {{ trans('cruds.activity.fields.type_of_activity') }}
                        </th>
                        <th>
                            Funding Source
                        </th>
                        <th>
                            {{ trans('cruds.activity.fields.status') }}
                        </th>
                       
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
            @can('activity_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.activities.massDestroy') }}",
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
                ajax: "{{ route('admin.activities.index') }}",
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
                            return '<a href="/admin/activities/' + row.id + '" style="color: green;">' +
                                row.title + '</a>';
                        }
                    },

                    {
                        data: 'organization_so_category_name',
                        name: 'organization.so_category.category_name',
                        render: function(data, type, row, meta) {
                            return data ?? ''; // Display category name or an empty string if null
                        }
                    },

                    {
                        data: 'organization_so_name',
                        name: 'organization.so_name'
                    },
                    {
                        data: 'sub_title',
                        name: 'sub_title'
                    },
                    {
                        data: 'event_date',
                        name: 'event_date'
                    },
                    {
                        data: 'event_place',
                        name: 'event_place'
                    },
                    {
                        data: 'type_of_activity',
                        name: 'type_of_activity'
                    },
                    // {
                    //     data: 'sustainable_development_goal',
                    //     name: 'sustainable_development_goal'
                    // },
                    {
                        data: 'gad_funded',
                        name: 'gad_funded',
                        searchable: true
                    },

                    {
                        data: 'status',
                        name: 'status'
                    },
                    // {
                    //     data: 'is_published',
                    //     name: 'is_published'
                    // },
                    /*
                    { data: 'content_photo', name: 'content_photo', sortable: false, searchable: false },
                    { data: 'permit', name: 'permit', sortable: false, searchable: false },
                    { data: 'created_by_name', name: 'created_by.name' },
                    { data: 'remarks', name: 'remarks' },
                    { data: 'actions', name: '{{ trans('global.actions') }}' } */
                ],
                orderCellsTop: true,
                order: [
                    [1, 'desc']
                ],
                pageLength: 25,
            };
            let table = $('.datatable-Activity').DataTable(dtOverrideGlobals);
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
                visibleColumnsIndexes = [1]
                table.columns(":visible").every(function(colIdx) {
                    visibleColumnsIndexes.push(colIdx);
                });
            })
        });

        $('.datatable-Activity tbody').on('click', 'td', function() {
            var columnIdx = table.cell(this).index().column;
            var permitColumnName = 'permit'; // Name of the permit column

            console.log('Clicked on column index:', columnIdx);

            if (table.column(columnIdx).header().textContent.trim() === permitColumnName) {
                var permitData = table.cell(this).data();
                console.log('Permit data:', permitData);
                window.open(permitData, '_blank'); // Open the permit data in a new tab
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#reject').click(function(event) {
                var buttonClicked = $(this);
                var form = buttonClicked.closest('form');
                var itemId = buttonClicked.data('item-id');

                // Prompt the user for remarks
                var remarks = prompt('Please enter remarks for rejection:');

                if (remarks === null) {
                    // If the user cancels entering remarks
                    alert('Reject canceled');
                    event.preventDefault(); // Prevent form submission
                } else if (!confirm('Are you sure you want to reject this item?')) {
                    // If the user cancels the deletion
                    event.preventDefault(); // Prevent form submission
                } else {
                    // Add the remarks value to a hidden input field in the form
                    form.find('.remarks-input').val(remarks);
                    // Continue with the form submission
                }
            });
        });
    </script>
@endsection
