@extends('sois.layouts.app')
@section('content')

<div class="page-title">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 col-md-12 col-xs-12">
                <span class="page-title-text">Forgot Password</span>
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
                        <div class="column">
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

                            <p class="text-muted">Forgot Password</p>

                            @if(session('message'))
                                <div class="alert alert-info" role="alert">
                                    {{ session('message') }}
                                </div>
                            @endif

                            <form method="POST" action="#">
                                @csrf

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fa fa-user"></i>
                                        </span>
                                    </div>

                                    <input id="email" name="email" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" required autocomplete="email" autofocus placeholder="{{ trans('global.login_email') }}" value="{{ old('email', null) }}">

                                    @if($errors->has('email'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('email') }}
                                        </div>
                                    @endif
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-primary px-4">
                                            Reset
                                        </button>
                                    </div>
                                    <div class="col-6 text-right">

                                        <a class="btn btn-link px-0" href="{{ route('sois.login') }}">
                                            Login
                                        </a>
                                    </div>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>


            </div>
        </div>
    </div>
</div>

@endsection
