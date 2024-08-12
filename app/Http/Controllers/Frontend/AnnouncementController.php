<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyAnnouncementRequest;
use App\Http\Requests\StoreAnnouncementRequest;
use App\Http\Requests\UpdateAnnouncementRequest;
use App\Models\Announcement;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class AnnouncementController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('announcement_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $announcements = Announcement::with(['created_by', 'media'])->get();

        $users = User::get();

        return view('frontend.announcements.index', compact('announcements', 'users'));
    }

    public function create()
    {
        abort_if(Gate::denies('announcement_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $created_bies = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.announcements.create', compact('created_bies'));
    }

    public function store(StoreAnnouncementRequest $request)
    {
        $announcement = Announcement::create($request->all());

        if ($request->input('photo', false)) {
            $announcement->addMedia(storage_path('tmp/uploads/' . basename($request->input('photo'))))->toMediaCollection('photo');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $announcement->id]);
        }

        return redirect()->route('frontend.announcements.index');
    }

    public function edit(Announcement $announcement)
    {
        abort_if(Gate::denies('announcement_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $created_bies = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $announcement->load('created_by');

        return view('frontend.announcements.edit', compact('announcement', 'created_bies'));
    }

    public function update(UpdateAnnouncementRequest $request, Announcement $announcement)
    {
        $announcement->update($request->all());

        if ($request->input('photo', false)) {
            if (! $announcement->photo || $request->input('photo') !== $announcement->photo->file_name) {
                if ($announcement->photo) {
                    $announcement->photo->delete();
                }
                $announcement->addMedia(storage_path('tmp/uploads/' . basename($request->input('photo'))))->toMediaCollection('photo');
            }
        } elseif ($announcement->photo) {
            $announcement->photo->delete();
        }

        return redirect()->route('frontend.announcements.index');
    }

    public function show(Announcement $announcement)
    {
        abort_if(Gate::denies('announcement_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $announcement->load('created_by');

        return view('frontend.announcements.show', compact('announcement'));
    }

    public function destroy(Announcement $announcement)
    {
        abort_if(Gate::denies('announcement_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $announcement->delete();

        return back();
    }

    public function massDestroy(MassDestroyAnnouncementRequest $request)
    {
        $announcements = Announcement::find(request('ids'));

        foreach ($announcements as $announcement) {
            $announcement->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('announcement_create') && Gate::denies('announcement_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Announcement();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
