<ol class="breadcrumb">
    <a class="btn btn-dual {{ request()->route()->getName() == 'singleProjectOverview' ? 'active' : ''  }}" href='/dashboard/project/{{$project->id}}/overview'>Overview</a>
    <a class="btn btn-dual {{ str_contains(url()->current(), 'messages') == true ? 'active' : ''  }}" href='/dashboard/project/{{$project->id}}/messages'>Messages</a>
    <a class="btn btn-dual {{ str_contains(url()->current(), 'time') == true ? 'active' : ''  }}" href='/dashboard/project/{{$project->id}}/time'>Time</a>
    <a class="btn btn-dual {{ str_contains(url()->current(), 'guest-post-pipeline') == true ? 'active' : ''  }}" href='/dashboard/project/{{$project->id}}/guest-post-pipeline/overview'>Guest Post Pipeline</a>
    <a class="btn btn-dual {{ request()->route()->getName() == 'filesView' ? 'active' : ''  }}" href='/dashboard/project/{{$project->id}}/files'>Files</a>
</ol>