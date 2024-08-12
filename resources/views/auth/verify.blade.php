@extends('sois.layouts.app')
@section('content')

<div class="page-title">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 col-md-12 col-xs-12">
                <span class="page-title-text">Verify</span>
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

        <div class="row">
            <div class="page-cont section-cont col-xl-12 col-md-12 col-xs-12">
                <div class="flexbox-gen left m-b-2">
                        <div class="column dp-xs-none">
                            <div class="img-wrapper-black-sub">
                                <img style=  "display: block;
                                height: 400px;
                                width: 400px;
                                margin-left: auto;
                                margin-right: auto;

                                " src="../assets/img/sou/sou logo.png">
                                <p class="caption">CLSU Main Gate</p>
                            </div>
                        </div>

                        <div class="column p-5">
                            <div class="text-wrapper">
                            <h1> Student Organization </h1>

                            <p class="text-muted">Verify</p>

                            @if(session('message'))
                                <div class="alert alert-info" role="alert">
                                    {{ session('message') }}
                                </div>
                            @endif

                            @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                    </form>
                            </div>
                        </div>
                    </div>


            </div>
        </div>
    </div>
</div>

@endsection


