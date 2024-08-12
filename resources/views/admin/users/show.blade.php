@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header" style="background-color: #005600; color:white;">
            <strong>SHOW USER</strong>
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.users.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <div class="form-group">
                    <form action="{{ route('admin.user.approve', [$user->id, 'reject']) }}" method="GET">
                        @if (!$user->deleted_at)
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning"><i
                                    class="fa fa-edit"></i><b>Edit</b></a>
                        @endif
                        @if (!auth()->user()->is_pres)
                            @if ($user->deleted_at)
                                <a href="{{ route('admin.user.restore', [$user->id, 'restore']) }}"
                                    class="btn btn-success"><i class="fa fa-sync-alt"></i>&nbsp;<b>Restore</b></a>
                            @else
                                <a href="{{ route('admin.user.restore', [$user->id, 'delete']) }}" class="btn btn-danger"><i
                                        class="fa fa-trash"></i>&nbsp;<b>Archive</b></a>
                            @endif

                            @if (!$user->deleted_at && $user->approved == 'Pending')
                                <a href="{{ route('admin.user.approve', [$user->id, 'approve']) }}"
                                    class="btn btn-success"><i class="fa fa-check"></i>&nbsp;<b>Approve</b></a>


                                <input type="hidden" name="remarks" class="remarks-input">
                                <button id="reject" class="btn btn-danger"><i
                                        class="fa fa-times"></i>&nbsp;<b>Reject</b></button>
                            @endif
                        @endif

                    </form>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th class="custom-th-width">
                                {{ trans('cruds.user.fields.profile') }}
                            </th>
                            <td>
                                @if ($user->profile)
                                    <a href="{{ $user->profile->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $user->profile->getUrl('thumb') }}">
                                    </a>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.user.fields.name') }}
                            </th>
                            <td>
                                {{ $user->name }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.user.fields.email') }}
                            </th>
                            <td>
                                {{ $user->email }}
                            </td>
                        </tr>
                        @if ($user->roles->contains(3))
                            <tr>
                                <th>
                                    SO Name
                                </th>
                                <td>
                                    {{ $user->so_name }}
                                </td>
                            </tr>
                        @endif
                        <tr>
                            <th>
                                {{ trans('cruds.user.fields.roles') }}
                            </th>
                            <td>
                                @foreach ($user->roles as $key => $roles)
                                    <span class="label">{{ $roles->title }}</span>
                                @endforeach
                            </td>
                        </tr>
                        @if ($user->roles->contains(3))
                            <tr>
                                <th>
                                    Status
                                </th>
                                <td>
                                    {{ $user->approved ?? '' }}
                                </td>
                            </tr>


                            <tr>
                                <th>
                                    {{ trans('cruds.user.fields.gender') }}
                                </th>
                                <td>
                                    {{ App\Models\User::GENDER_SELECT[$user->gender] ?? '' }}
                                </td>
                            </tr>

                            <tr>
                                <th>
                                    {{ trans('cruds.user.fields.course') }}
                                </th>
                                <td>
                                    {{ $user->course }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.user.fields.year') }}
                                </th>
                                <td>
                                    {{ App\Models\User::YEAR_SELECT[$user->year] ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.user.fields.religion') }}
                                </th>
                                <td>
                                    {{ $user->religion }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.user.fields.nationality') }}
                                </th>
                                <td>
                                    {{ $user->nationality }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.user.fields.birthdate') }}
                                </th>
                                <td>
                                    {{ $user->birthdate }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.user.fields.birthplace') }}
                                </th>
                                <td>
                                    {{ $user->birthplace }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.user.fields.present_address') }}
                                </th>
                                <td>
                                    {{ $user->present_address }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.user.fields.home_address') }}
                                </th>
                                <td>
                                    {{ $user->home_address }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.user.fields.contact_no') }}
                                </th>
                                <td>
                                    {{ $user->contact_no }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.user.fields.father_name') }}
                                </th>
                                <td>
                                    {{ $user->father_name }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.user.fields.father_contact_no') }}
                                </th>
                                <td>
                                    {{ $user->father_contact_no }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.user.fields.mother_name') }}
                                </th>
                                <td>
                                    {{ $user->mother_name }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.user.fields.mothers_contact_no') }}
                                </th>
                                <td>
                                    {{ $user->mothers_contact_no }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.user.fields.source_of_financial_support') }}
                                </th>
                                <td>
                                    {{ $user->source_of_financial_support }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.user.fields.talent_skills') }}
                                </th>
                                <td>
                                    {{ $user->talent_skills }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.user.fields.date_filed') }}
                                </th>
                                <td>
                                    {{ $user->date_filed }}
                                </td>
                            </tr>
                            {{-- <tr>
                                <th>
                                    Approval Date
                                </th>
                                <td>
                                    {{ $user->approval_update_at }}
                                </td>
                            </tr> --}}
                            @if ($user->approval_update_at)
                                <tr>
                                    <th>
                                        Approval Date
                                    </th>
                                    <td>
                                        {{ $user->approval_update_at ?? '' }}
                                    </td>
                                </tr>
                            @endif

                            @if ($user->updated_at)
                                <tr>
                                    <th>
                                        Updated At
                                    </th>
                                    <td>
                                        {{ $user->updated_at ?? '' }}
                                    </td>
                                </tr>
                            @endif

                            {{-- <tr>
                            <th>
                                {{ trans('cruds.user.fields.approval_by') }}
                            </th>
                            <td>
                                {{ $user->approval_by->name ?? '' }}
                            </td>
                        </tr> --}}
                            @if ($user->remark)
                                <tr>
                                    <th>
                                        Remarks
                                    </th>
                                    <td>
                                        <span style="color: red;">{{ $user->remark }}</span>
                                    </td>
                                </tr>
                            @endif
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
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

            $('.save-btn').click(function() {
                // Proceed with the form submission for the "Save" button
            });
        });
    </script>


    <style>
        .custom-th-width {
            width: 200px;
        }
    </style>
@endsection
