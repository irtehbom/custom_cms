@extends('layouts.backend')

@section('content')
<!-- Hero -->

<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Messages for {{$project->name}}</h1>
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
    <!-- Topics -->
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Messages</h3>
            <div class="block-options">
                <a href="/dashboard/project/{{$project->id}}/messages/create" type="button" class="btn-block-option mr-2">
                    <i class="fa fa-plus mr-1"></i> New Message
                </a>
                <button type="button" class="btn-block-option" data-toggle="block-option" data-action="fullscreen_toggle"></button>
            </div>
        </div>
        <div class="block-content">
            <!-- Topics -->
            <table class="table table-striped table-borderless table-vcenter">
                <thead class="table-coloured">
                    <tr>
                        <th  colspan="2">All Messages</th>
                        <th  colspan="2" class="d-none d-md-table-cell">Posted On</th>
                    </tr>
                </thead>
                <tbody>   
                    @foreach($threads as $thread)
                    <tr>
                        <td>
                            <a class="font-w600" href="{{route('singleProjectMessagesViewThread', [$project->id, $thread->id])}}">{{$thread->title}}</a> 

                            @if (Auth::user()->hasRole('Administrator') || Auth::user()->hasRole('Consultant'))
                                @if(!$thread->ws_read)
                                    <span class="nav-main-link-badge badge badge-pill badge-success">New</span>
                                @endif
                            @else
                                @if(!$thread->client_read)
                                    <span class="nav-main-link-badge badge badge-pill badge-success">New</span>
                                @endif
                            @endif

                            <div class="font-size-sm text-muted mt-1">
                                <em>{!!str_limit(strip_tags($thread->messages()->orderBy('updated_at', 'desc')->first()->message, 100))!!}</em>
                            </div>
                        </td>

                        <td class="d-none d-md-table-cell" colspan="3">
                            <span class="font-size-sm">by <strong>{{$thread->messages()->orderBy('updated_at', 'desc')->first()->user_name}}</strong><br><em>{{$thread->updated_at->toDayDateTimeString()}}</em></span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <nav aria-label="Topics navigation">
                <ul class="pagination justify-content-end">
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" aria-label="Previous">
                            <span aria-hidden="true">
                                <i class="fa fa-angle-left"></i>
                            </span>
                            <span class="sr-only">Previous</span>
                        </a>
                    </li>
                    <li class="page-item active">
                        <a class="page-link" href="javascript:void(0)">1</a>
                    </li>

                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" aria-label="Next">
                            <span aria-hidden="true">
                                <i class="fa fa-angle-right"></i>
                            </span>
                            <span class="sr-only">Next</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- END Pagination -->
        </div>
    </div>
    <!-- END Topics -->
</div>
<!-- END Page Content -->


@endsection
