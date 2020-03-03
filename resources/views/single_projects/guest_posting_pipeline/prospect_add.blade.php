@extends('layouts.backend')

@section('content')
<!-- Hero -->

<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Add Prospects for {{$project->name}}</h1>
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
            <h3 class="block-title">Prospects</h3>
            <div class="block-options">
            </div>
        </div>

        <form action="{{route('GuestPostingPipelineSourcingSave', $project->id)}}" method="post" id="form-validate" name="form-validate" >
            {{ csrf_field() }}
            <div class="row">
                <div class="col-sm-8">
                    <div class="block-content">
                        <label>Enter Domains (1 Per Line)</label>

                        <div class="form-group">
                            <textarea style="width:100%" id="js-ckeditor" name="domains"></textarea>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-hero-primary">
                                Submit
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </form>   
    </div>
</div>

@endsection
