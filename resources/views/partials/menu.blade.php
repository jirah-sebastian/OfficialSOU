<aside class="main-sidebar elevation-4 sidebar-light-success" style="min-height: 917px;">
    <!-- Brand Logo -->
    {{-- <a href="{{route('admin.home')}}" class="brand-link bg-warning text-center">
        <span class="brand-text text-bold ">CDO CIS</span>
    </a> --}}
    <a href="#" class="brand-link text-center text-white" style="background-color: #005600">
        <img src="{{ asset('logo-white.png') }}" alt="Logo" class="brand-logo" style="height: 40px; width: auto;">
        <span class="brand-text text-bold">{{ trans('panel.site_title') }}</span>
    </a>

    <hr class="dropdown-divider" style="border-color: gold; border-width: 2px; margin: 0; padding: 0; color: gold;">
    <!-- Sidebar -->
    <div class="sidebar" style="background-color: #005600">
        <!-- Sidebar user (optional) -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-child-indent" data-widget="treeview"
                role="menu" data-accordion="false">

                @php
                    $userName = auth()->user()->name;
                    $userProfileImage = auth()->user()->getFirstMediaUrl('profile');
                @endphp

                @if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
                    @can('profile_password_edit')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'active' : '' }}"
                                href="{{ route('profile.password.edit') }}">
                                <img src="{{ $userProfileImage }}" alt="Profile Picture" width="40" height="40"
                                    style="border-radius: 50%;">
                                <p class="text-white">{{ $userName }}</p>
                            </a>
                        </li>
                        {{-- Divider --}}
                        <li class="nav-item" style="margin-top: -5px;"> <!-- Adjust margin-top -->
                            <hr class="dropdown-divider" style="border-color: gold; margin: 5; padding: 0;">
                            <!-- Adjust margin and padding -->
                        </li>
                    @endcan
                @endif

                @php
                    $soListExists =
                        auth()->user()->is_pres &&
                        \App\Models\SoList::where('created_by_id', auth()->id())
                            ->where('approved', 'Approved')
                            ->exists();
                @endphp

                {{-- Check if the user is president and has created an SO list --}}
                @if ($soListExists || !auth()->user()->is_pres)
                    {{-- If SO list exists, show the regular Dashboard link --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.home') ? 'active' : '' }}"
                            href="{{ route('admin.home') }}">
                            <i class="fas fa-fw fa-tachometer-alt nav-icon text-white"></i>
                            <p class="text-white">{{ trans('global.dashboard') }}</p>
                        </a>
                    </li>
                @else
                    @php
                        $soListPending = \App\Models\SoList::where('created_by_id', auth()->id())
                            ->where('approved', 'Pending')
                            ->exists();
                        $rejectedSO = \App\Models\SoList::where('created_by_id', auth()->id())
                            ->where('approved', 'Reject')
                            ->exists();
                    @endphp

                    @if ($soListPending)
                        {{-- If no SO list exists and user is not admin, redirect to SO profile --}}
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.home') }}"
                                href="{{ route('admin.so-lists.index') }}">
                                <i class="fas fa-fw fa-tachometer-alt nav-icon text-white"></i>
                                <p class="text-white">{{ trans('global.dashboard') }}</p>
                            </a>
                        </li>
                    @elseif ($rejectedSO)
                        {{-- If SO list exists and is rejected, redirect to create SO list --}}
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.home') }}"
                                href="{{ route('admin.so-lists.create') }}">
                                <i class="fas fa-fw fa-tachometer-alt nav-icon text-white"></i>
                                <p class="text-white">{{ trans('global.dashboard') }}</p>
                            </a>
                        </li>
                    @else
                        {{-- If no SO list exists, redirect to create SO list --}}
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.home') }}"
                                href="{{ route('admin.so-lists.create') }}">
                                <i class="fas fa-fw fa-tachometer-alt nav-icon text-white"></i>
                                <p class="text-white">{{ trans('global.dashboard') }}</p>
                            </a>
                        </li>
                    @endif
                @endif

                {{-- @if (auth()->check() && !auth()->user()->is_pres && !auth()->user()->roles->contains('id', 1) && !auth()->user()->roles->contains('id', 3)) --}}
                @if (!auth()->user()->is_pres && !auth()->user()->roles->contains('id', 1))
                    <li class="nav-item">
                        <a href="{{ route('admin.users.index') }}"
                            class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                            <i class="fas fa-fw fa-users nav-icon text-white"></i>
                            </i>
                            <p class="text-white">
                                Users
                            </p>
                        </a>
                    </li>
                    {{-- @endif --}}
                @endif

                {{-- @can('so_list_access')
                    @php
                        $rejectedApplication = \App\Models\SoList::where('created_by_id', auth()->id())
                            ->where('approved', 'Rejected')
                            ->exists();
                        $approvedApplication = \App\Models\SoList::where('created_by_id', auth()->id())
                            ->whereIn('approved', ['Approved', 'Pending'])
                            ->exists();
                        $hasNoSoList = !($rejectedApplication || $approvedApplication);
                    @endphp --}}

                {{-- Check if the application is rejected, approved/pending, or has no SO list --}}
                {{-- @if ($rejectedApplication || $approvedApplication || $hasNoSoList)
                        <li class="nav-item">
                            <a href="{{ $rejectedApplication ? route('admin.so-lists.create') : route('admin.so-lists.index') }}"
                                class="nav-link {{ request()->is('admin/so-lists') || request()->is('admin/so-lists/*') ? 'active' : '' }}">
                                <i class="fas fa-fw fa-university nav-icon"></i>
                                <p>
                                    @if (auth()->user()->is_pres)
                                        SO Profile
                                    @else
                                        Student Organization
                                    @endif
                                </p>
                            </a>
                        </li>
                    @endif
                @endcan  --}}



                @can('so_list_access')
                    @if ($soListExists || !auth()->user()->is_pres)
                        {{-- If SO list exists, show the regular Dashboard link --}}
                        <li class="nav-item">
                            <a href="{{ route('admin.so-lists.index') }}"
                                class="nav-link {{ request()->is('admin/so-lists') || request()->is('admin/so-lists/*') ? 'active' : '' }}">
                                <i class="fas fa-fw fa-university nav-icon text-white"></i>
                                <p class="text-white">
                                    @if (auth()->user()->is_pres)
                                        SO Profile
                                    @else
                                        Student Organizations
                                    @endif
                                </p>
                            </a>
                        </li>
                    @else
                        @php
                            $soListPending = \App\Models\SoList::where('created_by_id', auth()->id())
                                ->where('approved', 'Pending')
                                ->exists();
                            $rejectedSO = \App\Models\SoList::where('created_by_id', auth()->id())
                                ->where('approved', 'Reject')
                                ->exists();
                        @endphp


                        @if ($soListPending)
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('admin/so-lists/*') ? 'active' : '' }} "
                                    href="{{ route('admin.so-lists.index') }}">
                                    <i class="fas fa-fw fa-university nav-icon text-white"></i>
                                    <p class="text-white">SO Profile</p>
                                </a>
                            </li>
                        @elseif ($rejectedSO)
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('admin/so-lists/*') ? 'active' : '' }}"
                                    href="{{ route('admin.so-lists.create') }}">
                                    <i class="fas fa-fw fa-university nav-icon text-white"></i>
                                    <p class="text-white">SO Profile</p>
                                </a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('admin/so-lists/*') ? 'active' : '' }}"
                                    href="{{ route('admin.so-lists.create') }}">
                                    <i class="fas fa-fw fa-university nav-icon text-white"></i>
                                    <p class="text-white">SO Profile</p>
                                </a>
                            </li>
                        @endif
                    @endif
                @endcan



                @can('user_management_access')
                    <li
                        class="nav-item has-treeview {{ request()->is('admin/permissions*') ? 'menu-open' : '' }} {{ request()->is('admin/roles*') ? 'menu-open' : '' }} {{ request()->is('admin/users*') ? 'menu-open' : '' }} {{ request()->is('admin/audit-logs*') ? 'menu-open' : '' }}">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is('admin/permissions*') ? 'active' : '' }} {{ request()->is('admin/roles*') ? 'active' : '' }} {{ request()->is('admin/users*') ? 'active' : '' }} {{ request()->is('admin/audit-logs*') ? 'active' : '' }}"
                            href="#">
                            <i class="fa-fw nav-icon fas fa-users text-white">

                            </i>
                            <p class="text-white">
                                {{ trans('cruds.userManagement.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon text-white"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('permission_access')
                                <li class="nav-item">
                                    <a href="{{ route('admin.permissions.index') }}"
                                        class="nav-link {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }}">
                                        <i class="fa-fw nav-icon fas fa-unlock-alt text-white">

                                        </i>
                                        <p class="text-white">
                                            {{ trans('cruds.permission.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('role_access')
                                <li class="nav-item">
                                    <a href="{{ route('admin.roles.index') }}"
                                        class="nav-link {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">
                                        <i class="fa-fw nav-icon fas fa-briefcase text-white">

                                        </i>
                                        <p class="text-white">
                                            {{ trans('cruds.role.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('user_access')
                                <li class="nav-item">
                                    <a href="{{ route('admin.users.index') }}"
                                        class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                                        <i class="fa-fw nav-icon fas fa-user text-white">

                                        </i>
                                        <p class="text-white">
                                            {{ trans('cruds.user.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('audit_log_access')
                                <li class="nav-item">
                                    <a href="{{ route('admin.audit-logs.index') }}"
                                        class="nav-link {{ request()->is('admin/audit-logs') || request()->is('admin/audit-logs/*') ? 'active' : '' }}">
                                        <i class="fa-fw nav-icon fas fa-file-alt text-white">

                                        </i>
                                        <p class="text-white">
                                            {{ trans('cruds.auditLog.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                @can('activity_access')
                    @if ($soListExists || !auth()->user()->is_pres)
                        <li class="nav-item">
                            <a href="{{ route('admin.activities.index') }}"
                                class="nav-link {{ request()->is('admin/activities') || request()->is('admin/activities/*') ? 'active' : '' }}">
                                <i class="fa-fw nav-icon fas fa-calendar-alt text-white"></i>
                                <p class="text-white">{{ trans('cruds.activity.title_plural') }}</p>
                            </a>
                        </li>
                    @else
                        @php
                            $soListPending = \App\Models\SoList::where('created_by_id', auth()->id())
                                ->where('approved', 'Pending')
                                ->exists();
                            $rejectedSO = \App\Models\SoList::where('created_by_id', auth()->id())
                                ->where('approved', 'Reject')
                                ->exists();
                        @endphp

                        @if ($soListPending)
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.home') }}"
                                    href="{{ route('admin.so-lists.index') }}">
                                    <i class="fa-fw nav-icon fas fa-calendar-alt text-white"></i>
                                    <p class="text-white">{{ trans('cruds.activity.title_plural') }}</p>
                                </a>
                            </li>
                        @elseif ($rejectedSO)
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.home') }}"
                                    href="{{ route('admin.so-lists.create') }}">
                                    <i class="fa-fw nav-icon fas fa-calendar-alt text-white"></i>
                                    <p class="text-white">{{ trans('cruds.activity.title_plural') }}</p>
                                </a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.home') }}"
                                    href="{{ route('admin.so-lists.create') }}">
                                    <i class="fa-fw nav-icon fas fa-calendar-alt text-white"></i>
                                    <p class="text-white">{{ trans('cruds.activity.title_plural') }}</p>
                                </a>
                            </li>
                        @endif
                    @endif
                @endcan



                @can('announcement_access')
                    @if ($soListExists || !auth()->user()->is_pres)
                        <li class="nav-item">
                            <a href="{{ route('admin.announcements.index') }}"
                                class="nav-link {{ request()->is('admin/announcements') || request()->is('admin/announcements/*') ? 'active' : '' }}">
                                <i class="fa-fw nav-icon fas fa-bullhorn text-white"></i>
                                <p class="text-white">{{ trans('cruds.announcement.title_plural') }}</p>
                            </a>
                        </li>
                    @else
                        @php
                            $soListPending = \App\Models\SoList::where('created_by_id', auth()->id())
                                ->where('approved', 'Pending')
                                ->exists();
                            $rejectedSO = \App\Models\SoList::where('created_by_id', auth()->id())
                                ->where('approved', 'Reject')
                                ->exists();
                        @endphp

                        @if ($soListPending)
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.home') }}"
                                    href="{{ route('admin.so-lists.index') }}">
                                    <i class="fa-fw nav-icon fas fa-bullhorn text-white"></i>
                                    <p class="text-white">{{ trans('cruds.announcement.title_plural') }}</p>
                                </a>
                            </li>
                        @elseif ($rejectedSO)
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.home') }}"
                                    href="{{ route('admin.so-lists.create') }}">
                                    <i class="fa-fw nav-icon fas fa-bullhorn text-white"></i>
                                    <p class="text-white">{{ trans('cruds.announcement.title_plural') }}</p>s
                                </a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.home') }}"
                                    href="{{ route('admin.so-lists.create') }}">
                                    <i class="fa-fw nav-icon fas fa-bullhorn text-white"></i>
                                    <p class="text-white">{{ trans('cruds.announcement.title_plural') }}</p>
                                </a>
                            </li>
                        @endif
                    @endif
                @endcan

                @can('resource_access')
                    @if ($soListExists || !auth()->user()->is_pres)
                        <li class="nav-item">
                            <a href="{{ route('admin.resources.index') }}"
                                class="nav-link {{ request()->is('admin/resources') || request()->is('admin/resources/*') ? 'active' : '' }}">
                                <i class="fa-fw nav-icon fas fa-file-download text-white"></i>
                                <p class="text-white">{{ trans('cruds.resource.title') }}</p>
                            </a>
                        </li>
                    @else
                        @php
                            $soListPending = \App\Models\SoList::where('created_by_id', auth()->id())
                                ->where('approved', 'Pending')
                                ->exists();
                            $rejectedSO = \App\Models\SoList::where('created_by_id', auth()->id())
                                ->where('approved', 'Reject')
                                ->exists();
                        @endphp

                        @if ($soListPending)
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.home') }}"
                                    href="{{ route('admin.so-lists.index') }}">
                                    <i class="fa-fw nav-icon fas fa-file-download text-white"></i>
                                    <p class="text-white">{{ trans('cruds.resource.title') }}</p>
                                </a>
                            </li>
                        @elseif ($rejectedSO)
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.home') }}"
                                    href="{{ route('admin.so-lists.create') }}">
                                    <i class="fa-fw nav-icon fas fa-file-download text-white"></i>
                                    <p class="text-white">{{ trans('cruds.resource.title') }}</p>
                                </a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.home') }}"
                                    href="{{ route('admin.so-lists.create') }}">
                                    <i class="fa-fw nav-icon fas fa-file-download text-white"></i>
                                    <p class="text-white">{{ trans('cruds.resource.title') }}</p>
                                </a>
                            </li>
                        @endif
                    @endif
                @endcan

                @can('so_category_access')
                    <li class="nav-item">
                        <a href="{{ route('admin.so-categories.index') }}"
                            class="nav-link {{ request()->is('admin/so-categories') || request()->is('admin/so-categories/*') ? 'active' : '' }}">
                            <i class="fa-fw nav-icon fas fa-bezier-curve text-white">

                            </i>
                            <p class="text-white">
                                {{ trans('cruds.soCategory.title_plural') }}
                            </p>
                        </a>
                    </li>
                @endcan

                @can('so_registration_access')
                    @if ($soListExists)
                        <li class="nav-item">
                            <a href="{{ route('admin.so-registrations.index') }}"
                                class="nav-link {{ request()->is('admin/so-registrations') || request()->is('admin/so-registrations/*') ? 'active' : '' }}">
                                <i class="fa-fw nav-icon fas fa-user-plus text-white"></i>
                                <p class="text-white">SO Members</p>
                            </a>
                        </li>
                    @elseif (
                        \App\Models\SoList::where('created_by_id', auth()->id())->where('approved', 'Pending')->exists() &&
                            !auth()->user()->roles->contains('id', 2) &&
                            !auth()->user()->roles->contains('id', 1))
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.home') }}"
                                href="{{ route('admin.so-lists.index') }}">
                                <i class="fa-fw nav-icon fas fa-user-plus text-white"></i>
                                <p class="text-white">SO Members</p>
                            </a>
                        </li>
                        {{-- @elseif (!auth()->user()->is_pres)
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/so-registrations*') ? 'active' : '' }}"
                            href="{{ route('admin.so-registrations.index') }}">
                            <i class="fa-fw nav-icon fas fa-user-plus"></i>
                            <p>SO Members</p>
                        </a>
                    </li>
                     --}}
                    @else
                        @if (!auth()->user()->roles->contains('id', 2) && !auth()->user()->roles->contains('id', 1))
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.home') }}"
                                    href="{{ route('admin.so-lists.create') }}">
                                    <i class="fa-fw nav-icon fas fa-user-plus text-white"></i>
                                    <p class="text-white">SO Members</p>
                                </a>
                            </li>
                        @endif
                    @endcan
                @endif
                @can('about_access')
                    <li class="nav-item">
                        <a href="{{ route('admin.abouts.index') }}"
                            class="nav-link {{ request()->is('admin/abouts') || request()->is('admin/abouts/*') ? 'active' : '' }}">
                            <i class="fa-fw nav-icon fas fa-question-circle text-white">

                            </i>
                            <p class="text-white">
                                {{ trans('cruds.about.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                {{-- @can('title_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.titles.index") }}" class="nav-link {{ request()->is("admin/titles") || request()->is("admin/titles/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-bookmark">

                            </i>
                            <p>
                                {{ trans('cruds.title.title') }}
                            </p>
                        </a>
                    </li>
                @endcan --}}
                {{-- @can('organization_application_form_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.organization-application-forms.index") }}" class="nav-link {{ request()->is("admin/organization-application-forms") || request()->is("admin/organization-application-forms/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-file-alt">

                            </i>
                            <p>
                                {{ trans('cruds.organizationApplicationForm.title') }}
                            </p>
                        </a>
                    </li>
                @endcan --}}

                <li class="nav-item">
                    <a href="#" class="nav-link"
                        onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                        <p>
                            <i class="fas fa-fw fa-sign-out-alt nav-icon text-white">

                            </i>
                            <p class="text-white">{{ trans('global.logout') }}</p>
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

<style>
    .nav-link:hover {
        background-color: #218838 !important;
        /* Change the color on hover */
    }
</style>
