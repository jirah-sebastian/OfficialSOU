@extends('sois.layouts.app')
@section('content')
    <div class="page-title">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-xs-12">
                    <span class="page-title-text">Resources</span>
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


                <div class="container" style="margin-top: 100px;">
                    <div class="row">
                        <div class="col-lg-6 mb-4">

                            <div class="card">
                                <div class="card-header">
                                    Download Links
                                </div>
                                @forelse ($resources as $resource)
                                <div class="card-body d-flex justify-content-between">
                                    <h5 class="card-title">{{$resource->title}}</h5>

                                    <a href="{{route('resource',$resource->file->id) }}" class="btn btn-outline-success btn-sm"><i class="fas fa-download"></i> Download</a>
                                </div>
                                @empty
                                <div class="card-body d-flex justify-content-between">
                                    <h6 class="card-title">No Download Available</h6>
                                </div>
                                @endforelse


                            </div>
                        </div>
                        <div class="col-lg-6 mb-4">
                            <div class="card">
                                <div class="card-header">
                                    Links
                                </div>
                                <div class="card-body">
                                    <div class="d-flex">
                                        <h1 class="card-title"><i class="fa-brands fa-square-facebook"></i></h1>
                                        <div class="align-self-center ml-3">
                                            <h5 class="">Facebook</h5>
                                            <h6>sadads</h6>
                                        </div>

                                    </div>


                                </div>
                                <div class="card-body">
                                    <div class="d-flex">
                                        <h1 class="card-title"><i class="fa-solid fa-envelope"></i></h1>
                                        <div class="align-self-center ml-3">
                                            <h5 class="">Email</h5>
                                            <h6>adsad@asda.com</h6>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

        </div>
    </div>
@endsection
