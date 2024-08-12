<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use App\Mail\{UserRegisterPresRejected, UserRegisterPresApproved, UserEditNotification};
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Auth\Rule;

class UsersController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = User::whereHas('roles', function ($query) {
                $query->where('id', '!=', 1); // Exclude users with role ID 1 (super admin)
            })
                ->whereNotNull('email') // Exclude users with null email
                ->with(['roles'])
                ->withTrashed()
                // ->orderBy('id', 'desc')
                ->orderByRaw('
                    CASE 
                        WHEN approved = "Pending" THEN 0 
                        ELSE 1 
                    END,
                    IF(so_name IS NULL OR so_name = "", 1, 0),
                    IF(deleted_at IS NULL, 0, 1),
                    id DESC')

                ->select(sprintf('%s.*', (new User)->table));

            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'user_show';
                $editGate      = ''; //'user_edit';
                $deleteGate    = 'user_delete';
                $crudRoutePart = 'users';

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
            $table->editColumn('profile', function ($row) {
                if ($photo = $row->profile) {
                    return sprintf(
                        '<a href="%s" target="_blank"><img src="%s" width="50px" height="50px"></a>',
                        $photo->url,
                        $photo->thumbnail
                    );
                }

                return '';
            });
            $table->editColumn('name', function ($row) {
                return sprintf('<a href="%s">', route('admin.users.show', $row->id)) . $row->name ? $row->name : "" . '</a>';
            });
            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : '';
            });
            $table->editColumn('approved', function ($row) {
                if ($row->approved == 'Pending' && $row->deleted_at == null) {
                    return '<span class="badge badge-warning">' . ($row->approved ?? '') . '</span>';
                } elseif ($row->approved == 'Approved' && $row->deleted_at == null) {
                    return '<span class="badge badge-success">' . ($row->approved ?? '') . '</span>';
                } elseif ($row->approved == 'Rejected' && $row->deleted_at == null) {
                    return '<span class="badge badge-danger">' . ($row->approved ?? '') . '</span>';
                } elseif ($row->deleted_at != null) {
                    return '<span class="badge badge-dark">Archived</span>';
                }
            });

            $table->editColumn('roles', function ($row) {
                $labels = [];
                foreach ($row->roles as $role) {
                    $labels[] = sprintf('<span class="badge badge-primary">%s</span>', $role->title);
                }

                return implode(' ', $labels);
            });

            $table->editColumn('remark', function ($row) {
                return $row->remark ? $row->remark : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'profile', 'approved', 'roles']);

            return $table->make(true);
        }

        $roles = Role::get();

        return view('admin.users.index', compact('roles'));
    }

    public function create()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::where('id',2)->pluck('title', 'id');

        return view('admin.users.create', compact('roles'));
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->all());
        $user->roles()->sync($request->input('roles', []));
        if ($request->input('profile', false)) {
            $user->addMedia(storage_path('tmp/uploads/' . basename($request->input('profile'))))->toMediaCollection('profile');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $user->id]);
        }

        return redirect()->route('admin.users.index');
    }

    public function edit(User $user)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::pluck('title', 'id');

        $user->load('roles');

        return view('admin.users.edit', compact('roles', 'user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->all());
        $user->roles()->sync($request->input('roles', []));

        if ($request->input('profile', false)) {
            if (!$user->profile || $request->input('profile') !== $user->profile->file_name) {
                if ($user->profile) {
                    $user->profile->delete();
                }
                $user->addMedia(storage_path('tmp/uploads/' . basename($request->input('profile'))))->toMediaCollection('profile');
            }
        } elseif ($user->profile) {
            $user->profile->delete();
        }


        $user->load('roles');
        // Send email notification if the user has an email
        if ($user->email) {
            $userName = $user->name;
            // Retrieve the changes made to the user
            $changes = $user->getChanges();

            // Modify column names as needed
            $changes = array_map(function ($change, $column) {
                switch ($column) {
                    case 'name':
                        return ['Name' => $change];
                    case 'email':
                        return ['Email' => $change];
                    case 'approved':
                        return ['Approval Status' => $change];
                    case 'so_name':
                        return ['SO Name' => $change];
                    case 'gender':
                        return ['Gender' => $change];
                    case 'course':
                        return ['Course' => $change];
                    case 'year':
                        return ['Year' => $change];
                    case 'religion':
                        return ['Religion' => $change];
                    case 'nationality':
                        return ['Nationality' => $change];
                    case 'birthdate':
                        return ['Birthdate' => $change];
                    case 'birthplace':
                        return ['Birthplace' => $change];
                    case 'present_address':
                        return ['Present Address' => $change];
                    case 'home_address':
                        return ['Home Address' => $change];
                    case 'contact_no':
                        return ['Contact No' => $change];
                    case 'father_name':
                        return ['Father Name' => $change];
                    case 'father_contact_no':
                        return ['Father Contact No' => $change];
                    case 'mother_name':
                        return ['Mother Name' => $change];
                    case 'mothers_contact_no':
                        return ['Mother\'s Contact No' => $change];
                    case 'source_of_financial_support':
                        return ['Source of Financial Support' => $change];
                    case 'talent_skills':
                        return ['Talent Skills' => $change];
                    case 'date_filed':
                        return ['Date Filed' => $change];
                    case 'approval_update_at':
                        return ['Approval Date' => $change];
                    case 'remark':
                        return ['Remarks' => $change];
                    case 'updated_at':
                        return ['Updated at' => $change];

                    default:
                        return [$column => $change];
                }
            }, $changes, array_keys($changes));

            // Flatten the array
            $changes = array_merge(...$changes);

            // Send email notification
            Mail::to($user->email)->send(new UserEditNotification($userName, $changes));
        }


        // Redirect the user to admin.users.show route after successful update
        return redirect()->route('admin.users.show', $user)->with(['success' => true, 'message' => 'User updated successfully.']);
        // Return a response with JavaScript to reload the current page
        // return response()->json(['success' => true, 'message' => 'User updated successfully.'])->withHeaders([
        //     'Content-Type' => 'application/json',
        // ]);
    }

    public function show($id)
    {

        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $user = User::withTrashed()->where('id', $id)->first();
        $roless = Role::pluck('title', 'id');
        $user->load('roles', 'createdByActivities', 'createdByAnnouncements', 'createdByResources', 'createdBySoLists');

        return view('admin.users.show', compact('user', 'roless'));
    }

    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->delete();

        return back();
    }

    public function massDestroy(MassDestroyUserRequest $request)
    {
        $users = User::find(request('ids'));

        foreach ($users as $user) {
            $user->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('user_create') && Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new User();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }

    public function approval($id, $status)
    {
        $user = User::findOrFail($id);
        if ($status == 'approve') {
            $user->approved = 'Approved';
            $user->approval_by_id = auth()->id();
            $user->approval_update_at = now();
            Mail::to($user->email)->send(new UserRegisterPresApproved($user->so_name, $user->name, $user->email));
        } elseif ($status == 'reject') {
            $user->approved = 'Rejected';
            $user->approval_by_id = auth()->id();
            $user->approval_update_at = now();
            $user->remark = request()->remarks;
            Mail::to($user->email)->send(new UserRegisterPresRejected($user->name, $user->so_name, $user->remark));
            $user->email = null; // Set email to null
        }

        $user->save();

        return back();
    }

    public function restore($id, $action)
    {
        $user = User::withTrashed()->where('id', $id)->first();
        if ($action == 'restore')
            $user->deleted_at = null;
        else if ($action == 'delete')
            $user->deleted_at = now();
        $user->save();
        return back();
    }
}
