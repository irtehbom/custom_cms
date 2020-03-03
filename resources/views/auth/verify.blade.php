@extends('layouts.backend')

@section('content')

<!-- Hero -->
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Email Verification</h1>

        </div>
    </div>
</div>
<!-- END Hero -->


<!-- Page Content -->
<div class="content">
    <div class="row">
        <div class="col-md-12 ">

                
            <h2 class="content-heading">Verify your email</h2>
            <div class="block block-rounded block-fx-shadow" >
                <div class="block-content block-content-full">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a>.
                </div>
            </div>
                
    </div>
</div>
<!-- END Page Content -->
@endsection
