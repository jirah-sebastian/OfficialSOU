@extends('sois.layouts.app')
@section('content')

<div class="page-title">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 col-md-12 col-xs-12">
                <span class="page-title-text">Reset Password</span>
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

                            <p class="text-muted">Reset password</p>

                            @if(session('status'))
                                <div class="alert alert-info" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf

                                <div class="form-group">
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" required autocomplete="email" autofocus placeholder="{{ trans('global.login_email') }}" value="{{ old('email') }}">

                                    @if($errors->has('email'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('email') }}
                                        </div>
                                    @endif
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-success btn-flat btn-block">
                                            {{ trans('global.send_password') }}
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

