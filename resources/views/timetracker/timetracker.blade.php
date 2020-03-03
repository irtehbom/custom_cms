@extends('layouts.backend')

@section('content')

<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Time Tracker</h1>
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item active" aria-current="page">Time Tracker</li>
                </ol>
            </nav>
        </div>
        @if (Session::has('message'))
        <div class="spacer"></div>
        {!! session('message') !!}
        @endif
    </div>
</div>

<div class="content">
    <div class="block block-rounded block-bordered">
        <div class="block-content">
            <div class="block-content block-content-full">
                <table id="dataTables" class="table table-bordered table-striped table-vcenter js-dataTable-simple">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Starts On</th>
                            <th>Report Due On</th>
                            <th>Customer Hours</th>
                            <th>Hours Completed This Month</th>
                            <th>This Month</th>
                            <th>1 Month Ago</th>
                            <th>2 Months Ago</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($projects as $project)
                        <tr>
                            <td><a href="/dashboard/project/{{$project->id}}/overview">{{$project->name}}</a></td>
                            <td>{{$project->timedata['start']}}</td>
                            <td>{{$project->timedata['end']}}</td>
                            <td>{{$project->hours}}</td>
                            <td>{{$project->timedata['project_hours'][0]}}</td>
                            @foreach($project->timedata['percent_complete'] as $percent)
                            <td>
                                @if($percent <= '20')
                                <div class="progress progress-resize position-relative">
                                    <div class="progress-bar" role="progressbar" style="background: red; width: {{$percent}}%" aria-valuenow="{{$percent}}" aria-valuemin="0" aria-valuemax="100"></div>
                                    <small class="justify-content-center d-flex position-absolute  progress-move" style='color:black'>{{$percent}}%</small>
                                </div>
                                @elseif($percent > '20' && $percent <= '70')
                                <div class="progress progress-resize position-relative">
                                    <div class="progress-bar" role="progressbar" style="background: yellow; width: {{$percent}}%" aria-valuenow="{{$percent}}" aria-valuemin="0" aria-valuemax="100"></div>
                                    <small class="justify-content-center d-flex position-absolute  progress-move" style='color:black'>{{$percent}}%</small>
                                </div>
                                @elseif($percent >= '71' )
                                <div class="progress progress-resize position-relative">
                                    <div class="progress-bar" role="progressbar" style="background: green; width: {{$percent}}%" aria-valuenow="{{$percent}}" aria-valuemin="0" aria-valuemax="100"></div>
                                    <small class="justify-content-center d-flex position-absolute  progress-move" style='color:white'>{{$percent}}%</small>
                                </div>
                                @endif
                            </td>
                            @endforeach
                            

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>

    $(document).ready(function () {
        jQuery('.js-dataTable-simple').DataTable();
    });

</script>


@endsection

