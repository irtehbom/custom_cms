@extends('layouts.simple')

@section('content')

<!-- Page Content -->
<div class="bg-image" style="background-image: url('assets/media/photos/photo19@2x.jpg');">
    <div class="row no-gutters bg-gd-sun-op">
        <!-- Main Section -->
        <div class="hero-static col-md-6 d-flex align-items-center bg-white">
            <div class="p-3 w-100">
                <!-- Header -->
                <div class="text-center">
                    <a class="link-fx text-warning font-w700 font-size-h1" href="{{ route('login') }}">
                          <span class="text-dark">WildShark Management</span>
                    </a>
                    <p class="text-uppercase font-w700 font-size-sm text-muted">Password Reminder</p>
                </div>
                <!-- END Header -->

                <!-- Reminder Form -->
                <!-- jQuery Validation (.js-validation-reminder class is initialized in js/pages/op_auth_reminder.min.js which was auto compiled from _es6/pages/op_auth_reminder.js) -->
                <!-- For more info and examples you can check out https://github.com/jzaefferer/jquery-validation -->
                <div class="row no-gutters justify-content-center">
                    <div class="col-sm-8 col-xl-6">
                        <form method="POST" action="{{ route('password.email') }}" aria-label="{{ __('Reset Password') }}">
                            @csrf
                            <div class="form-group py-3">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required placeholder="Email Address">
                                @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-block btn-hero-lg btn-hero-warning">
                                    <i class="fa fa-fw fa-reply mr-1"></i> Password Reminder
                                </button>
                                <p class="mt-3 mb-0 d-lg-flex justify-content-lg-between">
                                    <a class="btn btn-sm btn-light d-block d-lg-inline-block mb-1" href="{{ route('login') }}">
                                        <i class="fa fa-sign-in-alt text-muted mr-1"></i> Sign In
                                    </a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- END Reminder Form -->
            </div>
        </div>
        <!-- END Main Section -->

        <!-- Meta Info Section -->
        <div class="hero-static col-md-6 d-none d-md-flex align-items-md-center justify-content-md-center text-md-center">
            <div class="p-3">
                <p class="display-4 font-w700 text-white mb-0">
                    Don’t worry of failure..
                </p>
                <p class="font-size-h1 font-w600 text-white-75 mb-0">
                    ..but learn from it!
                </p>
            </div>
        </div>
        <!-- END Meta Info Section -->
    </div>
</div>

@endsection
