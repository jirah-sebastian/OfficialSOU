@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header" style="background-color: #005600; color:white;">
            <strong>VIEW SO CATEGORY</strong>
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.so-categories.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th>
                                {{ trans('cruds.soCategory.fields.category_name') }}
                            </th>
                            <td>
                                {{ $soCategory->category_name }}
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="table-responsive">
                    <form action="{{ route('admin.so-lists.massDestroy') }}" method="POST" id="mass_destroy_form">
                        @csrf
                        @method('DELETE')

                        <table class="table table-bordered table-striped table-hover datatable datatable-soCategorySoLists">
                            <thead>
                                <tr>
                                    <th width="10">

                                    </th>
                                    <th>{{ trans('cruds.soList.fields.so_name') }}</th>
                                    <th>SO President</th>
                                    <th>{{ trans('cruds.soList.fields.so_category') }}</th>
                                    <th>Logo</th>
                                    <th>{{ trans('cruds.soList.fields.overview') }}</th>
                                    <th>
                                        Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($soCategory->soCategorySoLists as $key => $soList)
                                    <tr data-entry-id="{{ $soList->id }}">
                                        <td>
                                            <input type="checkbox" name="ids[]" value="{{ $soList->id }}">
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.so-lists.show', $soList->id) }}" style="color: green;">
                                                {{ $soList->so_name ?? '' }}
                                            </a>
                                        </td>
                                        
                                        <td>{{ $soList->created_by->name ?? '' }}</td>
                                        <td>{{ $soList->so_category->category_name ?? '' }}</td>
                                        <td>
                                            @if ($soList->banner)
                                                <a href="{{ $soList->banner->getUrl() }}" target="_blank"
                                                    style="display: inline-block">
                                                    <img src="{{ $soList->banner->getUrl('thumb') }}">
                                                </a>
                                            @endif
                                        </td>
                                        <td>{{ $soList->overview ?? '' }}</td>
                                        <td>{{ App\Models\SoList::APPROVED_SELECT[$soList->approved] ?? '' }}</td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#select_all').click(function() {
                $('input[type="checkbox"]').prop('checked', this.checked);
            });

            $('.datatable-soCategorySoLists').DataTable({
                order: [
                    [1, 'desc']
                ],
                pageLength: 25,
            });

            $('#mass_destroy').on('submit', function(e) {
                if (confirm('{{ trans('global.areYouSure') }}')) {
                    return true;
                } else {
                    e.preventDefault();
                }
            });
        });
    </script>
@endpush
