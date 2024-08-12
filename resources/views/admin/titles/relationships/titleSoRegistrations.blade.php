<div class="m-3">
    @can('so_registration_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.so-registrations.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.soRegistration.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.soRegistration.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-titleSoRegistrations">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                {{ trans('cruds.soRegistration.fields.id') }}
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
                                {{ trans('cruds.soRegistration.fields.status') }}
                            </th>
                            <th>
                                {{ trans('cruds.soRegistration.fields.membership_type') }}
                            </th>
                            <th>
                                {{ trans('cruds.soRegistration.fields.title') }}
                            </th>
                            <th>
                                {{ trans('cruds.soRegistration.fields.profile_form') }}
                            </th>
                            <th>
                                {{ trans('cruds.soRegistration.fields.parent_consent_form') }}
                            </th>
                            <th>
                                {{ trans('cruds.soRegistration.fields.data_privacy_form') }}
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($soRegistrations as $key => $soRegistration)
                            <tr data-entry-id="{{ $soRegistration->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $soRegistration->id ?? '' }}
                                </td>
                                <td>
                                    @if($soRegistration->profile_picture)
                                        <a href="{{ $soRegistration->profile_picture->getUrl() }}" target="_blank" style="display: inline-block">
                                            <img src="{{ $soRegistration->profile_picture->getUrl('thumb') }}">
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    {{ $soRegistration->full_name ?? '' }}
                                </td>
                                <td>
                                    {{ $soRegistration->email ?? '' }}
                                </td>
                                <td>
                                    {{ $soRegistration->so_list->so_name ?? '' }}
                                </td>
                                <td>
                                    {{ App\Models\SoRegistration::STATUS_SELECT[$soRegistration->status] ?? '' }}
                                </td>
                                <td>
                                    {{ App\Models\SoRegistration::MEMBERSHIP_TYPE_SELECT[$soRegistration->membership_type] ?? '' }}
                                </td>
                                <td>
                                    {{ $soRegistration->title->name ?? '' }}
                                </td>
                                <td>
                                    @if($soRegistration->profile_form)
                                        <a href="{{ $soRegistration->profile_form->getUrl() }}" target="_blank">
                                            {{ trans('global.view_file') }}
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    @if($soRegistration->parent_consent_form)
                                        <a href="{{ $soRegistration->parent_consent_form->getUrl() }}" target="_blank">
                                            {{ trans('global.view_file') }}
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    @if($soRegistration->data_privacy_form)
                                        <a href="{{ $soRegistration->data_privacy_form->getUrl() }}" target="_blank">
                                            {{ trans('global.view_file') }}
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    @can('so_registration_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.so-registrations.show', $soRegistration->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    @can('so_registration_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.so-registrations.edit', $soRegistration->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('so_registration_delete')
                                        <form action="{{ route('admin.so-registrations.destroy', $soRegistration->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('so_registration_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.so-registrations.massDestroy') }}",
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
  let table = $('.datatable-titleSoRegistrations:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection