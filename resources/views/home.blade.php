@extends('layouts.admin')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    @if (auth()->user()->is_pres)
                        <div class="card-header text-white" style="font-size: 24px; background-color: #005600">
                            <strong>WELCOME, <span style="color: gold;">{{ strtoupper($userName) }}</span> OF
                                <span style="color: gold;">{{ strtoupper($userOrganizationName) }}</span>!</strong>
                        </div>
                    @else
                        <div class="card-header text-white" style="font-size: 24px; background-color: darkgreen">
                            <strong>Welcome, <span style="color: gold;">{{ strtoupper($userName) }}</span>!</strong>
                        </div>
                    @endif

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="row">
                            @if (!auth()->user()->is_pres)
                                <div class="col-lg-4 col-md-6">
                                    <div class="small-box bg-info">
                                        <div class="inner">
                                            @php
                                                $presidentsAndAdmins = $users->filter(function ($user) {
                                                    return $user->roles->pluck('id')->contains(2) ||
                                                        $user->roles->pluck('id')->contains(3);
                                                });
                                            @endphp

                                            <h3>{{ $presidentsAndAdmins->count() }}</h3>


                                            <p style="font-weight: bold; font-size: 1.3em;">Users</p>
                                            <p style="font-weight: bold; font-size: 1.1em; margin: 0;">
                                                <span class="badge badge-warning">Pending: {{ $pendingUsers }}</span>
                                                <span class="badge badge-success">Approved: {{ $approvedUsers }}</span>
                                                {{-- <span class="badge badge-danger">Rejected: {{ $rejectedUsers }}</span> --}}
                                                <span class="badge badge-dark">Archived: {{ $archivedUsers }}</span>
                                                @php
                                                    $soAdministrators = $users->filter(function ($user) {
                                                        return $user->roles->pluck('id')->contains(2);
                                                    });
                                                @endphp

                                                <span class="badge badge-light">SO Administrators:
                                                    {{ $soAdministrators->count() }}</span>

                                            </p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-users"></i>
                                        </div>
                                        <a href="/admin/users" class="small-box-footer"
                                            style="margin-top: 0; display: block;">
                                            More info <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                            @endif

                            @if (!auth()->user()->is_pres)
                                <div class="col-lg-4 col-md-6">
                                    <div class="small-box bg-secondary">
                                        <div class="inner">
                                            <h3>{{ \App\Models\SoList::withTrashed()->count() }}</h3>
                                            <p style="font-weight: bold; font-size: 1.3em;">Student Organizations</p>
                                            <p style="font-weight: bold; font-size: 1.1em; margin: 0;">
                                                <span class="badge badge-warning">Pending: {{ $pendingSo }}</span>
                                                <span class="badge badge-success">Approved: {{ $approvedSo }}</span>
                                                <span class="badge badge-danger">Rejected: {{ $rejectedSo }}</span>
                                                <span class="badge badge-dark">Archived: {{ $archivedSo }}</span>
                                            </p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-university"></i>
                                        </div>
                                        <a href="{{ route('admin.so-lists.index') }} " class="small-box-footer">
                                            More info <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                            @endif

                            @if (auth()->user()->is_pres)
                                <div class="col-lg-3 col-6">
                                @else
                                    <div class="col-lg-4 col-md-6">
                            @endif
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    @if (auth()->user()->is_pres)
                                        <h3>{{ $activities->where('created_by_id', auth()->id())->count() }}</h3>
                                        <p style="font-weight: bold; font-size: 1.3em;">Activities</p>
                                    @else
                                    <h3>{{ \App\Models\Activity::withTrashed()->count() }}</h3>

                                        <p style="font-weight: bold; font-size: 1.3em;">Activities</p>
                                        <p style="font-weight: bold; font-size: 1.1em; margin: 0;">
                                            <span class="badge badge-warning">Pending: {{ $pendingActivity }}</span>
                                            <span class="badge badge-success">Approved: {{ $approvedActivity }}</span>
                                            <span class="badge badge-danger">Rejected: {{ $rejectedActivity }}</span>
                                            <span class="badge badge-dark">Archived: {{ $archivedActivity }}</span>
                                        </p>
                                    @endif


                                </div>
                                <div class="icon">
                                    <i class="fas fa-tasks"></i>
                                </div>
                                <a href="/admin/activities" class="small-box-footer">
                                    More info <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>


                        </div>
                        @if (auth()->user()->is_pres)
                            @php
                                $solist = App\Models\SoList::where('created_by_id', auth()->id())->first();
                                $soreg = App\Models\SoRegistration::where('so_list_id', $solist ?? 0)->get();
                            @endphp
                            <div class="col-lg-3 col-6">

                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <h3>{{ $so_registration->count() }}</h3>
                                        <p style="font-weight: bold; font-size: 1.3em;">Members</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <a href="{{ route('admin.so-registrations.index') }}" class="small-box-footer">
                                        More info <i class="fas fa-arrow-circle-right"></i>
                                    </a>
                                </div>
                            </div>
                        @endif

                        @if (!auth()->user()->is_pres)
                            <div class="col-lg-4 col-md-6">
                                <div class="small-box bg-success">
                                    <div class="inner">
                                        <h3>{{ $pres_count->count() }}</h3>
                                        <p style="font-weight: bold; font-size: 1.3em;">SO Presidents</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-user-graduate"></i>
                                    </div>
                                    <a href="{{ route('admin.users.index') }} " class="small-box-footer">
                                        More info <i class="fas fa-arrow-circle-right"></i>
                                    </a>
                                </div>
                            </div>
                        @endif
                        @if (auth()->user()->is_pres)
                            <div class="col-lg-3 col-6">
                            @else
                                <div class="col-lg-4 col-md-6">
                        @endif
                        <div class="small-box bg-warning">
                            <div class="inner" style="color:white;">
                                <h3>{{ $announcement->count() }}</h3>
                                <p style="font-weight: bold; font-size: 1.290em;">Announcements</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-bullhorn"></i>
                            </div>
                            <a href="/admin/announcements" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>

                    @if (auth()->user()->is_pres)
                        <div class="col-lg-3 col-6">
                        @else
                            <div class="col-lg-4 col-md-6">
                    @endif
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $resources->count() }}</h3>
                            <p style="font-weight: bold; font-size: 1.3em;">Resources</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-download"></i>
                        </div>
                        <a href="/admin/resources" class="small-box-footer">
                            More info <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>




                {{-- @if (!auth()->user()->is_pres)
                    <div class="col-lg-2 col-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $so_categories->count() }}</h3>
                                <p>Total SO Categories</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-download"></i>
                            </div>
                            <a href="/admin/so-categories" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                @endif --}}
            </div>
        </div>

    </div>
    </div>
    </div>
    </div>
    </div>
@endsection

@section('scripts')
    @parent
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
@endsection
