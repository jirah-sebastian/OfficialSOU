<?php

namespace App\Http\Controllers\Admin;

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
use Yajra\DataTables\Facades\DataTables;
use App\Mail\{ActivityApprovedNotification, ActivityIsPublish, ActivityRejectedNotification, ActivityProposalNotification, ActivityEditNotification};
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ActivityController extends Controller
{
    use MediaUploadingTrait;
    public Activity $activity;
    public $so_pres;
    public $so_name;

    public function index(Request $request)
    {
        abort_if(Gate::denies('activity_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Activity::where(function ($query) {
                if (auth()->user()->is_pres) {
                    $query->where('created_by_id', auth()->id());
                }
            })
                ->with(['organization', 'created_by'])
                ->withTrashed()
                ->select(sprintf('%s.*', (new Activity)->table))
                ->orderByRaw('
                CASE 
                    WHEN status = "Pending" THEN 0 
                    WHEN status = "Approved" THEN 1
                    WHEN status = "Rejected" THEN 2
                    ELSE 3
                END,
                IF(deleted_at IS NULL, 0, 1),
                id DESC');


            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');


            // Add new columns here
            $table->addColumn('sustainable_development_goal', function ($row) {
                return $row->sustainable_development_goal ?? ''; // Change 'sustainable_development_goal' to match your field name
            });

            $table->addColumn('type_of_activity', function ($row) {
                return $row->type_of_activity ?? ''; // Change 'type_of_activity' to match your field name
            });

            $table->addColumn('gad_funded', function ($row) {
                return $row->gad_funded;
            });


            $table->editColumn('actions', function ($row) {
                $viewGate      = 'activity_show';
                $editGate      = 'activity_edit';
                $deleteGate    = 'activity_delete';
                $crudRoutePart = 'activities';

                return view('admin.activities.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->addColumn('organization_so_category_name', function ($row) {
                return $row->organization ? $row->organization->so_category->category_name : '';
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('title', function ($row) {
                return $row->title ? $row->title : '';
            });
            $table->editColumn('sub_title', function ($row) {
                return $row->sub_title ? $row->sub_title : '';
            });
            $table->editColumn('content_photo', function ($row) {
                if ($photo = $row->content_photo) {
                    return sprintf(
                        '<a href="%s" target="_blank"><img src="%s" width="50px" height="50px"></a>',
                        $photo->url,
                        $photo->thumbnail
                    );
                }

                return '';
            });

            $table->editColumn('status', function ($row) {
                if ($row->deleted_at) {
                    return '<span class="badge badge-dark">Archived</span>';
                }
                if ($row->status == 'Approved')
                    return '<span class="badge badge-success">Approved</span>';
                if ($row->status == 'Rejected')
                    return '<span class="badge badge-danger">Rejected</span>';

                if ($row->status == 'Pending')
                    return '<span class="badge badge-warning">Pending</span>';
            });
            $table->editColumn('remarks', function ($row) {
                return $row->remarks ? $row->remarks : '';
            });
            $table->editColumn('is_published', function ($row) {
                if ($row->deleted_at) {
                    return 'Private';
                } else {
                    return $row->is_published ? 'Public' : 'Private';
                }
            });

            $table->addColumn('organization_so_name', function ($row) {
                return $row->organization ? $row->organization->so_name : '';
            });
            $table->editColumn('permit', function ($row) {
                if ($permit = $row->permit) {
                    if ($permit->mime_type && strpos($permit->mime_type, 'image') !== false) {
                        // If the permit is an image
                        return sprintf(
                            '<a href="%s" target="_blank"><img src="%s" width="50px" height="50px"></a>',
                            $permit->getUrl(), // Direct URL to the full-size image
                            $permit->getUrl('thumb') // URL to the thumbnail version of the image
                        );
                    } else {
                        // If the permit is a file
                        return sprintf(
                            '<a href="%s" target="_blank"><i class="fa fa-file" aria-hidden="true" style="font-size: 50px;"></i></a>',
                            $permit->getUrl() // Direct URL to the file
                        );
                    }
                }

                return '';
            });

            $table->addColumn('created_by_name', function ($row) {
                return $row->created_by ? $row->created_by->name : '';
            });


            $table->rawColumns(['actions', 'status', 'placeholder', 'content_photo', 'is_published', 'organization', 'created_by', 'permit']);

            return $table->make(true);
        }

        $so_lists = SoList::get();
        $users    = User::get();

        return view('admin.activities.index', compact('so_lists', 'users'));
    }

    public function create()
    {
        abort_if(Gate::denies('activity_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $organizations = SoList::where('created_by_id', auth()->id())->pluck('so_name', 'id');

        $created_bies = User::where('id', auth()->id())->pluck('name', 'id');



        return view('admin.activities.create', compact('created_bies', 'organizations'));
    }

    public function store(StoreActivityRequest $request)
    {
        // Decode the JSON string back into an array
        if ($request->has('sustainable_development_goal')) {
            $request->merge([
                'sustainable_development_goal' => $request->input('sustainable_development_goal')
            ]);
        }

        // Add default status
        $request->request->add(['status' => 'Pending']);

        // Create the activity
        $activity = Activity::create($request->all());

        // Handle file uploads
        if ($request->input('content_photo', false)) {
            $activity->addMedia(storage_path('tmp/uploads/' . basename($request->input('content_photo'))))->toMediaCollection('content_photo');
        }
        if ($request->input('permit', false)) {
            $activity->addMedia(storage_path('tmp/uploads/' . basename($request->input('permit'))))->toMediaCollection('permit');
        }

        // Handle CK media
        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $activity->id]);
        }

        // Load organization relation
        $activity->load('organization');

        // Get the admins' emails
        $admins = User::whereHas('roles', function ($query) {
            $query->where('id', 2);
        })->get();

        // Send email notifications
        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new ActivityProposalNotification(
                $activity->title,
                $activity->event_date,
                $activity->content,
                $activity->organization->so_name,
                $activity->organization->so_category->category_name,
                $activity->sub_title,
                $activity->event_place,
                $activity->type_of_activity,
                $activity->sustainable_development_goal,
                $activity->gad_funded
            ));
        }

        return redirect()->route('admin.activities.index');
    }


    public function edit(Activity $activity)
    {
        abort_if(Gate::denies('activity_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    
        $organizations = SoList::where('id', $activity->organization_id)->pluck('so_name', 'id');
        $created_bies = User::where('id', $activity->created_by_id)->pluck('name', 'id');
    
        // Convert the sustainable_development_goal to a string for display
        if (is_array($activity->sustainable_development_goal)) {
            $activity->sustainable_development_goal_display = implode(', ', $activity->sustainable_development_goal);
        } else {
            $activity->sustainable_development_goal_display = $activity->sustainable_development_goal;
        }
    
        $activity->load('organization', 'created_by');
    
        return view('admin.activities.edit', compact('activity', 'created_bies', 'organizations'));
    }
    
    

    public function update(UpdateActivityRequest $request, Activity $activity)
    {

        // $activity = Activity::withTrashed()->where('id',$id)->first();
        $activity->update($request->all());

        // Update the activity with the request data except 'sustainable_development_goal'
        $activity->update($request->except('sustainable_development_goal'));

        // Manually update the sustainable_development_goal field
        $activity->sustainable_development_goal = $request->input('sustainable_development_goal');
        $activity->save();

        if ($request->input('content_photo', false)) {
            if (!$activity->content_photo || $request->input('content_photo') !== $activity->content_photo->file_name) {
                if ($activity->content_photo) {
                    $activity->content_photo->delete();
                }
                $activity->addMedia(storage_path('tmp/uploads/' . basename($request->input('content_photo'))))->toMediaCollection('content_photo');
            }
        } elseif ($activity->content_photo) {
            $activity->content_photo->delete();
        }

        if ($request->input('permit', false)) {
            if (!$activity->permit || $request->input('permit') !== $activity->permit->file_name) {
                if ($activity->permit) {
                    $activity->permit->delete();
                }
                $activity->addMedia(storage_path('tmp/uploads/' . basename($request->input('permit'))))->toMediaCollection('permit');
            }
        } elseif ($activity->permit) {
            $activity->permit->delete();
        }
        $activity->load('created_by');
        // Send email notification if created_by exists
        if ($activity->created_by) {
            $activityOwnerName = $activity->created_by->name;
            $soName = $activity->organization->so_name;
            $activityTitle = $activity->title; // Add this line to get the activity title
            // Retrieve the changes made to the activity
            $changes = $activity->getChanges();

            // Modify column names as needed
            $changes = array_map(function ($change, $column) {
                switch ($column) {
                    case 'title':
                        return ['Activity Title' => $change];
                    case 'sub_title':
                        return ['Activity Control No.' => $change];
                    case 'content':
                        return ['Information' => $change];

                    case 'event_date':
                        return ['Date of Implementation' => $change];
                    case 'updated_at':
                        return ['Updated At' => $change];
                    case 'event_place':
                        return ['Venue' => $change];
                    case 'sustainable_development_goal':
                        return ['SDG' => $change];
                    case 'type_of_activity':
                        return ['Type of Activity' => $change];
                    case 'gad_funded':
                        return ['GAD Funded' => $change];
                    default:
                        return [$column => $change];
                }
            }, $changes, array_keys($changes));

            // Flatten the array
            $changes = array_merge(...$changes);

            // Send email notification if created_by exists
            if ($activity->created_by) {
                $activityOwnerName = $activity->created_by->name;
                $soName = $activity->organization->so_name;
                $activityTitle = $activity->title; // Add this line to get the activity title

                Mail::to($activity->created_by->email)->send(new ActivityEditNotification($activityOwnerName, $soName, $activityTitle, $changes));
            }
            return redirect()->route('admin.activities.show', $activity)->with(['success' => true, 'message' => 'Activity updated successfully.']);
        }
    }

    public function show($id)
    {
        $activity = Activity::withTrashed()->findOrFail($id);
        abort_if(Gate::denies('activity_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $activity->load('organization', 'created_by', 'approval_by');

        // Convert gad_funded to Yes or No
        $activity->gad_funded;


        if ($activity->deleted_at || $activity->status != 'Approved') {
            $activity->is_published = 'Private';
        } else {
            $activity->is_published = 'Public';
        }

        return view('admin.activities.show', compact('activity'));
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
            $activity->o_status = $activity->status;
            $activity->save();
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
    public function approve($id, $status)
    {

        $activity = Activity::find($id);

        $activity->load(['organization', 'organization.created_by', 'created_by']);
        if ($status == 'approve') {
            $activity->status = 'Approved';
            $activity->approval_by_id = auth()->id();
            $activity->approval_date = now();
            $activityTitle = $activity->title;

            $activity->is_published = 1;
            Mail::to($activity->created_by->email)->send(new ActivityApprovedNotification($activity->organization->created_by->name, $activity->organization->so_name,  $activityTitle));
            $so_presses = User::whereHas('roles', function ($query) {
                $query->where('id', 3);
            })->get();

            foreach ($so_presses as $so_pres) {
                // Check if the user's account is approved
                if ($so_pres->approved == 'Approved') {
                    // Send email only to approved presidents
                    Mail::to($so_pres->email)->send(new ActivityIsPublish($activity, $activity->organization->created_by->name, $activity->organization->so_name));
                }
            }
        } else if ($status == 'reject') {
            $activity->status = 'Rejected';
            $activity->approval_by_id = auth()->id();
            $activity->approval_date = now();
            $activityTitle = $activity->title;

            $activity->remarks = request()->remarks;
            Mail::to($activity->created_by->email)->send(new ActivityRejectedNotification($activity->organization->created_by->name, $activity->organization->so_name, request()->remarks, $activityTitle));
        }
        $activity->save();

        return back();
    }
    public function restore($id, $action)
    {
        $activity = Activity::withTrashed()->where('id', $id)->first();

        if ($action == 'restore') {
            $activity->deleted_at = null;
            $activity->status = $activity->o_status;
        } else if ($action == 'delete') {
            $activity->o_status = $activity->status;
            $activity->status = 'Archived';
            $activity->deleted_at = now();
        }

        $activity->save();
        return back();
    }
}
