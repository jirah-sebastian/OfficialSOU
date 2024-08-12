<?php

namespace App\Http\Controllers\Sois;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{SoCategory, SoList,Title};
class StudentOrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $soCategories = SoCategory::all();

        if(!request()->category)
            $selected = SoCategory::first()->id ?? null;
        else
            $selected = request()->category;
            $soLists = SoList::where('so_category_id', $selected)
            ->where('approved', 'Approved')
            ->get();
        
        return view('sois.studentOrganizations.index',compact('soCategories','soLists','selected'));
    }

    public function apply($id){
        $so_lists = SoList::where('id',$id)->pluck('so_name', 'id');

        $titles = Title::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('sois.studentOrganizations.apply',compact('so_lists','titles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
