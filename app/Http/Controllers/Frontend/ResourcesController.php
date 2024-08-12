<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyResourceRequest;
use App\Http\Requests\StoreResourceRequest;
use App\Http\Requests\UpdateResourceRequest;
use App\Models\Resource;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class ResourcesController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('resource_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $resources = Resource::with(['created_by', 'media'])->get();

        $users = User::get();

        return view('frontend.resources.index', compact('resources', 'users'));
    }

    public function create()
    {
        abort_if(Gate::denies('resource_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $created_bies = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.resources.create', compact('created_bies'));
    }

    public function store(StoreResourceRequest $request)
    {
        $resource = Resource::create($request->all());

        if ($request->input('file', false)) {
            $resource->addMedia(storage_path('tmp/uploads/' . basename($request->input('file'))))->toMediaCollection('file');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $resource->id]);
        }

        return redirect()->route('frontend.resources.index');
    }

    public function edit(Resource $resource)
    {
        abort_if(Gate::denies('resource_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $created_bies = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $resource->load('created_by');

        return view('frontend.resources.edit', compact('created_bies', 'resource'));
    }

    public function update(UpdateResourceRequest $request, Resource $resource)
    {
        $resource->update($request->all());

        if ($request->input('file', false)) {
            if (! $resource->file || $request->input('file') !== $resource->file->file_name) {
                if ($resource->file) {
                    $resource->file->delete();
                }
                $resource->addMedia(storage_path('tmp/uploads/' . basename($request->input('file'))))->toMediaCollection('file');
            }
        } elseif ($resource->file) {
            $resource->file->delete();
        }

        return redirect()->route('frontend.resources.index');
    }

    public function show(Resource $resource)
    {
        abort_if(Gate::denies('resource_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $resource->load('created_by');

        return view('frontend.resources.show', compact('resource'));
    }

    public function destroy(Resource $resource)
    {
        abort_if(Gate::denies('resource_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $resource->delete();

        return back();
    }

    public function massDestroy(MassDestroyResourceRequest $request)
    {
        $resources = Resource::find(request('ids'));

        foreach ($resources as $resource) {
            $resource->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('resource_create') && Gate::denies('resource_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Resource();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
