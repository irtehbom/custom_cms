@extends('layouts.backend')

@section('content')
<!-- Hero -->

<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Guest Posting Overview for {{$project->name}}</h1>
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                @include('partials.links_header')
            </nav>
        </div>
        @if (Session::has('message'))
        <div class="spacer"></div>
        {!! session('message') !!}
        @endif
    </div>
</div>
<!-- END Hero -->

<div class="content">
    <div class="block block-rounded block-bordered">
        <div class="block-header block-header-default">
            @include('partials.outreach_links')
        </div>
    </div>
</div>

<!-- Page Content -->
<div class="content">
    <div class="block block-rounded block-bordered">

        <div class="block-header block-header-default">
            <h3 class="block-title">Overview</h3>
            <div class="block-options">
            </div>
        </div>

        <div class="row">
            <div class="col-md-9">
                <div class="content content-full time-table">
                </div>
            </div>

            <div class="col-md-3">
                <div class="content">
                    <div class="d-md-none push">
                        <button type="button" class="btn btn-block btn-hero-dark" data-toggle="class-toggle" data-target="#side-content" data-class="d-none">
                            Project Details
                        </button>
                    </div>

                    <div id="side-content" class="d-none d-md-block push">


                    </div>
                </div>
            </div>


        </div>
    </div>
</div>

@endsection
