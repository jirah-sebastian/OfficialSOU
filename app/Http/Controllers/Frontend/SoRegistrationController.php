<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroySoRegistrationRequest;
use App\Http\Requests\StoreSoRegistrationRequest;
use App\Http\Requests\UpdateSoRegistrationRequest;
use App\Models\SoList;
use App\Models\SoRegistration;
use App\Models\Title;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use App\Mail\RegistrationNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Mail;
use App\Mail\{SoRegistrationApplicationNotification,SoRegistrationAdminRejectedPres,SoRegistrationAdminApprovedPres,SoRegistrationAdminRejected,SoRegistrationPresApproval,SoRegistrationPresRejected,SoRegistrationAdminApproval,SoRegistrationAdminApproved};
use Log;
class SoRegistrationController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('so_registration_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            if(auth()->user()->is_pres){
                $soId = SoList::where('created_by_id',auth()->id())->first();
                $query = SoRegistration::where('so_list_id',$soId->id ?? '')->with(['so_list', 'title'])->select(sprintf('%s.*', (new SoRegistration)->table));
            }
            else{
                Log::info(request());
                if(request()->so_list)

                    $query = SoRegistration::where('so_list_id',request()->so_list)->with(['so_list', 'title'])->select(sprintf('%s.*', (new SoRegistration)->table));
                else
                    $query = SoRegistration::with(['so_list', 'title'])->select(sprintf('%s.*', (new SoRegistration)->table));
            }

            $query->withTrashed();

            $table = Datatables::of($query);


            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('profile_picture', function ($row) {
                if ($photo = $row->profile_picture) {
                    return sprintf(
                        '<a href="%s" target="_blank"><img src="%s" width="50px" height="50px"></a>',
                        $photo->url,
                        $photo->thumbnail
                    );
                }

                return '';
            });
            $table->editColumn('full_name', function ($row) {
                return sprintf(
                    '<a href="%s">%s</a>',route('admin.so-registrations.show',$row->id),$row->full_name ? $row->full_name : '');

            });
            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : '';
            });
            $table->addColumn('so_list_so_name', function ($row) {
                return $row->so_list ? $row->so_list->so_name : '';
            });

            $table->editColumn('membership_type', function ($row) {
                return $row->membership_type ? SoRegistration::MEMBERSHIP_TYPE_SELECT[$row->membership_type] : '';
            });
            $table->editColumn('position', function ($row) {
                return $row->position ? $row->position : '';
            });

            $table->editColumn('president_approval', function ($row) {
                if ($row->deleted_at) {
                    return '<span class="badge badge-dark">Archived</span>';
                } else {
                    return $row->president_approval ? SoRegistration::PRESIDENT_APPROVAL_SELECT[$row->president_approval] : '';
                }
            });
            
            $table->editColumn('admin_approval', function ($row) {
                if ($row->deleted_at) {
                    return '<span class="badge badge-dark">Archived</span>';
                } else {
                    return $row->admin_approval ? SoRegistration::ADMIN_APPROVAL_SELECT[$row->admin_approval] : '';
                }
            });
            

            $table->rawColumns(['profile_picture', 'full_name','so_list','president_approval','admin_approval']);

            return $table->make(true);
        }

        $so_lists = SoList::get();
        $titles   = Title::get();

        return view('admin.soRegistrations.index', compact('so_lists', 'titles'));
    }

    public function create()
    {
        abort_if(Gate::denies('so_registration_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $so_lists = SoList::pluck('so_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $titles = Title::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.soRegistrations.create', compact('so_lists', 'titles'));
    }

    public function store(StoreSoRegistrationRequest $request)
    {
        $request->request->add(['president_approval' => 'Pending']);
        $request->request->add(['admin_approval' => 'Waiting for Organization President Approval']);
        $soRegistration = SoRegistration::create($request->all());
        $so = SoList::where('id',$soRegistration->so_list_id)->with(['created_by'])->first();
        Mail::to($soRegistration->email)->send(new SoRegistrationApplicationNotification($soRegistration->full_name,$soRegistration->email,$soRegistration->membership_type,\Carbon\Carbon::now()->toDateString(),$so->created_by->name,$so->so_name));
        Mail::to($so->created_by->email)->send(new SoRegistrationPresApproval($soRegistration->full_name,$soRegistration->email,$soRegistration->membership_type,\Carbon\Carbon::now()->toDateString(),$so->created_by->name,$so->so_name));

        if ($request->input('profile_picture', false)) {
            $soRegistration->addMedia(storage_path('tmp/uploads/' . basename($request->input('profile_picture'))))->toMediaCollection('profile_picture');
        }

        if ($request->input('profile_form', false)) {
            $soRegistration->addMedia(storage_path('tmp/uploads/' . basename($request->input('profile_form'))))->toMediaCollection('profile_form');
        }

        if ($request->input('parent_consent_form', false)) {
            $soRegistration->addMedia(storage_path('tmp/uploads/' . basename($request->input('parent_consent_form'))))->toMediaCollection('parent_consent_form');
        }

        if ($request->input('data_privacy_form', false)) {
            $soRegistration->addMedia(storage_path('tmp/uploads/' . basename($request->input('data_privacy_form'))))->toMediaCollection('data_privacy_form');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $soRegistration->id]);
        }

        //Mail::to('rfgatchalian1819@gmail.com')->send(new RegistrationNotification());
        //Mail::to($soRegistration->email)->send(new SoRejectedNotification($check->full_name,$check->so_list->so_name,$check->so_list->created_by->name,'President'));
        return redirect()->to('/sois/student-organization/apply/'.$soRegistration->so_list_id)->with('success', 'Registration success. Wait for your approval');
    }

    public function edit(SoRegistration $soRegistration)
    {
        abort_if(Gate::denies('so_registration_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $so_lists = SoList::pluck('so_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $titles = Title::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $soRegistration->load('so_list', 'title');

        return view('admin.soRegistrations.edit', compact('soRegistration', 'so_lists', 'titles'));
    }

    public function update(UpdateSoRegistrationRequest $request, SoRegistration $soRegistration)
    {
        $soRegistration->update($request->all());

        if ($request->input('profile_picture', false)) {
            if (! $soRegistration->profile_picture || $request->input('profile_picture') !== $soRegistration->profile_picture->file_name) {
                if ($soRegistration->profile_picture) {
                    $soRegistration->profile_picture->delete();
                }
                $soRegistration->addMedia(storage_path('tmp/uploads/' . basename($request->input('profile_picture'))))->toMediaCollection('profile_picture');
            }
        } elseif ($soRegistration->profile_picture) {
            $soRegistration->profile_picture->delete();
        }

        if ($request->input('profile_form', false)) {
            if (! $soRegistration->profile_form || $request->input('profile_form') !== $soRegistration->profile_form->file_name) {
                if ($soRegistration->profile_form) {
                    $soRegistration->profile_form->delete();
                }
                $soRegistration->addMedia(storage_path('tmp/uploads/' . basename($request->input('profile_form'))))->toMediaCollection('profile_form');
            }
        } elseif ($soRegistration->profile_form) {
            $soRegistration->profile_form->delete();
        }

        if ($request->input('parent_consent_form', false)) {
            if (! $soRegistration->parent_consent_form || $request->input('parent_consent_form') !== $soRegistration->parent_consent_form->file_name) {
                if ($soRegistration->parent_consent_form) {
                    $soRegistration->parent_consent_form->delete();
                }
                $soRegistration->addMedia(storage_path('tmp/uploads/' . basename($request->input('parent_consent_form'))))->toMediaCollection('parent_consent_form');
            }
        } elseif ($soRegistration->parent_consent_form) {
            $soRegistration->parent_consent_form->delete();
        }

        if ($request->input('data_privacy_form', false)) {
            if (! $soRegistration->data_privacy_form || $request->input('data_privacy_form') !== $soRegistration->data_privacy_form->file_name) {
                if ($soRegistration->data_privacy_form) {
                    $soRegistration->data_privacy_form->delete();
                }
                $soRegistration->addMedia(storage_path('tmp/uploads/' . basename($request->input('data_privacy_form'))))->toMediaCollection('data_privacy_form');
            }
        } elseif ($soRegistration->data_privacy_form) {
            $soRegistration->data_privacy_form->delete();
        }

        return redirect()->route('admin.so-registrations.index',['so_list' => $soRegistration->so_list_id]);
    }

    public function show($id)
    {
        // Retrieve the SoRegistration record with the provided ID, including soft deleted records
        $soRegistration = SoRegistration::withTrashed()->findOrFail($id);
    
        // Check if the user has permission to view SoRegistrations
        abort_if(Gate::denies('so_registration_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        // Load related data
        $soRegistration->load('so_list', 'title','approved_by');
    
        // Pass the $soRegistration object to the view
        return view('admin.soRegistrations.show', compact('soRegistration'));
    }
    
 
    public function storeCKEditorImages(Request $request)
    {
        //abort_if(Gate::denies('so_registration_create') && Gate::denies('so_registration_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new SoRegistration();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
    public function approval(Request $request){

        $soRegistration = SoRegistration::find($request->id);
        $soRegistration->status = $request->status;
        $soRegistration->remark = $request->remarks;
        $soRegistration->save();

        return back();
    }

    public function presapproval($id,$action){
        $myOrg = SoList::where('created_by_id',auth()->id())->first();
        $soRegistration = SoRegistration::where('id',$id)->first();
        if($soRegistration && $soRegistration->so_list_id == $myOrg->id){
            if($action == 'approve'){
                $soRegistration->president_approval = 'Approved';
                $soRegistration->admin_approval = 'Pending';
                $soRegistration->save();
                $admins = User::whereHas('roles', function ($query) { $query->where('id', 2); })->get();
                Log::info($admins);
                foreach($admins as $admin){
                    Mail::to($admin->email)->send(new SoRegistrationAdminApproval($soRegistration->full_name,$soRegistration->email,$soRegistration->membership_type,$soRegistration->created_at,auth()->user()->name,$myOrg->so_name,));

                }

                return back()->with(['message' => 'Registration Approved']);
            }
            elseif($action == 'reject'){
                $soRegistration->president_approval = 'Rejected';
                $soRegistration->remark = request()->remarks1;
                $soRegistration->save();

                Mail::to($soRegistration->email)->send(new SoRegistrationPresRejected($soRegistration->full_name,$soRegistration->remark,auth()->user()->name,$myOrg->so_name,));

                return back()->with(['message' => 'Registration rejected']);
            }
        }
        else{
            abort('403');
        }
    }
    public function adminapproval($id,$action){
        if(!auth()->user()->is_pres){
            $soRegistration = SoRegistration::where('id',$id)->first();
            if($soRegistration){
                if($action == 'approve'){
                    $soRegistration->admin_approval = 'Approved';
                    $soRegistration->approved_by_id = auth()->id();
                    $soRegistration->date_approval = now();
                    $soRegistration->save();
                    $so = SoList::find($soRegistration->so_list_id);
                    $pres = User::find($so->created_by_id);
                    Mail::to($soRegistration->email)->send(new SoRegistrationAdminApproved($so->so_name,$soRegistration->full_name));
                    Mail::to($pres->email)->send(new SoRegistrationAdminApprovedPres($pres->name,$soRegistration->full_name,$so->name));


                    return back()->with(['message' => 'Registration Approved']);


                }
                elseif($action == 'reject'){
                    $soRegistration->admin_approval = 'Rejected';
                    $soRegistration->admin_remark = request()->remarks2;
                    $soRegistration->approved_by_id = auth()->id();
                    $soRegistration->date_approval = now();
                    $soRegistration->save();
                    $so = SoList::find($soRegistration->so_list_id);
                    $pres = User::find($so->created_by_id);

                    Mail::to($pres->email)->send(new SoRegistrationAdminRejectedPres($pres->name,$soRegistration->full_name,$soRegistration->admin_remark,$so->so_name));

                    Mail::to($soRegistration->email)->send(new SoRegistrationAdminRejected($soRegistration->full_name,$soRegistration->admin_remark,$pres->name,$so->so_name));

                    return back()->with(['message' => 'Registration rejected']);
                }
            }
            else{
                abort(403);
            }
        }
        else{
            abort(403);
        }
    }

    public function destroy(SoRegistration $soRegistration)
    {
        abort_if(Gate::denies('so_registration_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $soRegistration->delete();

        return back();
    }

    public function massDestroy(MassDestroySoRegistrationRequest $request)
    {
        $soRegistrations = SoRegistration::find(request('ids'));

        foreach ($soRegistrations as $soRegistration) {
            $soRegistration->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function restore($id, $action)
    {
        // Find the SoRegistration instance by ID, including soft deleted records
        $soRegistration = SoRegistration::withTrashed()->findOrFail($id);
    
        // Check the action parameter to determine whether to restore or delete permanently
        if ($action == 'restore') {
            // Restore the soft-deleted record
            $soRegistration->restore();
        } elseif ($action == 'delete') {
            // Permanently delete the record
            $soRegistration->delete();
        }
    
        // Redirect back to the index page or any other appropriate page
        return back()->with('success', 'SoRegistration ' . ($action == 'restore' ? 'restored' : 'permanently deleted') . ' successfully.');
    }
    
}