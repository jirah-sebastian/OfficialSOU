@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.organizationApplicationForm.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.organization-application-forms.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.organizationApplicationForm.fields.id') }}
                        </th>
                        <td>
                            {{ $organizationApplicationForm->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.organizationApplicationForm.fields.filename') }}
                        </th>
                        <td>
                            {{ $organizationApplicationForm->filename }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.organizationApplicationForm.fields.application_form') }}
                        </th>
                        <td>
                            @if($organizationApplicationForm->application_form)
                                <a href="{{ $organizationApplicationForm->application_form->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.organizationApplicationForm.fields.organization') }}
                        </th>
                        <td>
                            {{ $organizationApplicationForm->organization->so_name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.organization-application-forms.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection