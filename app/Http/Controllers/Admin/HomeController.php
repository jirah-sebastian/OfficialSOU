<?php

namespace App\Http\Controllers\Admin;

use App\Models\{User, Activity, Announcement, Resource, SoRegistration, SoList};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function __construct()
    {
        //this->middleware('redirectIfNotSet');
    }

    public function index()
    {
        $so_list = auth()->user()->createdBySoLists;

        if (auth()->user()->is_pres) {
            $so_list = auth()->user()->createdBySoLists;
            if ($so_list->where('approved', 'Approved')->count() == 0) {
                // Redirect president to student organization profile menu
                if ($so_list->where('approved', 'Pending')->count() == 1) {
                    return redirect(route('admin.so-lists.show', $so_list[0]->id));
                }
                return redirect(route('admin.so-lists.create'));
            }
        }

        // Get user's organization name if they are president or have role ID 3
        $userOrganizationName = null;
        if (auth()->user()->is_pres) {
            // Retrieve the latest SO list created by the user
            $latestSoList = auth()->user()->createdBySoLists()->latest()->first();
            // Check if a SO list exists
            if ($latestSoList) {
                $userOrganizationName = $latestSoList->so_name;
            }
        }

        // Fetch user data and count statuses
        $totalUsers = User::count();
        $pendingUsers = User::where('approved', 'Pending')->count();
        $approvedUsers = User::where('approved', 'Approved')->count();
        $rejectedUsers = User::where('approved', 'Rejected')->count();
        $archivedUsers = User::onlyTrashed()->count();

        // Fetch user data and count statuses
        $totalSo = SoList::count();
        $pendingSo = SoList::where('approved', 'Pending')->count();
        $approvedSo = SoList::where('approved', 'Approved')->count();
        $rejectedSo = SoList::where('approved', 'Rejected')->count();
        $archivedSo = SoList::onlyTrashed()->count();

         // Fetch user data and count statuses
         $totalActivity =  Activity::count();
         $pendingActivity = Activity::where('status', 'Pending')->count();
         $approvedActivity = Activity::where('status', 'Approved')->count();
         $rejectedActivity = Activity::where('status', 'Rejected')->count();
         $archivedActivity = Activity::onlyTrashed()->count();


        $users = User::all();
        $activities = Activity::all();
        $announcement = Announcement::all();
        $resources = Resource::all();
        $so = SoList::where('created_by_id', auth()->id())->first();
        $so_count = SoList::all();
        $so_registration = SoRegistration::where('so_list_id', $so->id ?? '')->get();
        $pres_count = User::whereHas('roles', function ($query) {
            $query->where('id', 3);
        })->get();
        $userName = auth()->user()->name;

        return view('home', compact(
            'users',
            'activities',
            'announcement',
            'resources',
            'so_registration',
            'pres_count',
            'so_count',
            'userName',
            'userOrganizationName',
            'totalUsers',
            'pendingUsers',
            'approvedUsers',
            'rejectedUsers',
            'archivedUsers',
            'totalSo',
            'pendingSo',
            'approvedSo',
            'rejectedSo',
            'archivedSo',
            'totalActivity',
            'pendingActivity',
            'approvedActivity',
            'rejectedActivity',
            'archivedActivity'
        ));
    }
}
