<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroySoListRequest;
use App\Http\Requests\StoreSoListRequest;
use App\Http\Requests\UpdateSoListRequest;
use App\Models\SoCategory;
use App\Models\SoList;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class SoListController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('so_list_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $soLists = SoList::with(['organization_admins', 'so_category', 'created_by', 'media'])->get();

        $users = User::get();

        $so_categories = SoCategory::get();

        return view('frontend.soLists.index', compact('soLists', 'so_categories', 'users'));
    }

    public function create()
    {
        abort_if(Gate::denies('so_list_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $organization_admins = User::pluck('name', 'id');

        $so_categories = SoCategory::pluck('category_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $created_bies = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.soLists.create', compact('created_bies', 'organization_admins', 'so_categories'));
    }

    public function store(StoreSoListRequest $request)
    {
        $soList = SoList::create($request->all());
        $soList->organization_admins()->sync($request->input('organization_admins', []));
        if ($request->input('banner', false)) {
            $soList->addMedia(storage_path('tmp/uploads/' . basename($request->input('banner'))))->toMediaCollection('banner');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $soList->id]);
        }

        return redirect()->route('frontend.so-lists.index');
    }

    public function edit(SoList $soList)
    {
        abort_if(Gate::denies('so_list_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $organization_admins = User::pluck('name', 'id');

        $so_categories = SoCategory::pluck('category_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $created_bies = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $soList->load('organization_admins', 'so_category', 'created_by');

        return view('frontend.soLists.edit', compact('created_bies', 'organization_admins', 'soList', 'so_categories'));
    }

    public function update(UpdateSoListRequest $request, SoList $soList)
    {
        $soList->update($request->all());
        $soList->organization_admins()->sync($request->input('organization_admins', []));
        if ($request->input('banner', false)) {
            if (! $soList->banner || $request->input('banner') !== $soList->banner->file_name) {
                if ($soList->banner) {
                    $soList->banner->delete();
                }
                $soList->addMedia(storage_path('tmp/uploads/' . basename($request->input('banner'))))->toMediaCollection('banner');
            }
        } elseif ($soList->banner) {
            $soList->banner->delete();
        }

        return redirect()->route('frontend.so-lists.index');
    }

    public function show(SoList $soList)
    {
        abort_if(Gate::denies('so_list_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $soList->load('organization_admins', 'so_category', 'created_by', 'soListSoRegistrations', 'organizationActivities', 'organizationOrganizationApplicationForms');

        return view('frontend.soLists.show', compact('soList'));
    }

    public function destroy(SoList $soList)
    {
        abort_if(Gate::denies('so_list_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $soList->delete();

        return back();
    }

    public function massDestroy(MassDestroySoListRequest $request)
    {
        $soLists = SoList::find(request('ids'));

        foreach ($soLists as $soList) {
            $soList->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('so_list_create') && Gate::denies('so_list_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new SoList();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
