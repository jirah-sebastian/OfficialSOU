<?php

namespace App\Http\Controllers\Admin;

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
use Yajra\DataTables\Facades\DataTables;

class ResourcesController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('resource_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            if (!auth()->user()->is_pres) {
                $query = Resource::with(['created_by'])
                    ->withTrashed()
                    ->orderByRaw('CASE WHEN deleted_at IS NULL THEN 1 ELSE 2 END');
            } 
            else{
                $query = Resource::with(['created_by'])->select(sprintf('%s.*', (new Resource)->table));

            }

            // $query = Resource::with(['created_by'])->select(sprintf('%s.*', (new Resource)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'resource_show';
                $editGate      = 'resource_edit';
                $deleteGate    = 'resource_delete';
                $crudRoutePart = 'resources';

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
            $table->editColumn('file', function ($row) {
                return $row->file ? '<a href="' . asset($row->file->getUrl()) . '" target="_blank">' . trans('global.view_file') . '</a>' : '';
            });
            
            $table->editColumn('is_published', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->is_published ? 'checked' : null) . '>';
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

            $table->rawColumns(['actions', 'placeholder', 'file', 'is_published', 'created_by']);

            return $table->make(true);
        }

        $users = User::get();

        return view('admin.resources.index', compact('users'));
    }

    public function create()
    {
        abort_if(Gate::denies('resource_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $created_bies = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.resources.create', compact('created_bies'));
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

        return redirect()->route('admin.resources.index');
    }

    public function edit(Resource $resource)
    {
        abort_if(Gate::denies('resource_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $created_bies = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $resource->load('created_by');

        return view('admin.resources.edit', compact('created_bies', 'resource'));
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

        // return redirect()->route('admin.resources.index');
        return redirect()->route('admin.resources.show', $resource)->with(['success' => true, 'message' => 'Resource updated successfully.']);
    }

    public function show($id)
    {
        abort_if(Gate::denies('resource_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $resource = Resource::withTrashed()->where('id',$id)->first();
        $resource->load('created_by');

        return view('admin.resources.show', compact('resource'));
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
    public function restore($id,$action){
        $resource = Resource::withTrashed()->where('id',$id)->first();

        if($action == 'restore')
            $resource->deleted_at = null;
        else if($action == 'delete')
            $resource->deleted_at = now();
            $resource->save();
            return back();

    }
}