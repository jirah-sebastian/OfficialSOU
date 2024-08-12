<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroySoListRequest;
use App\Http\Requests\StoreSoListRequest;
use App\Http\Requests\UpdateSoListRequest;
use App\Models\SoCategory;
use App\Models\SoList;
use App\Models\User;
use App\Models\SoRegistration;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use App\Mail\{SoListProposalNotification, SoListProposalPresidentNotification, SoListApprovedNotification, SoListRejectedNotification, SOEditNotification};
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SoListController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('so_list_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if (auth()->user()->is_pres) {
            // Retrieve the latest SO list created by the user
            $latestSoList = auth()->user()->createdBySoLists()->latest()->first();

            // Check if a SO list exists
            if ($latestSoList) {
                // Redirect to the show page of the latest SO list
                return redirect()->route('admin.so-lists.show', [$latestSoList->id]);
            } else {
                // If no SO list exists, redirect to the create page
                return redirect()->route('admin.so-lists.create');
            }
        }

        if ($request->ajax()) {
            $query = SoList::where(function ($query) {
                if (auth()->user()->is_pres) {
                    $query->where('created_by_id', auth()->id());
                }
            })
                ->with(['organization_admins', 'so_category', 'created_by'])
                ->withTrashed()
                ->select(sprintf('%s.*', (new SoList)->table))
                ->orderByRaw('
                    CASE 
                        WHEN approved = "Pending" THEN 0 
                        WHEN approved = "Approved" THEN 1
                        WHEN approved = "Rejected" THEN 2
                        ELSE 3
                    END,
                    COALESCE(deleted_at, "9999-12-31") DESC,
                    id DESC');

            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'so_list_show';
                $editGate      = ''; //'so_list_edit';
                $deleteGate    = 'so_list_delete';
                $crudRoutePart = 'so-lists';

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
            $table->editColumn('so_name', function ($row) {
                return $row->so_name ? $row->so_name : '';
            });

            $table->addColumn('so_category_category_name', function ($row) {
                return $row->so_category ? $row->so_category->category_name : '';
            });

            $table->editColumn('banner', function ($row) {
                if ($photo = $row->banner) {
                    return sprintf(
                        '<a href="%s" target="_blank"><img src="%s" width="50px" height="50px"></a>',
                        $photo->url,
                        $photo->thumbnail
                    );
                }
                return '';
            });

            $table->editColumn('overview', function ($row) {
                return $row->overview ? $row->overview : '';
            });

            $table->addColumn('created_by_name', function ($row) {
                return $row->created_by ? $row->created_by->name : '';
            });

            $table->editColumn('approved', function ($row) {
                // Check if the record is soft-deleted
                if ($row->trashed()) {
                    // If it is softly deleted, return "Archived" badge
                    return '<span class="badge badge-dark">Archived</span>';
                } else {
                    // Display status based on the approved field
                    switch ($row->approved) {
                        case 'Pending':
                            return '<span class="badge badge-warning">Pending</span>';
                        case 'Approved':
                            return '<span class="badge badge-success">Approved</span>';
                        case 'Rejected':
                            return '<span class="badge badge-danger">Rejected</span>';
                        case 'Archived':
                            return '<span class="badge badge-dark">Archived</span>';
                        default:
                            return ''; // Handle other cases if necessary
                    }
                }
            });


            $table->editColumn('remark', function ($row) {
                return $row->remark ? $row->remark : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'organization_admin', 'so_category', 'banner', 'created_by', 'approved']);

            return $table->make(true);
        }

        $users         = User::get();
        $so_categories = SoCategory::get();

        return view('admin.soLists.index', compact('users', 'so_categories'));
    }

    public function create()
    {
        // Retrieve the authenticated user's data
        $user = auth()->user();

        // Check if the authenticated user is not allowed to create SoLists
        abort_if(Gate::denies('so_list_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // Retrieve the organization admins and SO categories
        $organization_admins = User::pluck('name', 'id');
        $so_categories = SoCategory::pluck('category_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        // Duplicate the authenticated user's name as the initial value for so_name
        $so_name = $user->so_name;

        // Prepare the created_bies array with the authenticated user's name
        $created_bies = [$user->id => $user->name];

        // Pass the necessary data to the view
        return view('admin.soLists.create', compact('created_bies', 'organization_admins', 'so_categories', 'so_name'));
    }


    public function store(StoreSoListRequest $request)
    {

        $soList = SoList::create($request->all());

        $soList->approved = 'Pending';
        $soList->save();
        $soList->organization_admins()->sync($request->input('organization_admins', []));
        if ($request->input('banner', false)) {
            $soList->addMedia(storage_path('tmp/uploads/' . basename($request->input('banner'))))->toMediaCollection('banner');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $soList->id]);
        }

        $admins = User::whereHas('roles', function ($query) {
            $query->where('id', 2);
        })->get();
        $soList->load('created_by');
        Mail::to(auth()->user()->email)->send(new SoListProposalPresidentNotification(auth()->user()->name, $soList->so_name));
        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new SoListProposalNotification($soList->so_name, $soList->created_by->name, $soList->created_by->email));
        }
        return redirect()->route('admin.so-lists.index');
    }

    public function edit($id)
    {
        abort_if(Gate::denies('so_list_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $soList = SoList::where('id', $id)->withTrashed()->first();
        $organization_admins = User::pluck('name', 'id');

        $so_categories = SoCategory::pluck('category_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        if (auth()->user()->is_pres)
            $created_bies = User::where('id', auth()->id())->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        else
            $created_bies = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $soList->load('organization_admins', 'so_category', 'created_by');

        return view('admin.soLists.edit', compact('created_bies', 'organization_admins', 'soList', 'so_categories'));
    }

    public function update(UpdateSoListRequest $request, SoList $soList)
    {
        $soList->update($request->all());
        $soList->organization_admins()->sync($request->input('organization_admins', []));
        if ($request->input('banner', false)) {
            if (!$soList->banner || $request->input('banner') !== $soList->banner->file_name) {
                if ($soList->banner) {
                    $soList->banner->delete();
                }
                $soList->addMedia(storage_path('tmp/uploads/' . basename($request->input('banner'))))->toMediaCollection('banner');
            }
        } elseif ($soList->banner) {
            $soList->banner->delete();
        }

        $soList->load('created_by');


        // Send email notification if created_by exists
        if ($soList->created_by) {
            $soPres = $soList->created_by->name;
            $soName = $soList->so_name;

            $changes = $soList->getChanges();
       
            // Modify column names as needed
            $changes = array_map(function ($change, $column) {
                switch ($column) {
                    case 'so_name':
                        return ['SO Name' => $change];
                    case 'so_category_id':
                        return ['SO Category' => $change];
                    case 'overview':
                        return ['Overview' => $change];
                    case 'information':
                        return ['Description' => $change];
                    case 'created_by_name':
                        return ['SO President' => $change];
                    case 'anniversary_date':
                        return ['Date of Anniversary' => $change];
                    case 'adviser':
                        return ['Name of Adviser' => $change];
                    case 'adviserEmail':
                        return ['Email of Adviser' => $change];
                    case 'adviserCollege':
                        return ['College of Adviser' => $change];
                    case 'adviserYears':
                        return ['Number of Years as Adviser' => $change];
                    case 'adviserField':
                        return ['Adviser\' Major Field of Specialization' => $change];
                    case 'updated_at':
                        return ['Updated At' => $change];
                    case 'remark':
                        return ['Remarks' => $change];
                    case 'approved':
                        return ['Status' => $change];
                    default:
                        return [$column => $change];
                }
            }, $changes, array_keys($changes));

            // Flatten the array
            $changes = array_merge(...$changes);

            // Send email notification if created_by exists
            if ($soList->created_by) {
                $soPres = $soList->created_by->name;
                $soName = $soList->so_name;

                // Send email notification
                Mail::to($soList->created_by->email)->send(new SOEditNotification($soPres, $soName, $changes));
            }

            // return redirect()->route('admin.so-lists.index');
            return redirect()->route('admin.so-lists.show', $soList)->with(['success' => true, 'message' => 'Student Organization updated successfully.']);
        }
    }

    public function show($id)
    {
        abort_if(Gate::denies('so_list_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $soList = SoList::withTrashed()->findOrFail($id); // Include soft-deleted records
        $organization_admins = User::pluck('name', 'id');
        $so_categories = SoCategory::pluck('category_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $created_bies = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        // Retrieve SoRegistration objects for the specific SoList
        $soRegistrations = SoRegistration::where('so_list_id', $soList->id)->get();

        // Count the number of male and female members
        $maleCount = $soRegistrations->where('gender', 'Male')->where('admin_approval', 'Approved')->count();
        $femaleCount = $soRegistrations->where('gender', 'Female')->where('admin_approval', 'Approved')->count();

        // Total number of members
        $totalMembers = $maleCount + $femaleCount;

        // Count the number of registrations for each year
        $yearCounts = [];
        foreach (SoRegistration::YEAR_SELECT as $year => $label) {
            $yearCount = $soRegistrations->where('year', $year)->where('admin_approval', 'Approved')->count();
            $yearCounts[$label] = $yearCount;
        }

        // Assuming $soList has a relationship to SoCategory
        $soCategory = $soList->so_category;

        $soList->load('organization_admins', 'approval_by', 'created_by', 'soListSoRegistrations', 'organizationActivities', 'organizationOrganizationApplicationForms');

        return view('admin.soLists.show', compact('soList', 'organization_admins', 'so_categories', 'created_bies', 'soCategory', 'maleCount', 'femaleCount', 'totalMembers', 'yearCounts'));
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
    public function approve($id, $status)
    {
        $soList = SoList::find($id);

        $soList->load('created_by');
        if ($status == 'Approve') {
            $soList->approved = 'Approved';
            $soList->approval_by_id = auth()->id();
            $soList->approval_date = now();

            // If the record was previously rejected and archived, reset its original status
            if ($soList->o_status === 'Rejected') {
                $soList->o_status = null;
            }
        } else if ($status == 'Reject') {
            $soList->approved = 'Rejected';
            $soList->approval_by_id = auth()->id();
            $soList->approval_date = now();
            $soList->remark = request()->remarks;
        }
        $soList->save();

        if ($status == 'Approve') {
            Mail::to($soList->created_by->email)->send(new SoListApprovedNotification($soList->created_by->name, $soList->so_name, $soList->created_by->email, \Carbon\Carbon::now()->toDateString()));
        } else if ($status == 'Reject') {
            Mail::to($soList->created_by->email)->send(new SoListRejectedNotification($soList->so_name, $soList->created_by->name, $soList->remark));
        }
        return back();
    }
    public function restore($id, $action)
    {
        $soList = SoList::withTrashed()->where('id', $id)->first();

        if ($action == 'restore') {
            // Restore the record
            $soList->deleted_at = null;

            // Restore the original status if it was previously rejected
            if ($soList->o_status === 'Rejected') {
                $soList->approved = 'Rejected';
            } elseif ($soList->o_status === 'Approved') {
                $soList->approved = 'Approved';
            }
        } elseif ($action == 'delete') {
            // Archive the record
            $soList->o_status = $soList->approved;
            $soList->approved = 'Archived';
            $soList->deleted_at = now();
        }

        $soList->save();
        return back();
    }
}
