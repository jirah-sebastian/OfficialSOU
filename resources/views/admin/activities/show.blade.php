@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header" style="background-color: #005600; color:white;">
            <strong>VIEW ACTIVITY</strong>
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.activities.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <div class="form-group">

                    @if (!auth()->user()->is_pres)
                        <form action="{{ route('admin.activity.approve', [$activity->id, 'reject']) }}" method="GET">
                            @if (!$activity->deleted_at)
                                <a href="{{ route('admin.activities.edit', $activity->id) }}" class="btn btn-warning"><i
                                        class="fa fa-edit"></i><b>Edit</b></a>
                            @endif
                            @if ($activity->deleted_at)
                                <a href="{{ route('admin.activity.restore', [$activity->id, 'restore']) }}"
                                    class="btn btn-success"><i class="fa fa-sync-alt"></i>&nbsp;<b>Restore</b></a>
                            @else
                                <a href="{{ route('admin.activity.restore', [$activity->id, 'delete']) }}"
                                    class="btn btn-danger"><i class="fa fa-trash"></i>&nbsp;<b>Archive</b></a>
                            @endif

                            @if (!$activity->deleted_at && $activity->status == 'Pending')
                                <a href="{{ route('admin.activity.approve', [$activity->id, 'approve']) }}"
                                    class="btn btn-success"><i class="fa fa-check"></i>&nbsp;<b>Approve</b></a>


                                <input type="hidden" name="remarks" class="remarks-input">
                                <button id="reject" class="btn btn-danger"><i
                                        class="fa fa-times"></i>&nbsp;<b>Reject</b></button>
                            @endif
                    @endif


                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th>
                                {{ trans('cruds.activity.fields.organization') }}
                            </th>
                            <td>
                                {{ $activity->organization->so_name ?? '' }}
                            </td>
                        </tr>

                        <tr>
                            <th>
                                Cluster
                            </th>
                            <td>
                                {{ $activity->organization->so_category->category_name ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th class="custom-th-width">
                                {{ trans('cruds.activity.fields.title') }}
                            </th>
                            <td>
                                {{ $activity->title }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Control No.
                            </th>
                            <td>
                                {{ $activity->sub_title }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.activity.fields.event_date') }}
                            </th>
                            <td>
                                {{ $activity->event_date }}
                            </td>
                        </tr>

                        <tr>
                            <th>
                                {{ trans('cruds.activity.fields.event_place') }}
                            </th>
                            <td>
                                {{ $activity->event_place }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.activity.fields.type_of_activity') }}
                            </th>
                            <td>
                                {{ App\Models\Activity::TYPE_OF_ACTIVITY_SELECT[$activity->type_of_activity] ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.activity.fields.sustainable_development_goal') }}
                            </th>
                            <td>
                                @if ($activity->sustainable_development_goal)
                                    {{ implode(', ', $activity->sustainable_development_goal) }}
                                @else
                                    Nothing Selected
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Funding Source
                            </th>
                            <td>
                                {{ $activity->gad_funded }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.activity.fields.permit') }}
                            </th>
                            <td>
                                @if ($activity->permit)
                                    <a href="{{ $activity->permit->getUrl() }}" target="_blank">
                                        {{ trans('global.view_file') }}
                                    </a>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.activity.fields.content_photo') }}
                            </th>
                            <td>
                                @if ($activity->content_photo)
                                    <a href="{{ $activity->content_photo->getUrl() }}" target="_blank"
                                        style="display: inline-block">
                                        <img src="{{ $activity->content_photo->getUrl('thumb') }}">
                                    </a>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.activity.fields.content') }}
                            </th>
                            <td>
                                {!! $activity->content !!}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.activity.fields.created_by') }}
                            </th>
                            <td>
                                {{ $activity->created_by->name ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Date Created
                            </th>
                            <td>
                                {{ $activity->created_at ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.activity.fields.status') }}
                            </th>
                            <td>
                                {{ App\Models\Activity::STATUS_SELECT[$activity->status] ?? '' }}
                            </td>
                        </tr>
                        @if ($activity->remarks)
                            <tr>
                                <th>
                                    {{ trans('cruds.activity.fields.remarks') }}
                                </th>
                                <td>
                                    <span style="color: red;">{{ $activity->remarks }}</span>
                                </td>
                            </tr>
                        @endif

                        <tr>
                            <th>
                                {{ trans('cruds.activity.fields.is_published') }}
                            </th>
                            <td>
                                {{-- <input type="checkbox" disabled="disabled" {{ $activity->is_published ? 'checked' : '' }}> --}}
                                {{ $activity->is_published }}
                            </td>
                        </tr>

                        @if ($activity->approval_date)
                            <tr>
                                <th>
                                    Approval Date
                                </th>
                                <td>
                                    {{ $activity->approval_date ?? '' }}
                                </td>
                            </tr>
                        @endif

                        @if ($activity->updated_at)
                            <tr>
                                <th>
                                    Updated At
                                </th>
                                <td>
                                    {{ $activity->updated_at ?? '' }}
                                </td>
                            </tr>
                        @endif
                        {{-- <tr>
                        <th>
                            Approval By
                        </th>
                        <td>
                            {{ $activity->approval_by->name ?? '' }}
                        </td>
                    </tr> --}}
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
            width: 100px;
            /* Adjust the width as needed */
        }
    </style>
@endsection
