<div class="m-3">
    @can('so_list_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.so-lists.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.soList.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.soList.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-createdBySoLists">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                {{ trans('cruds.soList.fields.id') }}
                            </th>
                            <th>
                                {{ trans('cruds.soList.fields.so_name') }}
                            </th>
                            <th>
                                {{ trans('cruds.soList.fields.organization_admin') }}
                            </th>
                            <th>
                                {{ trans('cruds.soList.fields.so_category') }}
                            </th>
                            <th>
                                {{ trans('cruds.soList.fields.banner') }}
                            </th>
                            <th>
                                {{ trans('cruds.soList.fields.overview') }}
                            </th>
                            <th>
                                {{ trans('cruds.soList.fields.expired_at') }}
                            </th>
                            <th>
                                {{ trans('cruds.soList.fields.created_by') }}
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($soLists as $key => $soList)
                            <tr data-entry-id="{{ $soList->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $soList->id ?? '' }}
                                </td>
                                <td>
                                    {{ $soList->so_name ?? '' }}
                                </td>
                                <td>
                                    @foreach($soList->organization_admins as $key => $item)
                                        <span class="badge badge-info">{{ $item->name }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    {{ $soList->so_category->category_name ?? '' }}
                                </td>
                                <td>
                                    @if($soList->banner)
                                        <a href="{{ $soList->banner->getUrl() }}" target="_blank" style="display: inline-block">
                                            <img src="{{ $soList->banner->getUrl('thumb') }}">
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    {{ $soList->overview ?? '' }}
                                </td>
                                <td>
                                    {{ $soList->expired_at ?? '' }}
                                </td>
                                <td>
                                    {{ $soList->created_by->name ?? '' }}
                                </td>
                                <td>
                                    @can('so_list_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.so-lists.show', $soList->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

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
            </div>
        </div>
    </div>
</div>
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('so_list_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.so-lists.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 25,
  });
  let table = $('.datatable-createdBySoLists:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection