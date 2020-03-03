@extends('layouts.backend')

@section('content')
<!-- Hero -->

<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Time Overview for {{$project->name}}</h1>
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


<!-- Page Content -->
<div class="content">
    <div class="block block-rounded block-bordered">

        <div class="block-header block-header-default">
            <h3 class="block-title">Time Entries</h3>
            <div class="block-options">
                @if (Auth::user()->hasRole('Administrator') || Auth::user()->hasRole('Consultant'))
                <a href="/dashboard/project/{{$project->id}}/time/create" type="button" class="btn-block-option mr-2">
                    <i class="fa fa-plus mr-1"></i> New Entry
                </a>
                @endif
                <button type="button" class="btn-block-option" data-toggle="block-option" data-action="fullscreen_toggle"></button>
            </div>
        </div>

        <div class="row">

            <div class="col-md-9">
                <div class="content content-full time-table">

                    @foreach($time as $key => $val)
                    <h2 class="content-heading pb-0 mb-3 border-0">
                        {{$key}} <span class="js-task-badge badge badge-pill badge-light animated fadeIn"></span>
                    </h2>

                    <table class="table table-bordered table-striped table-vcenter js-dataTable-simple">
                        <thead class="thead-dark">
                            <tr>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Logged By</th>
                                <th>Time Taken</th>
                                @if (Auth::user()->hasRole('Administrator') || Auth::user()->hasRole('Consultant'))
                                <th>Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($val as $value)
                            <tr>
                                <td>{{$value['title']}}</td>
                                <td style="width:50%" ><small>{!!$value['description']!!}</small></td>
                                <td>{{$value['user_name']}}</td>
                                <td>{{$timeModal->convertToHoursMins($value['time_logged'])}}</td>
                                @if (Auth::user()->hasRole('Administrator') || Auth::user()->hasRole('Consultant'))
                                <td>
                                    <a href="/dashboard/project/{{$project->id}}/time/edit/{{$value['id']}}"><span class="badge badge-info">Edit</span></a>
                                    <a href="/dashboard/project/{{$project->id}}/time/delete/{{$value['id']}}"><span class="badge badge-danger">Delete</span></a>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endforeach
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

                        <h2 class="h4 font-w400 mb-3">Current Months Completion</h2>
                        <div class="progress push">
                            <div class="progress-bar bg-muted" role="progressbar" style="width: {{$currentMonth['percent_complete'][0]}}%; background-color:#666" aria-valuenow="{{$currentMonth['percent_complete'][0]}}" aria-valuemin="0" aria-valuemax="100">
                                <span class="font-size-sm font-w600">{{$currentMonth['percent_complete'][0]}}%</span>
                            </div>
                        </div>

                        <p class="text-muted">
                            Monthly Hours: <strong>{{$project->hours}}</strong>
                        </p>


                        <p class="text-muted">
                            Time logged this month: <strong>{{$currentMonth['project_hours'][0]}}</strong>
                        </p>

                        <p class="text-muted">
                            Start Day: <strong>{{$currentMonth['start']}}</strong>
                        </p>

                        <p class="text-muted">
                            End Day: <strong>{{$currentMonth['end']}}</strong>
                        </p>

                    </div>
                </div>
            </div>


        </div>
    </div>
</div>

@endsection
