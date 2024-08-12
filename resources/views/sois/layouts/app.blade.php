<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Student Organization Unit</title>
    <link rel="icon" href="/logo.ico" type="image/x-icon">
    <!-- insert all link and scripts resources -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css"
        rel="stylesheet" />

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap/bootstrap.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- slider sky blue theme -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/splide/themes/splide-skyblue.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/page.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/media.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css"
        integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />
    @yield('styles')
</head>

<body style="@if (request()->is('sois')) background-color:white; @endif">

    <div class="header">
        <!-- top -->
        <div class="top-header">
            <div class="container-fluid">
                <div class="row d-flex justify-content-between align-items-center">
                    <div
                        class="top-header-left col-xl-6 col-md-6 col-xs-6 flex-row dp-xs-flex justify-content-between align-items-center">
                        <div class="email d-inline-block">
                            <i class="fas fa-envelope"></i><span class="mr-xs-0"> osa@clsu.edu.ph</span>
                        </div>
                        {{-- <div class="phone d-inline-block">
							<i class="fa fa-phone"></i><span class="mr-xs-0"> +6344 456 0688</span>
						</div> --}}
                    </div>

                    <div class="top-header-right col-xl-5 col-md-5 col-xs-5">
                        <a target="_blank" href="https://www.facebook.com/officeofstudentaffairsCLSU"><i
                                class="fab fa-facebook-f"></i></a>
                        {{-- <a target="_blank" href="https://twitter.com/clsu_official"><i class="fab fa-twitter"></i></a>
						<a target="_blank" href="https://www.instagram.com/clsu.official/"><i
								class="fab fa-instagram"></i></a>
						<a target="_blank"
							href="https://www.linkedin.com/in/central-luzon-state-university-147945153/"><i
								class="fab fa-linkedin-in"></i></a> --}}
                        <a target="_blank" href="https://www.youtube.com/@clsuosa5616"><i
                                class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
            <div class="top-header-ham">
                <img src="{{ asset('assets/img/icons/general/ham-icon.png') }}">
            </div>
        </div>

        <!-- middle -->
        <div class="logo-header">
            <div class="container-fluid">
                <div class="row d-flex justify-content-between">
                    <div class="logo-header-left col-xl-7 col-md-7 col-xs-7 dp-xs-flex flex-row">
                        <div class="logo mr-xs-3">
                            <a href="{{ url('/') }}">
                                <img src="{{ asset('assets/img/sou/logo-white.png') }}" alt="Logo">
                                {{-- <img src="{{ asset('assets/img/sou/logo-white.png') }}" alt="Logo" style="width: 100px; height: auto;"> --}}
                            </a>
                        </div>

                        <div class="logo-text m-xs-0">
                            <span class="logo-title">STUDENT ORGANIZATIONS UNIT</span>
                            <span class="logo-sub">Office of Student Affairs-Central Luzon State University</span>
                            {{-- <span class="logo-sub">Science City of Muñoz, Nueva Ecija, Philippines 3120</span> --}}
                        </div>
                    </div>

                    <div class="logo-header-right col-xl-5 col-md-5 col-xs-5">
                        <div class="logo-links">
                            <!-- <a href="http://ggc.clsu.edu.ph/" target="_blank">Login</a>
       <a href="about-us/au-contact-us.php">Register</a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- bottom -->
        <div class="mobile-header text-white d-none dp-xs-block">
            <div class="container-fluid">
                <div class="row">
                    <!-- Mobile Menu -->
                    <div
                        class="mobile-header-canvas bg-green-grad dp-xs-flex flex-row justify-content-between align-items-center py-2 px-4">
                        <div id="mobile-header-title" class="mt-1">
                            <span class="navbar-title heading" href="#"></span>
                        </div>

                        <!-- Ham Icon -->
                        <div id="hamburger-menu-icon">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="main-header bg-green-grad dp-xs-none">
            <div class="container-fluid">
                {{-- <div class="row">
                    <!-- Main Header -->
                    <nav class="navbar main-header-mid navbar-expand-md">
                        <div class="main-header-links collapse navbar-collapse" id="navbarNavDropdown">
                            <ul class="navbar-nav">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="about-us">HOME</a>
                                    <div class="drop-wrapper">
                                        <ul class="dropdown-menu">

                                        </ul>
                                    </div>
                                </li>

                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="about-us">ABOUT US</a>
                                    <div class="drop-wrapper">
                                        <ul class="dropdown-menu">

                                        </ul>
                                    </div>
                                </li>

                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="academic-affairs">IMPU</a>
                                    <div class="drop-wrapper">
                                        <ul class="dropdown-menu">

                                        </ul>
                                    </div>
                                </li>

                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="research-and-extension">CDESU</a>
                                    <div class="drop-wrapper">
                                        <ul class="dropdown-menu">

                                        </ul>
                                    </div>
                                </li>

                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="business-affairs">GSU</a>
                                    <div class="drop-wrapper">
                                        <ul class="dropdown-menu">

                                        </ul>
                                    </div>
                                </li>

                                <li class="nav-item dropdown">
                                    <a id="sou-link" class="nav-link dropdown-toggle active"
                                        href="{{ route('sois.index') }}">SOU</a>
                                    <div class="drop-wrapper">
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="{{ route('login') }}">Login</a></li>
                                            <li><a class="dropdown-item" href="{{ route('register') }}">REGISTER</a>
                                            </li>
                                            <li><a class="dropdown-item" href="{{ route('sois.index') }}">ABOUT
                                                    US</a></li>
                                            <li><a class="dropdown-item"
                                                    href="{{ route('sois.activities.index') }}">ACTIVITIES</a></li>
                                            <li><a class="dropdown-item"
                                                    href="{{ route('sois.announcements.index') }}">ANNOUNCEMENT</a>
                                            </li>
                                            @auth
                                                <li><a class="dropdown-item"
                                                        href="{{ route('sois.resources.index') }}">RESOURCES</a></li>
                                            @endauth
                                            <li><a class="dropdown-item"
                                                    href="{{ route('sois.student-organizations.index') }}">RECOGNIZED
                                                    SO</a></li>
                                        </ul>
                                    </div>
                                </li>

                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="international-affairs">SDB</a>
                                    <div class="drop-wrapper">
                                        <ul class="dropdown-menu dropdown-menu-right">

                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item why-choose">
                                    <a class="nav-link" href="#">Why Choose Us?</a>
                                </li>
                                <li class="nav-item news-updates">
                                    <a class="nav-link" href="news-updates">News & Announcements</a>
                                </li>
                            </ul>
                        </div>
                    </nav> --}}
                <div class="col-xl-1 col-md-1 col-xs-1"><!-- div --></div>
            </div>
        </div>
    </div>
    </div>
    {{-- <div class="p-1 dp-xs-none" style="background-color: #f6e394;"></div> --}}
    <div class="d-flex bg-green-grad px-3 dp-xs-none" style="height:35px;">
        {{-- <div style="background-color: #f6e394; border-radius: 0 0 50% 50%;height:95px;width:335px; margin-top:-10px;" class="shadow"> --}}
        {{-- <small class="d-block text-main text-center" style="margin-top: 30px;">Central Luzon State University</small> --}}
        {{-- <p class="text-main text-center" style="margin-top: 33px; font-weight: bold; color: green; font-family: 'Cooper Black', sans-serif;">STUDENT ORGANIZATIONS UNIT</p>
        </div> --}}
        <div style="margin-left: 150px; margin-top: 5px">
            <div class="d-flex ms-3 align-self-center" style="height: 20px;">
                @if (!auth()->check())
                    <a href="{{ route('login') }}"
                        class="sub-link text-decoration-none fw-bold d-block border-end border-white pe-3 @if (Request::is('login')) active @endif"
                        style="font-size: .8rem;">LOGIN</a>
                @else
                    <a href="#"
                        class="sub-link text-decoration-none fw-bold d-block border-end border-white pe-3"
                        style="font-size: .8rem;"
                        onclick="event.preventDefault(); document.getElementById('logoutform').submit();">LOGOUT</a>
                @endif
                <a href="{{ route('sois.index') }}"
                    class="sub-link text-decoration-none fw-bold d-block border-end border-white px-3 @if (Route::currentRouteName() == 'sois.index') active @endif"
                    style="font-size: .8rem;">ABOUT</a>

                <a href="{{ route('sois.activities.index') }}"
                    class="sub-link text-decoration-none fw-bold d-block border-end border-white px-3 @if (Request::is('sois/activities*')) active @endif"
                    style="font-size: .8rem;">ACTIVITIES</a>
                <a href="{{ route('sois.announcements.index') }}"
                    class="sub-link text-decoration-none fw-bold d-block border-end border-white px-3 @if (Request::is('sois/announcements*')) active @endif"
                    style="font-size: .8rem;">ANNOUNCEMENTS</a>
                @auth
                    <a href="{{ route('sois.resources.index') }}"
                        class="sub-link text-decoration-none text-white fw-bold d-block border-end border-white px-3 @if (Request::is('sois/resources*')) active @endif"
                        style="font-size: .8rem;">RESOURCES</a>
                @endauth
                @if (auth()->check())
                    <a href="{{ route('sois.student-organizations.index') }}"
                        class="sub-link text-decoration-none fw-bold d-block border-end border-white px-3 @if (Request::is('sois/student-organizations')) active @endif"
                        style="font-size: .8rem;">RECOGNIZED SO</a>
                @else
                    <a href="{{ route('sois.student-organizations.index') }}"
                        class="sub-link text-decoration-none fw-bold d-block px-3 @if (Request::is('sois/student-organizations*')) active @endif"
                        style="font-size: .8rem;">RECOGNIZED SO</a>
                @endif

                @if (auth()->check())
                    <a href="/admin" class="text-decoration-none text-white fw-bold d-block px-3"
                        style="font-size: .8rem;">DASHBOARD</a>
                @endif
            </div>
        </div>
    </div>

    <div class="side-menu-canvas mobile dp-xs-block d-none">
        <div class="menu-section bg-black-50">
            <div class="container d-flex flex-column">
                <div class="row justify-content-center py-4 px-2">
                    <div class="col-lg-10">
                        <div class="main-menu-accordion-canvas accordion-mobile mt-xs-5">
                            {{-- <div class="accordion" id="mm-accordion">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="mm-head1">
                                        <button class="accordion-button heading" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#mm-collapse1"
                                            aria-expanded="true" aria-controls="mm-collapse1">
                                            About Us
                                        </button>
                                    </h2>
                                    <div id="mm-collapse1" class="accordion-collapse collapse show"
                                        aria-labelledby="mm-head1" data-bs-parent="#mm-accordion">
                                        <div class="accordion-body py-xs-2">
                                            <ul class="deco-none no-bullets p-xs-0">
                                                <!-- List about us  -->
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="mm-head2">
                                        <button class="accordion-button heading collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#mm-collapse2"
                                            aria-expanded="false" aria-controls="mm-collapse2">
                                            IMPU
                                        </button>
                                    </h2>
                                    <div id="mm-collapse2" class="accordion-collapse collapse"
                                        aria-labelledby="mm-head2" data-bs-parent="#mm-accordion">
                                        <div class="accordion-body py-xs-2">
                                            <ul class="deco-none no-bullets p-xs-0">
                                                <!--  -->
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="mm-head3">
                                        <button class="accordion-button heading collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#mm-collapse3"
                                            aria-expanded="false" aria-controls="mm-collapse3">
                                            CDESU
                                        </button>
                                    </h2>
                                    <div id="mm-collapse3" class="accordion-collapse collapse"
                                        aria-labelledby="mm-head3" data-bs-parent="#mm-accordion">
                                        <div class="accordion-body py-xs-2">
                                            <ul class="deco-none no-bullets p-xs-0">

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="mm-head4">
                                        <button class="accordion-button heading collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#mm-collapse4"
                                            aria-expanded="false" aria-controls="mm-collapse4">
                                            GSU
                                        </button>
                                    </h2>
                                    <div id="mm-collapse4" class="accordion-collapse collapse"
                                        aria-labelledby="mm-head4" data-bs-parent="#mm-accordion">
                                        <div class="accordion-body py-xs-2">
                                            <ul class="deco-none no-bullets p-xs-0">

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="mm-head5">
                                        <button class="accordion-button heading collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#mm-collapse5"
                                            aria-expanded="false" aria-controls="mm-collapse5">
                                            SOU
                                        </button>
                                    </h2> --}}
                            <div id="mm-collapse5" class="accordion-collapse show" aria-labelledby="mm-head5"
                                data-bs-parent="#mm-accordion">
                                <div class="accordion-body py-xs-2">
                                    <ul class="deco-none no-bullets p-xs-0">
                                        <li><a href="{{ route('login') }}"
                                                class="nav-link {{ request()->is('login') ? 'active' : '' }}">LOGIN</a>
                                        </li>
                                        <li>
                                            <a href="#" class="nav-link"
                                                onclick="event.preventDefault(); document.getElementById('logoutform').submit();"></a>
                                        </li>
                                        <li>
                                            <a href="{{ route('register') }}" class="nav-link {{ Route::currentRouteName() == 'register' ? 'active' : '' }}">REGISTER</a>
                                        </li>
                                        
                                        <li>
                                            <a href="{{ route('sois.index') }}" class="nav-link {{ Route::currentRouteName() == 'sois.index' ? 'active' : '' }}">ABOUT US</a>
                                        </li>
                                        
                                        <li><a href="{{ route('sois.activities.index') }}"
                                                class="nav-link {{ request()->is('sois/activities*') ? 'active' : '' }}">ACTIVITIES</a>
                                        </li>
                                        <li><a href="{{ route('sois.announcements.index') }}"
                                                class="nav-link {{ request()->is('sois/announcements*') ? 'active' : '' }}">ANNOUNCEMENT</a>
                                        </li>
                                        @auth
                                            <li><a href="{{ route('sois.resources.index') }}"
                                                    class="nav-link {{ request()->is('sois/resources*') ? 'active' : '' }}">RESOURCES</a>
                                            </li>
                                        @endauth
                                        <li><a href="{{ route('sois.student-organizations.index') }}"
                                                class="nav-link {{ request()->is('sois/student-organizations*') ? 'active' : '' }}">RECOGNIZED
                                                SO</a></li>
                                        @auth
                                            <li><a href="{{ route('sois.dashboard.index') }}"
                                                    class="nav-link {{ request()->is('sois.dashboard.index') ? 'active' : '' }}">RECOGNIZED
                                                    SO</a></li>
                                        @endauth
                                    </ul>
                                </div>
                            </div>

                            {{-- <div class="accordion-item">
                                    <h2 class="accordion-header" id="mm-head6">
                                        <button class="accordion-button heading collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#mm-collapse6"
                                            aria-expanded="false" aria-controls="mm-collapse6">
                                            SBD
                                        </button>
                                    </h2>
                                    <div id="mm-collapse6" class="accordion-collapse collapse"
                                        aria-labelledby="mm-head6" data-bs-parent="#mm-accordion">
                                        <div class="accordion-body py-xs-2">
                                            <ul class="deco-none no-bullets p-xs-0">

                                            </ul>
                                        </div>
                                    </div>
                                </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    @yield('content')

    <!-- footer -->
    <div class="footer">
        <div class="container-fluid">
            <!-- main footer content -->
            <div class="footer-main-cont0" style="margin-top: {{ request()->routeIs('sois.index') ? '80px' : '0' }}">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-xs-12">
                        <div class="footer-logo-wrapper text-xs-start">
                            <img class="footer-logo" src="{{ asset('assets/img/general/footer-logo-white.png') }}" alt="Footer Logo">

                        </div>
                    </div>
                </div>
            </div>
    

            <div class="row">
                <div class="footer-section d-flex flex-xs-column justify-content-between">
                    <div class="footer-item mr-5 m-xs-0">
                        <div class="footer-logo-text text-xs-start">
                            <span class="logo-title">Office of Student Affairs</span>
                            <span class="logo-sub">Central Luzon State University</span>
                            {{-- <span class="logo-sub"></span> --}}
                        </div>

                        <div class="footer-contact-info">
                            <ul class="bullets-none text-xs-start">
                                <li>
                                    <p><i class="fas fa-map-marker-alt"></i>Central Luzon State University, Science
                                        City of Muñoz Nueva Ecija, Philippines</p>
                                </li>
                                <li>

                                </li>
                                <li>

                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="footer-item dp-xs-flex mr-5">
                        <div class="footer-links">
                            <span class="footer-title">Contact</span>
                            <p><i class="fa fa-envelope"></i> <a class="email-link"
                                    href="mailto:osa@clsu.edu.ph">osa@clsu.edu.ph</a></p>
                            <p><i class="fas fa-phone"></i> (044) 940 7030</p>
                        </div>
                    </div>



                    {{-- <div class="footer-item dp-xs-none">
							<div class="footer-links">
								<span class="footer-title">Opportunities</span>
								<ul class="bullets-none">
									<li><a href="assets/files/general/List-Of-Vacant.pdf" target="_blank">Career</a>
									</li>
									<li><a href="bid-opportunities">Bid Opportunities</a></li>
								</ul>
							</div>
						</div> --}}
                    {{-- <div class="footer-item dp-xs-none mr-5">
							<div class="footer-links">
								<span class="footer-title">E-Services</span>
								<ul class="bullets-none">
									<!-- <li><a href="#">Faculty Portal</a></li>
								<li><a href="#">Student Portal</a></li> -->
									<li><a href="downloads/dl-faculty.php">Downloads</a></li>
									<li><a href="publications/pub-newsletters.php">Publications</a></li>
									<li>Knowledge Sharing & Learning Resources</li>
									<li class="sub-list">
										<ul class="bullets-dot">
											<li><a href="https://www.efarm-clsu.com/" target="_blank">eFarm</a></li>
											<li><a href="https://www.agriatm.com/" target="_blank">AgriATM</a></li>
											<li><a href="https://dotclsu.edu.ph/" target="_blank">Distance, Open, and
													Transnational University</a></li>
											<li><a href="http://iccem.projectsafe-clsu.com" target="_blank">ICCEM</a>
											</li>
											<li><a href="https://projectsafe-clsu.com" target="_blank">ProjectSAFE</a>
											</li>
										</ul>
									</li>
								</ul>
							</div>
						</div> --}}

                    {{-- <div class="footer-menu-accordion-canvas accordion-mobile my-xs-4 d-none dp-xs-block">
							<div class="accordion" id="fm-accordion">
								<div class="accordion-item">
									<h2 class="accordion-header" id="mm-head1">
										<button class="accordion-button px-xs-0 heading collapsed" type="button"
											data-bs-toggle="collapse" data-bs-target="#mm-collapse1"
											aria-expanded="false" aria-controls="mm-collapse1">
											Opportunities
										</button>
									</h2>
									<div id="mm-collapse1" class="accordion-collapse collapse"
										aria-labelledby="mm-head1" data-bs-parent="#fm-accordion">
										<div class="accordion-body px-xs-0 text-xs-start py-xs-2">
											<ul class="deco-none no-bullets p-xs-0">
												<li><a href="">Career</a></li>
												<li><a href="">Bid Opportunities</a></li>
											</ul>
										</div>
									</div>
								</div>
								<div class="accordion-item">
									<h2 class="accordion-header" id="mm-head2">
										<button class="accordion-button px-xs-0 heading collapsed" type="button"
											data-bs-toggle="collapse" data-bs-target="#mm-collapse2"
											aria-expanded="false" aria-controls="mm-collapse2">
											E-Services
										</button>
									</h2>
									<div id="mm-collapse2" class="accordion-collapse collapse"
										aria-labelledby="mm-head2" data-bs-parent="#fm-accordion">
										<div class="accordion-body px-xs-0 text-xs-start py-xs-2">
											<ul class="deco-none no-bullets p-xs-0">
												<li><a href="downloads/dl-faculty.php">Downloads</a></li>
												<li><a href="publications/pub-newsletters.php">Publications</a></li>
												<li>Knowledge Sharing &amp; Learning Resources</li>
												<li class="sub-list">
													<ul class="bullets-dot">
														<li><a href="https://www.efarm-clsu.com/"
																target="_blank">eFarm</a></li>
														<li><a href="https://www.agriatm.com/"
																target="_blank">AgriATM</a></li>
														<li><a href="https://dotclsu.edu.ph/" target="_blank">Distance,
																Open, and Transnational University</a></li>
														<li><a href="http://iccem.projectsafe-clsu.com"
																target="_blank">ICCEM</a></li>
														<li><a href="https://projectsafe-clsu.com"
																target="_blank">ProjectSAFE</a></li>
													</ul>
												</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div> --}}

                    <div class="footer-item">
                        <div class="footer-links f3">
                            <span class="footer-title"><a href="../about-us/au-contact-us.php">Location</a></span>
                            <div class="gmaps">
                                <div class="mapouter">
                                    <div class="gmap_canvas"><iframe width="80" height="200" id="gmap_canvas"
                                            src="https://maps.google.com/maps?q=Central%20Luzon%20State%20University,%20%09Science%20City%20of%20Mu%C3%B1oz%20Nueva%20Ecija,%20Philippines&t=&z=13&ie=UTF8&iwloc=&output=embed"
                                            frameborder="0" scrolling="no" marginheight="0"
                                            marginwidth="0"></iframe><a href="https://www.online-timer.net"></a><br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- soc med -->
        <div class="row">
            <div class="col-xl-12 col-md-12 col-xs-12">
                <div class="footer-bottom dp-xs-flex flex-xs-column-reverse align-items-center">
                    <div class="bottom left">
                        <div class="footer-socmed-cont">
                            <a href="https://www.facebook.com/officeofstudentaffairsCLSU" target="_blank"><i
                                    class="fab fa-facebook-f"></i></a>

                            <a href="https://www.youtube.com/@clsuosa5616" target="_blank"><i
                                    class="fab fa-youtube"></i></a>
                        </div>

                        <div class="footer-copyright-cont">
                            <span>© Copyright 2024 Central Luzon State University All Rights Reserved</span>
                        </div>
                    </div>

                    <div class="bottom right">
                        <ul class="seal p-xs-0 m-xs-auto">
                            <!--<li><a href="http://ggc.clsu.edu.ph/" target="_blank"><img src="" alt="CLSU Seal"></a></li>-->
                            {{-- <li class="m-xs-0"><a href="https://www.foi.gov.ph/requests?agency=CLSU"
										target="_blank"><img src="https://clsu.edu.ph/src/img/general/foi-logo.png"
											alt="FOI"></a></li> --}}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>

    <!-- scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script type="text/javascript" src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    <script type="text/javascript" src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/splide.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/script.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/js/all.min.js"
        integrity="sha512-8pHNiqTlsrRjVD4A/3va++W1sMbUHwWxxRPWNyVlql3T+Hgfd81Qc6FC5WMXDC+tSauxxzp1tgiAvSKFu1qIlA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" src="{{ asset('assets/js/drop-hover.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/jquery.waypoints.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>

    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js">
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
    <Script>
        $('.date').datetimepicker({
            format: 'YYYY-MM-DD',
            locale: 'en',
            icons: {
                up: 'fas fa-chevron-up',
                down: 'fas fa-chevron-down',
                previous: 'fas fa-chevron-left',
                next: 'fas fa-chevron-right'
            }
        })

        $('.datetime').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            locale: 'en',
            sideBySide: true,
            icons: {
                up: 'fas fa-chevron-up',
                down: 'fas fa-chevron-down',
                previous: 'fas fa-chevron-left',
                next: 'fas fa-chevron-right'
            }
        })

        $('.timepicker').datetimepicker({
            format: 'HH:mm:ss',
            icons: {
                up: 'fas fa-chevron-up',
                down: 'fas fa-chevron-down',
                previous: 'fas fa-chevron-left',
                next: 'fas fa-chevron-right'
            }
        })
    </Script>
    <script>
        // Swiper Inits
        const announceSwiper = new Swiper('.news-swiper-canvas .news-announcement-swiper', {
            // Optional parameters
            direction: 'horizontal',
            loop: true,
            spaceBetween: 50,

            // If we need pagination
            pagination: {
                el: '.swiper-pagination',
            },
        });

        const newsSwiper = new Swiper('.news-swiper-canvas .news-swiper', {
            // Optional parameters
            direction: 'horizontal',
            loop: true,
            spaceBetween: 50,

            // If we need pagination
            pagination: {
                el: '.swiper-pagination',
            },
        });
    </script>
    @yield('scripts')
</body>
<style>
    .mapouter {
        margin-bottom: -165px;
    }

    .footer-copyright-cont {
        padding-top: 5px;
    }

    .email-link {
        text-decoration: none;
        color: white;
    }

    .email-link:hover {
        text-decoration: underline;
    }

    #sou-link.active,
    #sou-link:hover {
        color: gold;
        /* You can adjust other styles as needed */
    }

    .sub-link {
        color: white;
        /* Default color */
    }

    .sub-link.active,
    .sub-link:focus,
    .sub-link:hover {
        color: gold;
        /* Change color as needed */
    }

    .nav-link {
        color: white;
        /* Default color for inactive tabs */
    }

    .nav-link.active {
        color: green;

    }
</style>

<script>
    // Select all elements with the class "sub-link"
    var links = document.querySelectorAll('.sub-link');

    // Loop through each link
    links.forEach(function(link) {
        // Add a click event listener to each link
        link.addEventListener('click', function() {
            // Remove the "active" class from all links
            links.forEach(function(link) {
                link.classList.remove('active');
            });
            // Add the "active" class to the clicked link
            this.classList.add('active');
        });
    });
</script>


</html>
