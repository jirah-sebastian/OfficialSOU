<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyOrganizationApplicationFormRequest;
use App\Http\Requests\StoreOrganizationApplicationFormRequest;
use App\Http\Requests\UpdateOrganizationApplicationFormRequest;
use App\Models\OrganizationApplicationForm;
use App\Models\SoList;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class OrganizationApplicationFormController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('organization_application_form_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $organizationApplicationForms = OrganizationApplicationForm::with(['organization', 'media'])->get();

        return view('frontend.organizationApplicationForms.index', compact('organizationApplicationForms'));
    }

    public function create()
    {
        abort_if(Gate::denies('organization_application_form_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $organizations = SoList::pluck('so_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.organizationApplicationForms.create', compact('organizations'));
    }

    public function store(StoreOrganizationApplicationFormRequest $request)
    {
        $organizationApplicationForm = OrganizationApplicationForm::create($request->all());

        if ($request->input('application_form', false)) {
            $organizationApplicationForm->addMedia(storage_path('tmp/uploads/' . basename($request->input('application_form'))))->toMediaCollection('application_form');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $organizationApplicationForm->id]);
        }

        return redirect()->route('frontend.organization-application-forms.index');
    }

    public function edit(OrganizationApplicationForm $organizationApplicationForm)
    {
        abort_if(Gate::denies('organization_application_form_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $organizations = SoList::pluck('so_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $organizationApplicationForm->load('organization');

        return view('frontend.organizationApplicationForms.edit', compact('organizationApplicationForm', 'organizations'));
    }

    public function update(UpdateOrganizationApplicationFormRequest $request, OrganizationApplicationForm $organizationApplicationForm)
    {
        $organizationApplicationForm->update($request->all());

        if ($request->input('application_form', false)) {
            if (! $organizationApplicationForm->application_form || $request->input('application_form') !== $organizationApplicationForm->application_form->file_name) {
                if ($organizationApplicationForm->application_form) {
                    $organizationApplicationForm->application_form->delete();
                }
                $organizationApplicationForm->addMedia(storage_path('tmp/uploads/' . basename($request->input('application_form'))))->toMediaCollection('application_form');
            }
        } elseif ($organizationApplicationForm->application_form) {
            $organizationApplicationForm->application_form->delete();
        }

        return redirect()->route('frontend.organization-application-forms.index');
    }

    public function show(OrganizationApplicationForm $organizationApplicationForm)
    {
        abort_if(Gate::denies('organization_application_form_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $organizationApplicationForm->load('organization');

        return view('frontend.organizationApplicationForms.show', compact('organizationApplicationForm'));
    }

    public function destroy(OrganizationApplicationForm $organizationApplicationForm)
    {
        abort_if(Gate::denies('organization_application_form_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $organizationApplicationForm->delete();

        return back();
    }

    public function massDestroy(MassDestroyOrganizationApplicationFormRequest $request)
    {
        $organizationApplicationForms = OrganizationApplicationForm::find(request('ids'));

        foreach ($organizationApplicationForms as $organizationApplicationForm) {
            $organizationApplicationForm->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('organization_application_form_create') && Gate::denies('organization_application_form_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new OrganizationApplicationForm();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
