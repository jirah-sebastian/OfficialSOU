@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header" style="background-color: #005600; color:white;">
            <strong>VIEW STUDENT ORGANIZATION</strong>
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    @if (!auth()->user()->is_pres)
                        <a class="btn btn-default"
                            href="{{ URL::previous() == route('admin.so-categories.show', $soCategory->id) ? route('admin.so-categories.show', $soCategory->id) : route('admin.so-lists.index') }}">
                            {{ trans('global.back_to_list') }}
                        </a>
                    @endif
                </div>
                <div class="form-group">
                    <form action="{{ route('admin.so-list.approve', [$soList->id, 'Reject']) }}" method="GET">
                        @if (!auth()->user()->is_pres)
                            @if (!$soList->deleted_at)
                                <a href="{{ route('admin.so-lists.edit', $soList->id) }}" class="btn btn-warning"><i
                                        class="fa fa-edit"></i><b>Edit</b></a>
                            @endif
                            @if ($soList->deleted_at)
                                <a href="{{ route('admin.so-list.restore', [$soList->id, 'restore']) }}"
                                    class="btn btn-success"><i class="fa fa-sync-alt"></i>&nbsp;<b>Restore</b></a>
                            @else
                                <a href="{{ route('admin.so-list.restore', [$soList->id, 'delete']) }}"
                                    class="btn btn-danger"><i class="fa fa-trash"></i>&nbsp;<b>Archive</b></a>
                            @endif

                            @if (!$soList->deleted_at && $soList->approved == 'Pending')
                                <a href="{{ route('admin.so-list.approve', [$soList->id, 'Approve']) }}"
                                    class="btn btn-success"><i class="fa fa-check"></i>&nbsp;<b>Approve</b></a>


                                <input type="hidden" name="remarks" class="remarks-input">
                                <button id="reject" class="btn btn-danger"><i
                                        class="fa fa-times"></i>&nbsp;<b>Reject</b></button>
                            @endif
                        @endif
                        @if ($soList->approved === 'Approved')
                            <a href="{{ route('admin.so-registrations.index', ['so_list' => $soList->id]) }}"
                                class="btn btn-dark">
                                <i class="fa fa-users"></i>&nbsp;<b>View Members</b>
                            </a>
                        @endif

                    </form>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>

                        <tr>
                            <th class="custom-th-width">
                                {{ trans('cruds.soList.fields.so_name') }}
                            </th>
                            <td>
                                {{ $soList->so_name }}
                            </td>
                        </tr>

                        <tr>
                            <th>
                                {{ trans('cruds.soList.fields.so_category') }}
                            </th>
                            <td>
                                {{ $soList->so_category->category_name ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Organization President
                            </th>
                            <td>
                                {{ $soList->created_by->name ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Date of Anniversary
                            </th>
                            <td>
                                {{ $soList->anniversary_date }}
                            </td>
                        </tr>
                        <th>
                            Logo
                        </th>
                        <td>
                            @if ($soList->banner)
                                <a href="{{ $soList->banner->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $soList->banner->getUrl('thumb') }}">
                                </a>
                            @endif

                        </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.soList.fields.overview') }}
                            </th>
                            <td>
                                {{ $soList->overview }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.soList.fields.information') }}
                            </th>
                            <td>
                                {!! $soList->information !!}
                            </td>
                        </tr>

                        <tr>
                            <th>
                                Name of Adviser
                            </th>
                            <td>
                                {{ $soList->adviser }}
                            </td>
                        </tr>

                        <tr>
                            <th>
                                Email of Adviser
                            </th>
                            <td>
                                {{ $soList->adviserEmail }}
                            </td>
                        </tr>

                        
                        <tr>
                            <th>
                                College of Adviser
                            </th>
                            <td>
                                {{ $soList->adviserCollege }}
                            </td>
                        </tr>

                        <tr>
                            <th>
                                Number of Years as Adviser
                            </th>
                            <td>
                                {{ $soList->adviserYears }}
                            </td>
                        </tr>

                        <tr>
                            <th>
                                Adviser's Major Field of Specialization
                            </th>
                            <td>
                                {{ $soList->adviserField }}
                            </td>
                        </tr>


                        @if ($soList->approved === 'Approved')
                            <tr>
                                <th>Total Members</th>
                                <td>{{ $totalMembers }}</td>
                            </tr>
                            <tr>
                                <th>No. of Males</th>
                                <td>{{ $maleCount }}</td>
                            </tr>
                            <tr>
                                <th>No. of Females</th>
                                <td>{{ $femaleCount }}</td>
                            </tr>

                            @foreach ($yearCounts as $label => $count)
                                <tr>
                                    <th>No. of {{ $label }}</th>
                                    <td>{{ $count }}</td>
                                </tr>
                            @endforeach
                        @endif

                        <tr>
                            <th>
                                Status
                            </th>

                            <td>
                                {{ $soList->approved === 'Approved' ? 'Approved' : ($soList->approved === 'Rejected' && auth()->user()->is_pres ? 'Pending' : App\Models\SoList::APPROVED_SELECT[$soList->approved] ?? '') }}

                            </td>
                        </tr>
                        @if ($soList->remark)
                            <tr>
                                <th>
                                    Remarks
                                </th>
                                <td>
                                    <span style="color: red;">{{ $soList->remark }}</span>
                                </td>
                            </tr>
                        @endif

                        {{-- <tr>
                        <th>
                            Approval By
                        </th>
                        <td>
                            {{ $soList->approval_by->name ?? '' }}
                        </td>
                    </tr> --}}
                        @if ($soList->approval_date)
                            <tr>
                                <th>
                                    Approval Date
                                </th>
                                <td>
                                    {{ $soList->approval_date ?? '' }}
                                </td>
                            </tr>
                        @endif

                        @if ($soList->updated_at)
                            <tr>
                                <th>
                                    Updated At
                                </th>
                                <td>
                                    {{ $soList->updated_at ?? '' }}
                                </td>
                            </tr>
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
            width: 150px;
        }
    </style>
@endsection
