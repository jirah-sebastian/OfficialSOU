<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyActivityRequest;
use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use App\Models\Activity;
use App\Models\SoList;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class ActivityController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('activity_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $activities = Activity::with(['organization', 'created_by', 'media'])->get();

        $so_lists = SoList::get();

        $users = User::get();

        return view('frontend.activities.index', compact('activities', 'so_lists', 'users'));
    }

    public function create()
    {
        abort_if(Gate::denies('activity_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $organizations = SoList::pluck('so_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $created_bies = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.activities.create', compact('created_bies', 'organizations'));
    }

    public function store(StoreActivityRequest $request)
    {
        $activity = Activity::create($request->all());

        if ($request->input('content_photo', false)) {
            $activity->addMedia(storage_path('tmp/uploads/' . basename($request->input('content_photo'))))->toMediaCollection('content_photo');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $activity->id]);
        }

        return redirect()->route('frontend.activities.index');
    }

    public function edit(Activity $activity)
    {
        abort_if(Gate::denies('activity_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $organizations = SoList::pluck('so_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $created_bies = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $activity->load('organization', 'created_by');

        return view('frontend.activities.edit', compact('activity', 'created_bies', 'organizations'));
    }

    public function update(UpdateActivityRequest $request, Activity $activity)
    {
        $activity->update($request->all());

        if ($request->input('content_photo', false)) {
            if (! $activity->content_photo || $request->input('content_photo') !== $activity->content_photo->file_name) {
                if ($activity->content_photo) {
                    $activity->content_photo->delete();
                }
                $activity->addMedia(storage_path('tmp/uploads/' . basename($request->input('content_photo'))))->toMediaCollection('content_photo');
            }
        } elseif ($activity->content_photo) {
            $activity->content_photo->delete();
        }

        return redirect()->route('frontend.activities.index');
    }

    public function show(Activity $activity)
    {
        abort_if(Gate::denies('activity_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $activity->load('organization', 'created_by');

        return view('frontend.activities.show', compact('activity'));
    }

    public function destroy(Activity $activity)
    {
        abort_if(Gate::denies('activity_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $activity->delete();

        return back();
    }

    public function massDestroy(MassDestroyActivityRequest $request)
    {
        $activities = Activity::find(request('ids'));

        foreach ($activities as $activity) {
            $activity->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('activity_create') && Gate::denies('activity_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Activity();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
