@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.title.title') }}
    </div>

    <div class="card-body bg-success text-white">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.titles.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.title.fields.id') }}
                        </th>
                        <td>
                            {{ $title->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.title.fields.name') }}
                        </th>
                        <td>
                            {{ $title->name }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.titles.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#title_so_registrations" role="tab" data-toggle="tab">
                {{ trans('cruds.soRegistration.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="title_so_registrations">
            @includeIf('admin.titles.relationships.titleSoRegistrations', ['soRegistrations' => $title->titleSoRegistrations])
        </div>
    </div>
</div>

@endsection