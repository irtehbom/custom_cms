@extends('layouts.backend')
@section('content')


<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Overview for {{$project->name}}</h1>
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

<div class="content">
    <div class="row">

        <div class="col-lg-3">

            <div class="block block-rounded block-fx-shadow" >

                <div class="block-content block-content-full">
                    <h2 class="content-heading">Website and Details</h2>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="website-details">Details: </div>
                            <small class="website-details-restyle">
                                <div><strong>URL: </strong><a target="_blank" href="{{$project->website}}">{{$project->website}}</a></div>
                                <div><strong>Q&A: </strong><a  href="/dashboard/project/{{$project->id}}/qa/{{$qa->id}}">View</a></div>
                                <div><strong>Citations: </strong><a  href="/dashboard/project/{{$project->id}}/citations/{{$citations->id}}">View</a></div>
                            </small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="website-details">CMS Access: </div>
                            <small class="website-details-restyle">
                                <div><strong>URL: </strong><a target="_blank" href="{{$project->cms_url}}">{{$project->cms_url}}</a></div>
                                <div><strong>Username: </strong>{!!$project->cms_username!!}</div>
                                <div><strong>Password: </strong>{!!$project->cms_password!!}</div>
                            </small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="website-details">FTP Access: </div>
                            <small class="website-details-restyle">
                                <div><strong>URL: </strong>{!!$project->ftp_ip!!}</div>
                                <div><strong>Username: </strong>{!!$project->ftp_username!!}</div>
                                <div><strong>Password: </strong>{!!$project->ftp_password!!}</div>
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="block block-rounded block-fx-shadow" >

                <div class="block-content block-content-full">
                    <h2 class="content-heading">Project Brief</h2>
                    <small>{!!$project->description!!}</small>
                </div>
            </div>

            @foreach ($project->users->all() as $user)
            <div class="row">
                <div class="col-md-12 col-xl-12">
                    <div class="block block-rounded block-fx-shadow" >
                        <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                            {{$user->name}}
                            <div class="ml-3 text-right">
                                <p class="font-w600 mb-0"></p>
                                <p class="font-size-sm font-italic text-muted mb-0">
                                    <strong>Email:</strong> {{$user->email}}
                                </p>
                                <p class="font-size-sm font-italic text-muted mb-0">
                                    <strong>Business Num:</strong> {{$user->business_number}}
                                </p>
                                <p class="font-size-sm font-italic text-muted mb-0">
                                    <strong>Mobile Num:</strong> {{$user->mobile_number}}
                                </p>
                            </div>
                        </div>
                        @if($user->primary_user)
                        <div class="primary-user" >
                            Primary Contact
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach

        </div>


        <div class="col-lg-9">
            
             <div class="block block-rounded block-bordered">
                  
                <div class="block-content">
                    <h2 class="content-heading">Analytics</h2>
                    @if(isset($analytics->error->error->message))
                        Analytics Error: <span style="color:red">{{$analytics->error->error->message}}</span>
                        <div class="spacer"></div>
                        Please add <code>analytics-api@electric-orbit-240110.iam.gserviceaccount.com</code> in your Analytics account. 
                        <div class="spacer"></div>
                        This is found in Settings/User Permissions on your Analytics account.
                        <div class="spacer"></div>
                    @else 
                    <div style="height:350px">
                        <canvas id="line-chart" width="200" height="370" style="width:100% !important"></canvas>
                    </div>
                    @endif
                    
                </div>
            </div>

            <div class="block block-rounded block-bordered">
                <div class="block-content">
                    <h2 class="content-heading">All Activity</h2>
                    @foreach($activities as $key => $val)
                    <div class="row">
                        <div class="col-sm-12">
                            <h2 class="content-heading-grey">
                                {{$key}}
                            </h2>
                        </div>
                    </div>

                    @foreach($val as $value)

                    <div class="row overview-row">
                        <div class="col-sm-10">
                            @if($value->type == 'thread')
                            <div class="circle-profile-small"><span class="profile-center-small">{{substr($value->messages()->orderBy('id', 'DESC')->first()->user_name, 0, 1)}}</span></div>
                            <div class="overview-data">
                                <span class="overview-inline"><small>{{$value->messages()->orderBy('id', 'DESC')->first()->user_name}}</small></span>
                                <span class="overview-inline"><small>Added a new message</small></span>
                                <span class="overview-inline">
                                    <small><a href="{{route('singleProjectMessagesViewThread', [$project->id, $value->id])}}">{!!str_limit(strip_tags($value->messages()->orderBy('id', 'DESC')->first()->message,1))!!}</a></small>
                                </span>
                            </div>
                            @elseif($value->type == 'time')
                            <div class="circle-profile-small"><span class="profile-center-small">{{substr($value->user_name, 0, 1)}}</span></div>
                            <div class="overview-data">
                                <span class="overview-inline"><small>{{$value->user_name}}</small></span>
                                <span class="overview-inline"><small>Added a new time entry</small></span>
                                <span class="overview-inline">
                                    <small><a href="/dashboard/project/{{$project->id}}/time">{{$value->title}}</a></small>
                                </span>
                            </div>
                            @elseif($value->type == 'file')
                            <div class="circle-profile-small"><span class="profile-center-small">{{substr($value->user_name, 0, 1)}}</span></div>
                            <div class="overview-data">
                                <span class="overview-inline"><small>{{$value->user_name}}</small></span>
                                <span class="overview-inline"><small>Added a new file</small></span>
                                <span class="overview-inline">
                                    <small><a href="{{$value->path}}">{{str_limit($value->originalName, 15)}}</a></small>
                                </span>
                            </div>
                            @endif
                        </div>
                        <div class="col-sm-2">
                            <small>{{$value->updated_at->toDayDateTimeString()}}</small>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js"></script>

<script>


new Chart(document.getElementById("line-chart"), {
  height:370,
  type: 'line',
  data: {
    labels: {!! json_encode($analytics->dates) !!},
    datasets: [{ 
        data:  {!! json_encode($analytics->visitors) !!},
        label: "Organic Trafic",
        borderColor: "#3e95cd",
        fill: false
      }
    ]
  },
  options: {
    title: {
      display: true,
      text: 'Analytics Data'
    },
    maintainAspectRatio: false,
  }
});

</script>

@endsection
