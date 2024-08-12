
    <div class="card card-primary card-outline">
        <div class="card-header">
            <strong>{{ trans('cruds.soRegistration.title_singular') }} {{ trans('global.list') }}</strong>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-soListSoRegistrations">
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
                                    @if($soRegistration->status == 'Pending')
                                    {{-- @can('so_registration_show') --}}
                                        <form action="{{ route('admin.so.approval') }}" method="POST" style="display: inline-block;">
                                            <input type="hidden" name="status" value="Active">
                                            <input type="hidden" name="id" value="{{$soRegistration->id}}">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="submit" class="btn btn-xs btn-success" value="Approve">
                                        </form>

                                        <form action="{{ route('admin.so.approval') }}" method="POST" style="display: inline-block;">
                                            <input type="hidden" name="status" value="Rejected">
                                            <input type="hidden" name="remarks" class="remarks-input">
                                            <input type="hidden" name="id" value="{{$soRegistration->id}}">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <button class="btn btn-xs btn-danger" name="action" value="reject" type="submit" id="reject{{$soRegistration->id}}">Reject</button>
                                            {{-- <input type="submit" class="btn btn-xs btn-danger" value="Reject"> --}}
                                        </form>
                                    {{-- @endcan --}}
                                    @endif

                                    @can('so_registration_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.so-registrations.show', $soRegistration->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    {{-- @can('so_registration_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.so-registrations.edit', $soRegistration->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan --}}
                                        @if($soRegistration->status == 'Rejected')
                                        @can('so_registration_delete')

                                        <form action="{{ route('admin.so-registrations.destroy', $soRegistration->id) }}" method="POST" style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="submit" class="btn btn-xs btn-danger" value="Archive">
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

@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)


  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 25,
  });
  let table = $('.datatable-soListSoRegistrations:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>

@foreach($soRegistrations as $key => $soRegistration)
<script>
    $(document).ready(function () {
        $('#reject'+ {{$soRegistration->id}}).click(function (event) {
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
@endforeach

@endsection
