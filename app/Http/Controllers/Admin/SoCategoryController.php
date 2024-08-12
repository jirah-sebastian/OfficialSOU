<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySoCategoryRequest;
use App\Http\Requests\StoreSoCategoryRequest;
use App\Http\Requests\UpdateSoCategoryRequest;
use App\Models\SoCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\Eloquent\SoftDeletes;

class SoCategoryController extends Controller
{


    public function index()
    {
        abort_if(Gate::denies('so_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $soCategories = SoCategory::withTrashed()->get();

        return view('admin.soCategories.index', compact('soCategories'));
    }


    public function create()
    {
        abort_if(Gate::denies('so_category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.soCategories.create');
    }

    public function store(StoreSoCategoryRequest $request)
    {
        $soCategory = SoCategory::create($request->all());

        return redirect()->route('admin.so-categories.index');
    }

    public function edit(SoCategory $soCategory)
    {
        abort_if(Gate::denies('so_category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.soCategories.edit', compact('soCategory'));
    }

    public function update(UpdateSoCategoryRequest $request, SoCategory $soCategory)
    {
        $soCategory->update($request->all());

        return redirect()->route('admin.so-categories.index');
    }

    public function show($id)
    {
        $soCategory = SoCategory::withTrashed()->findOrFail($id);
    
        abort_if(Gate::denies('so_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    
        return view('admin.soCategories.show', compact('soCategory'));
    }
    
    
    
    public function destroy(SoCategory $soCategory)
    {
        abort_if(Gate::denies('so_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $soCategory->delete();

        return back();
    }

    public function massDestroy(MassDestroySoCategoryRequest $request)
    {
        $soCategories = SoCategory::find(request('ids'));

        foreach ($soCategories as $soCategory) {
            $soCategory->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    // public function restore(SoCategory $soCategory)
    // {
    //     $soCategory->restore();

    //     return back()->with('success', 'Category restored successfully');
    // }


    public function restore($id)
    {
        $soCategory = SoCategory::withTrashed()->findOrFail($id);
    
        if ($soCategory->trashed()) {
            $soCategory->deleted_at = null; // Restoring the category
        } else {
            $soCategory->deleted_at = now(); // Soft-deleting the category
        }
    
        $soCategory->save(); // Save changes
    
        return back()->with('success', 'SO Category updated successfully');
    }
}    
