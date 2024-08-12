<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyAnnouncementRequest;
use App\Http\Requests\StoreAnnouncementRequest;
use App\Http\Requests\UpdateAnnouncementRequest;
use App\Models\Announcement;
use App\Mail\AnnouncementNotification;
use App\Mail\AnnouncementEditNotification;
use App\Models\{User, SoList};
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Log;

class AnnouncementController extends Controller
{
    use MediaUploadingTrait;

    // public function __construct() {
    //     Log::debug('ann');
    //       $this->middleware('redirectIfNotSet');
    // }

    public function index(Request $request)
    {

        abort_if(Gate::denies('announcement_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');


        if ($request->ajax()) {
            $query = Announcement::with(['created_by'])->withTrashed()->select(sprintf('%s.*', (new Announcement)->table));

            // Check if the user's role is president (role ID 3)
            if (auth()->user()->roles->contains(3)) {
                // If the user is president, exclude archived announcements
                $query->whereNull('deleted_at');
            }

            // Order the announcements by status and creation date
            $query->orderByRaw("CASE WHEN deleted_at IS NOT NULL THEN 1 ELSE 0 END, created_at DESC");



            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'announcement_show';
                $editGate      = 'announcement_edit';
                $deleteGate    = 'announcement_delete';
                $crudRoutePart = 'announcements';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('title', function ($row) {
                return $row->title ? $row->title : '';
            });
            $table->editColumn('photo', function ($row) {
                if ($photo = $row->photo) {
                    return sprintf(
                        '<a href="%s" target="_blank"><img src="%s" width="50px" height="50px"></a>',
                        $photo->url,
                        $photo->thumbnail
                    );
                }

                return '';
            });
            $table->editColumn('is_published', function ($row) {
                if ($row->deleted_at) {
                    return 'Private';
                } else {
                    return $row->is_published ? 'Public' : 'Private';
                }
            });


            $table->editColumn('status', function ($row) {
                if ($row->deleted_at)
                    return 'Archived';
                else
                    return 'Available';
            });

            $table->addColumn('created_by_name', function ($row) {
                return $row->created_by ? $row->created_by->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'photo', 'is_published', 'created_by']);

            return $table->make(true);
        }

        $users = User::get();

        return view('admin.announcements.index', compact('users'));
    }

    public function create()
    {
        abort_if(Gate::denies('announcement_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $created_bies = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.announcements.create', compact('created_bies'));
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
        // Fire email to all presidents regardless of announcement status
        $sos = SoList::with('created_by')->whereNotNull('created_by_id')->get();

        foreach ($sos as $so) {
            if ($so->approved == 'Approved' && $so->created_by) {
                $presidentEmail = $so->created_by->email;
                $presidentName = $so->created_by->name;
        
                // Send email to the president
                Mail::to($presidentEmail)->send(new AnnouncementNotification($presidentName, $announcement->title, $announcement->content));
            }
        }
        

        return redirect()->route('admin.announcements.index');
    }

    public function edit($id)
    {

        abort_if(Gate::denies('announcement_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $announcement = Announcement::withTrashed()->where('id', $id)->first();
        $created_bies = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $announcement->load('created_by');

        return view('admin.announcements.edit', compact('announcement', 'created_bies'));
    }

    public function update(UpdateAnnouncementRequest $request, Announcement $announcement)
    {
        $check = Announcement::find($announcement->id);
        $announcement->update($request->all());

        if ($request->input('photo', false)) {
            if (!$announcement->photo || $request->input('photo') !== $announcement->photo->file_name) {
                if ($announcement->photo) {
                    $announcement->photo->delete();
                }
                $announcement->addMedia(storage_path('tmp/uploads/' . basename($request->input('photo'))))->toMediaCollection('photo');
            }
        } elseif ($announcement->photo) {
            $announcement->photo->delete();
        }

        // if ($announcement->is_published != $check->is_published) {
        //     //fire email
        //     //getall president
        //     $sos = SoList::with('created_by')->whereNotNull('created_by_id')->get();

        //     foreach ($sos as $so) {
        //         Mail::to($so->created_by->email)->send(new AnnouncementNotification($so->created_by->name, $announcement->title, $announcement->content));
        //     }
        // }
        // // return redirect()->route('admin.announcements.index');


        $changes = $announcement->getChanges();

        // Modify column names as needed
        $changes = array_map(function ($change, $column) {
            switch ($column) {
                case 'title':
                    return ['Announcement Title' => $change];

                case 'content':
                    return ['Information' => $change];

                case 'updated_at':
                    return ['Updated At' => $change];
                default:
                    return [$column => $change];
            }
        }, $changes, array_keys($changes));

        // Flatten the array
        $changes = array_merge(...$changes);

        // Fire email to all presidents regardless of announcement status
        $sos = SoList::with('created_by')->whereNotNull('created_by_id')->get();

        foreach ($sos as $so) {
            if ($so->approved == 'Approved' && $so->created_by) {
                $presidentEmail = $so->created_by->email;
                $presidentName = $so->created_by->name;

                // Send email to the president
                Mail::to($presidentEmail)->send(new AnnouncementEditNotification($presidentName, $announcement->title, $changes));

            }
        }
        return redirect()->route('admin.announcements.show', $announcement)->with(['success' => true, 'message' => 'Announcement updated successfully.']);
    }

    public function show($id)
    {
        abort_if(Gate::denies('announcement_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $announcement = Announcement::withTrashed()->findOrFail($id);
        // Determine if the announcement is public or private based on its status
        if ($announcement->deleted_at || !$announcement->is_published) {
            // If the announcement is deleted or not published, it's private
            $announcement->is_published = 'Private';
        } else {
            // Otherwise, it's public
            $announcement->is_published = 'Public';
        }

        $announcement->load('created_by');

        return view('admin.announcements.show', compact('announcement'));
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
    public function restore($id, $action)
    {
        $announcement = Announcement::withTrashed()->where('id', $id)->first();

        if ($action == 'restore')
            $announcement->deleted_at = null;
        else if ($action == 'delete')
            $announcement->deleted_at = now();
        $announcement->save();
        return back();
    }
}
