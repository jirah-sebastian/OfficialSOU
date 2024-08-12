@extends('sois.layouts.app')
@section('content')
    <div class="page-title">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-xs-12">
                    <span class="page-title-text">Activities</span>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="page-content-items">
            <div class="row">
                <div id="au-about" class="section-title col-xl-12 col-md-12 col-xs-12">
                    <span></span>
                </div>
            </div>

            <section class="header-main border-bottom bg-white mt-5"></section>

            <section id="gallery">
                <div class="container ">
                    <div class="container-fluid">
                        <?php $count = 0; ?>
                        <div class="row">
                            @forelse ($activities as $activity)
                                <div class="col-lg-3 mb-4">
                                    <div class="card">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#modal{{ $activity->id }}">
                                            <img src="{{ $activity->content_photo->url ?? '' }}"
                                                alt="{{ $activity->content_photo->filename ?? '' }}" class="card-img-top">
                                        </a>
                                        <div class="card-body d-flex flex-column">
                                            <a href="#" class="card-title" data-bs-toggle="modal"
                                                data-bs-target="#modal{{ $activity->id }}">{{ $activity->title }}</a>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                $count++;
                                if ($count % 4 == 0) {
                                    echo '</div><div class="row">';
                                }
                                ?>
                            @empty
                            @endforelse
                        </div>
                    </div>
                    {{-- <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-end">
                        {{$activities->links()}}
                    </ul>
                </nav> --}}
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">
                            <!-- Changed justify-content-end to justify-content-center -->
                            @if ($activities->onFirstPage())
                                <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $activities->previousPageUrl() }}"
                                        rel="prev">&laquo;</a></li>
                            @endif

                            <!-- Pagination links excluding Previous and Next buttons -->
                            @foreach ($activities->getUrlRange(1, $activities->lastPage()) as $page => $url)
                                <li class="page-item {{ $activities->currentPage() == $page ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endforeach

                            @if ($activities->hasMorePages())
                                <li class="page-item"><a class="page-link" href="{{ $activities->nextPageUrl() }}"
                                        rel="next">&raquo;</a></li>
                            @else
                                <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                            @endif
                        </ul>
                    </nav>

                </div>
            </section>
        </div>
    </div>

    @foreach ($activities as $activity)
        <div class="modal fade" id="modal{{ $activity->id }}" tabindex="-1"
            aria-labelledby="ModalLabel{{ $activity->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #005600; color: white;">
                        <h5 class="modal-title" id="ModalLabel{{ $activity->id }}"><b>{{ $activity->title }}</b></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: white; color: black;"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card mb-3" style="max-width: 100%; border:none;">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <a href="{{ $activity->content_photo->url ?? '' }}" target="_blank">
                                        <!-- Anchor tag to open the image in a new tab -->
                                        <img src="{{ $activity->content_photo->url ?? '' }}"
                                            class="img-fluid rounded-start"
                                            alt="{{ $activity->content_photo->filename ?? '' }}">
                                    </a>
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <p>{!! $activity->content !!}</p>
                                        {{-- <p class="card-text"><small class="text-muted">Student Organization: <b>{{$activity->organization->so_name}}</b></small></p> --}}
                                        @if ($activity->organization && $activity->organization->so_name !== null)
                                            <p class="card-text">
                                                <small class="text-muted">Student Organization:
                                                    <b style="color:#005600;">{{ $activity->organization->so_name }}</b></small>
                                            </p>
                                        @else
                                            <p class="card-text">
                                                <small class="text-muted">Student Organization: <b>No organization
                                                        specified</b></small>
                                            </p>
                                        @endif

                                        <p class="card-text"><small class="text-muted">Event Date:
                                                <b style="color:#005600;">{{ \Carbon\Carbon::parse($activity->event_date)->toDayDateTimeString() }}</b></small>
                                        </p>
                                        <p class="card-text"><small class="text-muted">Event Place:
                                                <b style="color:#005600;">{{ $activity->event_place }}</b></small></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div> --}}
                </div>
            </div>
        </div>
    @endforeach
@endsection

<style>
    /* Custom CSS */
    .card {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .card-title {
        color: black;

        text-decoration: none;
        transition: transform 0.3s ease;
        flex: 1;
        /* Allow the title to grow vertically */
        margin-bottom: 0.5rem;
        /* Add space below the title */
    }

    /* .card-title:hover {
        text-decoration: none;
        color: rgb(0, 0, 0);
        transform: scale(0.90);
        opacity: 0.8;
    } */

    .card-img-top:hover {
        opacity: 0.8;
        /* Adjust the opacity level as needed */
        cursor: pointer;
        transform: scale(0.95);
        transition: transform 0.3s ease;

    }

    .card-img-top {
        padding: 10px;
        /* Add padding around the image */
        flex: 1;
        /* Allow the image to grow vertically */
        width: 100%;
        /* Set width to 100% */
        height: 300px;
        /* Set fixed height for the image */
    }

    .card-body {
        display: flex;
        flex-direction: column;
        padding: 1rem;
        /* Add padding to the card body */
        flex: 1;
        /* Allow the card body to grow */
    }

    .btn-group {
        margin-top: auto;
        /* Push the button group to the bottom */
    }

    .modal-body {
        text-align: justify;
    }
</style>
