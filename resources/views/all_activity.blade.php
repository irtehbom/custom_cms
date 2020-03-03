@extends('layouts.backend')

@section('content')
<!-- Hero -->
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Projects Overview</h1>

        </div>
    </div>
</div>
<!-- END Hero -->

<!-- Page Content -->
<div class="content">
    <div class="row">
        <div class="col-md-12 ">
            <div class="block block-rounded block-bordered">

                <div class="block-header block-header-default">
                    <h3 class="block-title">All Activity</h3>
                </div>

                <div class="block-content">
                    @foreach($projects as $project)
                    
                    <div class="row">
                        <div class="col-sm-12">
                            <h2 class="content-heading-grey">
                                <a class="black-link" href="/dashboard/project/{{$project['project']->id}}/overview">{{$project['project']->name}}</a>
                            </h2>
                        </div>
                    </div>

                    @foreach($project['collection'] as $collection)

                    <div class="row overview-row">
                        <div class="col-sm-10">
                            @if($collection->type == 'thread')
                            <div class="circle-profile-small"><span class="profile-center-small">{{substr($collection->messages()->orderBy('id', 'DESC')->first()->user_name, 0, 1)}}</span></div>
                            <div class="overview-data">
                                <span class="overview-inline"><small>{{$collection->messages()->orderBy('id', 'DESC')->first()->user_name}}</small></span>
                                <span class="overview-inline"><small>Added a new message</small></span>
                                <span class="overview-inline">
                                    <small><a href="{{route('singleProjectMessagesViewThread', [$project['project']->id, $collection->id])}}">{!!str_limit(strip_tags($collection->messages()->orderBy('id', 'DESC')->first()->message,100))!!}</a></small>
                                </span>
                            </div>
                            @elseif($collection->type == 'time')
                            <div class="circle-profile-small"><span class="profile-center-small">{{substr($collection->user_name, 0, 1)}}</span></div>
                            <div class="overview-data">
                                <span class="overview-inline"><small>{{$collection->user_name}}</small></span>
                                <span class="overview-inline"><small>Added a new time entry</small></span>
                                <span class="overview-inline">
                                    <small><a href="/dashboard/project/{{$project['project']->id}}/time">{{$collection->title}}</a></small>
                                </span>
                            </div>
                            @elseif($collection->type == 'file')
                            <div class="circle-profile-small"><span class="profile-center-small">{{substr($collection->user_name, 0, 1)}}</span></div>
                            <div class="overview-data">
                                <span class="overview-inline"><small>{{$collection->user_name}}</small></span>
                                <span class="overview-inline"><small>Added a new file</small></span>
                                <span class="overview-inline">
                                    <small><a href="{{$collection->path}}">{{str_limit($collection->originalName, 15)}}</a></small>
                                </span>
                            </div>
                            
                            @endif
                        </div>
                        <div class="col-sm-2">
                            <small>{{$collection->updated_at->toDayDateTimeString()}}</small>
                        </div>
                    </div>
                    <div class="spacer"></div>
                    
                    @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END Page Content -->
@endsection
