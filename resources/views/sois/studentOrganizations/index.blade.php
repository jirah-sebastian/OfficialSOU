@extends('sois.layouts.app')
@section('content')
    <style>
        /* Add or modify styles as needed */
        .main-content-card {
            min-height: 400px;
            /* Ensure a minimum height to prevent content from being hidden */
            max-width: 100%;
            margin: 0 auto;
        }

        .card {
            margin-bottom: 20px;
        }

        .card-title {
            color: black;
            font-weight: bold;
            text-decoration: none;
            transition: transform 0.3s ease;
            height: 2.3em;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.2em;
            font-size: 18px;
            text-align: justify;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
        }



        .card-title:hover {
            text-decoration: underline;
            color: rgb(43, 157, 14);
            opacity: 0.8;
        }

        .card-img-container {
            padding: 5px;
            height: 380px;
            /* Increase the image height */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card-img-top:hover {
            opacity: 0.8;
            cursor: pointer;
            transform: scale(0.95);
            transition: transform 0.3s ease;
            max-width: 100%;
            max-height: 100%;
        }

        .card-img-top {
            padding: 5px;
            width: 100%;
            height: 350px;
            /* Increase the image height */
            flex: 1;
        }
    </style>

    <div class="page-title">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-xs-12">
                    <span class="page-title-text">Student Organization List</span>
                </div>
            </div>
        </div>
    </div>

    <div class="page-main">
        <div class="container-fluid">
            <div class="page-content-items">
                <div class="row d-flex justify-content-between">
                    <div class="page-menu col-xl-3 col-md-3 col-xs-3">
                        <div class="container-fluid">
                            <div class="page-menu-items">
                                <div class="row">
                                    <div class="col-xl-12 col-md-12 col-xs-12">
                                        <div class="list-items-div">
                                            <ul>
                                                @foreach ($soCategories as $soCategory)
                                                    <li><a class="@if ($soCategory->id == $selected) active @endif"
                                                            href="/sois/student-organizations?category={{ $soCategory->id }}">{{ $soCategory->category_name }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right column -->
                    <div class="page-content col-xl-9 col-md-12 col-xs-12">
                        <div class="container-fluid">
                            <div class="page-content-items">
                                <div class="row">
                                    <div class="section-title col-xl-12 col-md-12 col-xs-12 mb-2">
                                        <span>List of Recognized Organizations</span>
                                    </div>
                                </div>

                                <!-- Adjust the grid layout to display three cards per row -->
                                <div class="row gx-2">
                                    @foreach ($soLists as $index => $soList)
                                        <div class="col-lg-4 mb-4"> <!-- Adjust column width -->
                                            <div class="container-fluid">
                                                <div class="card mb-3 main-content-card">
                                                    <a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#Imodal{{ $soList->id }}">
                                                        <img class="card-img-top"
                                                            src="{{ $soList->banner ? $soList->banner->getUrl() : '' }}"
                                                            alt="SO Banner" style="cursor: pointer;">
                                                    </a>
                                                    <div class="card-body">
                                                        <a href="#" data-bs-toggle="modal"
                                                            data-bs-target="#Imodal{{ $soList->id }}"
                                                            style="text-decoration: none; color: black;">
                                                            <h5 class="card-title">{{ $soList->so_name }}</h5>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal code -->
    @foreach ($soLists as $soList)
        <div class="modal fade" id="Imodal{{ $soList->id }}" tabindex="-1"
            aria-labelledby="ModalLabel{{ $soList->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #005600; color: white;">
                        <h5 class="modal-title" id="ModalLabel{{ $soList->id }}"><b>{{ $soList->so_name }}</b></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: white; color: black;"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card mb-3" style="max-width: 100%;">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <a href="{{ $soList->banner ? $soList->banner->getUrl() : '' }}" target="_blank">
                                        <!-- Anchor tag to open the image in a new tab -->
                                        <img src="{{ $soList->banner ? $soList->banner->getUrl() : '' }}"
                                            class="img-fluid rounded-start" alt="{{ $soList->banner->filename ?? '' }}"
                                            style="cursor: pointer;">
                                    </a>
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body justify-content-center" style="text-align: justify;">
                                        <h5>{{ $soList->overview }}</h5><br>

                                        {!! $soList->information !!}
                                        {{-- <p class="card-text"><small class="text-muted">President:
                                                <b>{!! $soList->created_by->name !!}</b></small></p>
                                        <p class="card-text"><small class="text-muted">Email:
                                                <b>{!! $soList->created_by->email !!}</b></small></p> --}}
                                        <p class="card-text">
                                            <small class="text-muted">President:
                                                <b style="color:#005600;">
                                                    @if ($soList->created_by)
                                                        {!! $soList->created_by->name !!}
                                                    @else
                                                        No president specified
                                                    @endif
                                                </b>
                                            </small>
                                        </p>
                                        <p class="card-text">
                                            <small class="text-muted">Email:
                                                <b style="color:#005600;">
                                                    @if ($soList->created_by && $soList->created_by->email)
                                                        {!! $soList->created_by->email !!}
                                                    @else
                                                        N/A
                                                    @endif
                                                </b>
                                            </small>
                                        </p>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="/sois/student-organization/apply/{{ $soList->id }}" class="btn btn-success">Apply</a>
                    </div>

                </div>
            </div>
        </div>
    @endforeach
@endsection

{{-- @extends('sois.layouts.app')
@section('content')
    <style>
        .main-content-card {
            height: 320px;
            max-width: 100%;

            margin: 0 auto;

        }

        .card {
            margin-bottom: 20px;
        }

        .card-title {
            color: black;
            font-weight: bold;
            text-decoration: none;
            transition: transform 0.3s ease;
            /* Add ellipsis for long titles */
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }


        .card-title:hover {
            text-decoration: underline;
            color: rgb(43, 157, 14);
            opacity: 0.8;
        }

        .card-img-container {
            padding: 5px;
            height: 280px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card-img-top:hover {
            opacity: 0.8;
            cursor: pointer;
            transform: scale(0.95);
            transition: transform 0.3s ease;
            max-width: 100%;
            max-height: 100%;
        }

        .card-img-top {
            padding: 10px;
            width: 100%;
            height: 250px;
            flex: 1;
        }
    </style>

    <div class="page-title">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-xs-12">
                    <span class="page-title-text">Student Organization List</span>
                </div>
            </div>
        </div>
    </div>

    <div class="page-main">
        <div class="container-fluid">
            <div class="page-content-items">
                <div class="row d-flex justify-content-between">
                    <div class="page-menu col-xl-3 col-md-3 col-xs-3">
                        <div class="container-fluid">
                            <div class="page-menu-items">
                                <div class="row">
                                    <div class="col-xl-12 col-md-12 col-xs-12">
                                        <div class="list-items-div">
                                            <ul>
                                                @foreach ($soCategories as $soCategory)
                                                    <li><a class="@if ($soCategory->id == $selected) active @endif"
                                                            href="/sois/student-organizations?category={{ $soCategory->id }}">{{ $soCategory->category_name }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="page-content col-xl-9 col-md-12 col-xs-12">
                        <div class="container-fluid">
                            <div class="page-content-items">
                                <div class="row">
                                    <div class="section-title col-xl-12 col-md-12 col-xs-12 mb-2">
                                        <span>List of Recognized Organizations</span>
                                    </div>
                                </div>

                                <div class="row gx-2">
                                    @foreach ($soLists as $index => $soList)
                                        <div class="col-lg-3 mb-4">
                                            <div class="container-fluid">
                                                <div class="card mb-3 main-content-card">
                                                    <a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#Imodal{{ $soList->id }}">
                                                        <img class="card-img-top"
                                                            src="{{ $soList->banner ? $soList->banner->getUrl() : '' }}"
                                                            alt="SO Banner" style="cursor: pointer;">
                                                    </a>
                                                    <div class="card-body">
                                                        <a href="#" data-bs-toggle="modal"
                                                            data-bs-target="#Imodal{{ $soList->id }}"
                                                            style="text-decoration: none; color: black;">
                                                            <h5 class="card-title">{{ $soList->so_name }}</h5>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @if (($index + 1) % 4 == 0)
                                            <div class="w-100 d-none d-lg-block"></div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @foreach ($soLists as $soList)
        <div class="modal fade" id="Imodal{{ $soList->id }}" tabindex="-1"
            aria-labelledby="ModalLabel{{ $soList->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModalLabel{{ $soList->id }}"><b>{{ $soList->so_name }}</b></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card mb-3" style="max-width: 100%;">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <a href="{{ $soList->banner ? $soList->banner->getUrl() : '' }}" target="_blank">
                                        <!-- Anchor tag to open the image in a new tab -->
                                        <img src="{{ $soList->banner ? $soList->banner->getUrl() : '' }}"
                                            class="img-fluid rounded-start" alt="{{ $soList->banner->filename ?? '' }}"
                                            style="cursor: pointer;">
                                    </a>
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body justify-content-center" style="text-align: justify;">
                                        <h5>{{ $soList->overview }}</h5><br>

                                        {!! $soList->information !!}
                                        <p class="card-text"><small class="text-muted">President:
                                                <b>{!! $soList->created_by->name !!}</b></small></p>
                                        <p class="card-text"><small class="text-muted">Email:
                                                <b>{!! $soList->created_by->email !!}</b></small></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="/sois/student-organization/apply/{{ $soList->id }}" class="btn btn-success">Apply</a>
                    </div>

                </div>
            </div>
        </div>
    @endforeach
@endsection --}}
