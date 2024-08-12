@can($viewGate)
    <a class="btn btn-xs btn-primary" href="{{ route('admin.' . $crudRoutePart . '.show', $row->id) }}">
        {{ trans('global.view') }}
    </a>
@endcan
@can($editGate)
    <a class="btn btn-xs btn-info" href="{{ route('admin.' . $crudRoutePart . '.edit', $row->id) }}">
        {{ trans('global.edit') }}
    </a>
@endcan
{{-- @can($deleteGate)
    <form action="{{ route('admin.' . $crudRoutePart . '.destroy', $row->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
    </form>
@endcan --}}
<form class="reject-form" method="POST" action="{{ route("admin.activities.update", [$row->id]) }}" enctype="multipart/form-data">
    @method('PUT')
    @csrf
    <input type="hidden" name="remarks" class="remarks-input">
    <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="hidden" name="title" id="title" value="{{ old('title', $row->title) }}" required>
    @if(!auth()->user()->is_pres && $row->status == 'Pending')
        <button class="btn btn-xs btn-success" name="action" value="approve" type="submit">Approve</button>
        <button class="btn btn-xs btn-danger" name="action" value="reject" type="submit" id="reject{{$row->id}}">Reject</button>
    @endif

@if (!auth()->user()->is_pres)
@if ($row->status != 'Archived' && !$row->deleted_at)
<button class="btn btn-xs btn-danger" name="action" value="delete" type="submit" id="delete">Archive</button>
@endif
@if($row->deleted_at)
<button class="btn btn-xs btn-success" name="action" value="restore" type="submit" id="restore">Restore</button>
@endif
@endif

</form>

<script>
    $(document).ready(function () {
        $('#reject'+ {{$row->id}}).click(function (event) {
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
