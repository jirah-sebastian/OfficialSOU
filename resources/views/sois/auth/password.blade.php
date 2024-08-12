@extends('sois.layouts.app')
@section('content')

<div class="page-title">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 col-md-12 col-xs-12">
                <span class="page-title-text">Reset password</span>
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

                            <p class="text-muted">Login</p>

                            @if(session('message'))
                                <div class="alert alert-info" role="alert">
                                    {{ session('message') }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('password.request') }}">
                                @csrf

                                <input name="token" value="{{ $token }}" type="hidden">

                                <div class="form-group">
                                    <input id="email" type="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" required autocomplete="email" autofocus placeholder="{{ trans('global.login_email') }}" value="{{ $email ?? old('email') }}">

                                    @if($errors->has('email'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('email') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <input id="password" type="password" name="password" class="form-control" required placeholder="{{ trans('global.login_password') }}">

                                    @if($errors->has('password'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('password') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <input id="password-confirm" type="password" name="password_confirmation" class="form-control" required placeholder="{{ trans('global.login_password_confirmation') }}">
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary btn-block btn-flat">
                                            {{ trans('global.reset_password') }}
                                        </button>
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
