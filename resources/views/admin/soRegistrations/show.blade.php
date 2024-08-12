@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header" style="background-color: #005600; color:white;">
            <strong>SHOW SO MEMBER</strong>
        </div>

        <div class="card-body">
            <style>
                /* Custom CSS for decreasing the width of the first column */
                .table th:first-child,
                .table td:first-child {
                    width: 220px;
                    /* Adjust the width as needed */
                }
            </style>
            <div class="form-group">
                <div class="form-group">
                    {{-- <a class="btn btn-default" href="{{ URL::previous() }}"> --}}
                    <a class="btn btn-default" href="{{ route('admin.so-registrations.index', ['so_list' => $soList->id]) }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                @if (!auth()->user()->is_pres)
                    <div class="form-group">
                        <div style="display: inline-block;">
                            @if (!$soRegistration->deleted_at)
                                <a href="{{ route('admin.so-registrations.edit', $soRegistration->id) }}"
                                    class="btn btn-warning">
                                    <i class="fa fa-edit"></i><b> Edit</b>
                                </a>
                            @endif
                        </div>
                @endif
                <div style="display: inline-block;">
                    @if ($soRegistration->deleted_at)
                        <a href="{{ route('admin.so-registrations.restore', [$soRegistration->id, 'restore']) }}"
                            class="btn btn-success">
                            <i class="fa fa-sync-alt"></i>&nbsp;<b>Restore</b>
                        </a>
                    @else
                        <a href="{{ route('admin.so-registrations.restore', [$soRegistration->id, 'delete']) }}"
                            class="btn btn-danger">
                            <i class="fa fa-trash"></i>&nbsp;<b>Archive</b>
                        </a>
                    @endif
                </div>


                <div style="display: inline-block;">
                    <form action="{{ route('admin.so-registration.presapproval', [$soRegistration->id, 'reject']) }}"
                        method="GET">
                        @if ($soRegistration->president_approval == 'Pending' && auth()->user()->is_pres)
                            <a href="{{ route('admin.so-registration.presapproval', [$soRegistration->id, 'approve']) }}"
                                class="btn btn-success">
                                <i class="fa fa-check"></i>&nbsp;<b>Approve</b>
                            </a>
                            <input type="hidden" name="remarks1" class="remarks1-input">
                            <button id="reject1" class="btn btn-danger">
                                <i class="fa fa-times"></i>&nbsp;<b>Reject</b>
                            </button>
                        @endif
                    </form>
                </div>

                <div style="display: inline-block;">
                    <form action="{{ route('admin.so-registration.adminapproval', [$soRegistration->id, 'reject']) }}"
                        method="GET">
                        @if (
                            $soRegistration->president_approval == 'Approved' &&
                                $soRegistration->admin_approval == 'Pending' &&
                                !auth()->user()->is_pres)
                            <a href="{{ route('admin.so-registration.adminapproval', [$soRegistration->id, 'approve']) }}"
                                class="btn btn-success">
                                <i class="fa fa-check"></i>&nbsp;<b>Approve</b>
                            </a>
                            <input type="hidden" name="remarks2" class="remarks2-input">
                            <button id="reject2" class="btn btn-danger">
                                <i class="fa fa-times"></i>&nbsp;<b>Reject</b>
                            </button>
                        @endif
                    </form>
                </div>
            </div>

            <table class="table table-bordered table-striped">
                <tbody>

                    <tr>
                        <th>
                            {{ trans('cruds.soRegistration.fields.profile_picture') }}
                        </th>
                        <td>
                            @if ($soRegistration->profile_picture)
                                <a href="{{ $soRegistration->profile_picture->getUrl() }}" target="_blank"
                                    style="display: inline-block">
                                    <img src="{{ $soRegistration->profile_picture->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.soRegistration.fields.full_name') }}
                        </th>
                        <td>
                            {{ $soRegistration->full_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.soRegistration.fields.email') }}
                        </th>
                        <td>
                            {{ $soRegistration->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.soRegistration.fields.so_list') }}
                        </th>
                        <td>
                            {{ $soRegistration->so_list->so_name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.soRegistration.fields.course') }}
                        </th>
                        <td>
                            {{ $soRegistration->course }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.soRegistration.fields.year') }}
                        </th>
                        <td>
                            {{ App\Models\SoRegistration::YEAR_SELECT[$soRegistration->year] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.soRegistration.fields.gender') }}
                        </th>
                        <td>
                            {{ App\Models\SoRegistration::GENDER_SELECT[$soRegistration->gender] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.soRegistration.fields.religion') }}
                        </th>
                        <td>
                            {{ $soRegistration->religion }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.soRegistration.fields.nationality') }}
                        </th>
                        <td>
                            {{ $soRegistration->nationality }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.soRegistration.fields.birthdate') }}
                        </th>
                        <td>
                            {{ $soRegistration->birthdate }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Age
                        </th>
                        <td>
                            {{ Carbon\Carbon::parse($soRegistration->birthdate)->age }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.soRegistration.fields.birthplace') }}
                        </th>
                        <td>
                            {{ $soRegistration->birthplace }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.soRegistration.fields.present_address') }}
                        </th>
                        <td>
                            {{ $soRegistration->present_address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.soRegistration.fields.home_address') }}
                        </th>
                        <td>
                            {{ $soRegistration->home_address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.soRegistration.fields.contact_no') }}
                        </th>
                        <td>
                            {{ $soRegistration->contact_no }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.soRegistration.fields.father_name') }}
                        </th>
                        <td>
                            {{ $soRegistration->father_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.soRegistration.fields.father_contact_no') }}
                        </th>
                        <td>
                            {{ $soRegistration->father_contact_no }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.soRegistration.fields.mother_name') }}
                        </th>
                        <td>
                            {{ $soRegistration->mother_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.soRegistration.fields.mother_contact_no') }}
                        </th>
                        <td>
                            {{ $soRegistration->mother_contact_no }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.soRegistration.fields.source_of_financial_support') }}
                        </th>
                        <td>
                            {{ $soRegistration->source_of_financial_support }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.soRegistration.fields.talent_skills') }}
                        </th>
                        <td>
                            {{ $soRegistration->talent_skills }}
                        </td>
                    </tr>


                    {{-- <tr>
                        <th>
                            {{ trans('cruds.soRegistration.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\SoRegistration::STATUS_SELECT[$soRegistration->status] ?? '' }}
                        </td>
                    </tr> --}}
                    <tr>
                        <th>
                            {{ trans('cruds.soRegistration.fields.membership_type') }}
                        </th>
                        <td>
                            {{ App\Models\SoRegistration::MEMBERSHIP_TYPE_SELECT[$soRegistration->membership_type] ?? '' }}
                        </td>
                    </tr>
                    @if ($soRegistration->position)
                        <tr>
                            <th>
                                {{ trans('cruds.soRegistration.fields.position') }}
                            </th>
                            <td>
                                {{ $soRegistration->position }}
                            </td>
                        </tr>
                    @endif
                    {{-- <tr>
                        <th>
                            {{ trans('cruds.soRegistration.fields.title') }}
                        </th>
                        <td>
                            {{ $soRegistration->title->name ?? '' }}
                        </td>
                    </tr> --}}
                    <tr>
                        <th>
                            {{ trans('cruds.soRegistration.fields.profile_form') }}
                        </th>
                        <td>
                            @if ($soRegistration->profile_form)
                                <a href="{{ $soRegistration->profile_form->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.soRegistration.fields.parent_consent_form') }}
                        </th>
                        <td>
                            @if ($soRegistration->parent_consent_form)
                                <a href="{{ $soRegistration->parent_consent_form->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.soRegistration.fields.data_privacy_form') }}
                        </th>
                        <td>
                            @if ($soRegistration->data_privacy_form)
                                <a href="{{ $soRegistration->data_privacy_form->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Medical Certificate
                        </th>
                        <td>
                            @if ($soRegistration->med_cert)
                                <a href="{{ $soRegistration->med_cert->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.soRegistration.fields.date_filed') }}
                        </th>
                        <td>
                            {{ $soRegistration->date_filed }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.soRegistration.fields.president_approval') }}
                        </th>
                        <td>
                            {{ App\Models\SoRegistration::PRESIDENT_APPROVAL_SELECT[$soRegistration->president_approval] ?? '' }}
                        </td>
                    </tr>
                    @if ($soRegistration->remark)
                        <tr>
                            <th>
                                President Remark
                            </th>
                            <td>
                                <span style="color: red;">{{ $soRegistration->remark }}</span>
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <th>
                            {{ trans('cruds.soRegistration.fields.admin_approval') }}
                        </th>
                        <td>
                            {{ App\Models\SoRegistration::ADMIN_APPROVAL_SELECT[$soRegistration->admin_approval] ?? '' }}
                        </td>
                    </tr>
                    @if ($soRegistration->admin_remark)
                        <tr>
                            <th>
                                {{ trans('cruds.soRegistration.fields.admin_remark') }}
                            </th>
                            <td>
                                <span style="color: red;">{{ $soRegistration->admin_remark }}</span>
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <th>
                            Approval Date
                        </th>
                        <td>
                            {{ $soRegistration->date_approval }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Approval by
                        </th>
                        <td>
                            {{ $soRegistration->approved_by->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            {{-- <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.so-lists.edit',$soRegistration->so_list_id) }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div> --}}
        </div>
    </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('#reject1').click(function(event) {
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
                    form.find('.remarks1-input').val(remarks);
                    // Continue with the form submission
                }
            });

            $('#reject2').click(function(event) {
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
                    form.find('.remarks2-input').val(remarks);
                    // Continue with the form submission
                }
            })

            $('.save-btn').click(function() {
                // Proceed with the form submission for the "Save" button
            });
        });
    </script>
@endsection
