@extends('sois.layouts.app')
@section('content')
    <div class="page-title">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-xs-12">
                    <span class="page-title-text">Announcements</span>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="page-content-items">
            <div class="row">
                <div id="au-about" class="section-title col-xl-12 col-md-12 col-xs-12">

                </div>
            </div>

            <section id="gallery">
                <div class="container mt-5">
                    <?php
                    $count = 0;
                    ?>
                    <div class="row">
                        @forelse ($announcements as $announcement)
                            <div class="col-lg-3 mb-4">
                                <div class="card">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#modal{{ $announcement->id }}">
                                        <img src="{{ $announcement->photo->url ?? '' }}" alt=""
                                            class="card-img-top">
                                    </a>
                                    <div class="card-body d-flex justify-content-between">
                                        <a href="#" class="card-title" data-bs-toggle="modal"
                                            data-bs-target="#modal{{ $announcement->id }}">{{ $announcement->title }}</a>
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
                    {{-- <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-end">
                            {{$announcements->links()}}
                        </ul>
                    </nav> --}}

                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">
                            @if ($announcements->onFirstPage())
                                <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $announcements->previousPageUrl() }}"
                                        rel="prev">&laquo;</a></li>
                            @endif

                            <!-- Pagination links excluding Previous and Next buttons -->
                            @foreach ($announcements->getUrlRange(1, $announcements->lastPage()) as $page => $url)
                                <li class="page-item {{ $announcements->currentPage() == $page ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endforeach

                            @if ($announcements->hasMorePages())
                                <li class="page-item"><a class="page-link" href="{{ $announcements->nextPageUrl() }}"
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
    @foreach ($announcements as $announcement)
        <div class="modal fade" id="modal{{ $announcement->id }}" tabindex="-1"
            aria-labelledby="ModalLabel{{ $announcement->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #005600; color: white;">
                        <h5 class="modal-title" id="ModalLabel{{ $announcement->id }}"><b>{{ $announcement->title }}</b>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: white; color: black;"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card mb-3" style="max-width: 100%; border:none;">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <a href="{{ $announcement->photo->url ?? '' }}" target="_blank">
                                        <!-- Anchor tag to open the image in a new tab -->
                                        <img src="{{ $announcement->photo->url ?? '' }}" class="img-fluid rounded-start"
                                            alt="{{ $announcement->photo->filename ?? '' }}">
                                    </a>
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body justify-content-center">
                                        <h5 class="card-title">{{ $announcement->sub_title }}</h5>
                                        {!! $announcement->content !!}
                                        <p class="card-text"><small class="text-muted">Date Created:
                                                <b style="color:#005600;">{{ \Carbon\Carbon::parse($announcement->created_at)->toDayDateTimeString() }}</b></small>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
        font-weight: bold;
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
