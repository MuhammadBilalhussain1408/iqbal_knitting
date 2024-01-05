@extends('layouts.auth_layout')
@section('content')
    <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="col-12 col-sm-12 col-md-8 col-lg-5 m-auto">
            <div class="form-mobile-view bg-light rounded p-4 p-sm-5 my-4">
                <div class="flex-sec d-flex align-items-center justify-content-between">
                    <a href="index.html" class="">
                        <h4 class="text-primary"><i class="fa fa-title me-2"></i>IQBAL KNITTING</h4>
                    </a>
                    <h4>Log In</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-floating mb-3">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-floating mb-4">
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mb-4">{{ __('Login') }}</button>
                        <p class="text-center mb-0">Don't have an Account? <a
                                href="{{ url('register') }}">{{ __('Sign Up') }}</a></p>

                    </form>
                    <div class="text-center">
                        <a href="{{ route('password.request') }}">Forgot Your Password?</a>
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection
