<div class="m-3">
    @can('organization_application_form_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.organization-application-forms.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.organizationApplicationForm.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.organizationApplicationForm.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-organizationOrganizationApplicationForms">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                {{ trans('cruds.organizationApplicationForm.fields.id') }}
                            </th>
                            <th>
                                {{ trans('cruds.organizationApplicationForm.fields.filename') }}
                            </th>
                            <th>
                                {{ trans('cruds.organizationApplicationForm.fields.application_form') }}
                            </th>
                            <th>
                                {{ trans('cruds.organizationApplicationForm.fields.organization') }}
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($organizationApplicationForms as $key => $organizationApplicationForm)
                            <tr data-entry-id="{{ $organizationApplicationForm->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $organizationApplicationForm->id ?? '' }}
                                </td>
                                <td>
                                    {{ $organizationApplicationForm->filename ?? '' }}
                                </td>
                                <td>
                                    @if($organizationApplicationForm->application_form)
                                        <a href="{{ $organizationApplicationForm->application_form->getUrl() }}" target="_blank">
                                            {{ trans('global.view_file') }}
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    {{ $organizationApplicationForm->organization->so_name ?? '' }}
                                </td>
                                <td>
                                    @can('organization_application_form_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.organization-application-forms.show', $organizationApplicationForm->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    @can('organization_application_form_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.organization-application-forms.edit', $organizationApplicationForm->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('organization_application_form_delete')
                                        <form action="{{ route('admin.organization-application-forms.destroy', $organizationApplicationForm->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('organization_application_form_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.organization-application-forms.massDestroy') }}",
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
    pageLength: 100,
  });
  let table = $('.datatable-organizationOrganizationApplicationForms:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection