<ol class="breadcrumb">
    <a class="btn btn-dual {{ request()->route()->getName() == 'GuestPostingPipelineOverview' ? 'active' : ''  }}" href='/dashboard/project/{{$project->id}}/guest-post-pipeline/overview'>Overview</a>
    @if (Auth::user()->hasAnyRole(['Administrator','Consultant']))
    <a class="btn btn-dual {{ str_contains(url()->current(), 'sourcing-analysing') == true ? 'active' : ''  }}" href='/dashboard/project/{{$project->id}}/guest-post-pipeline/sourcing-analysing'>Sourcing & Analysing</a>
     <a class="btn btn-dual {{ str_contains(url()->current(), 'outreach') == true ? 'active' : ''  }}" href='/dashboard/project/{{$project->id}}/guest-post-pipeline/outreach'>Outreach</a>
     @endif
</ol>
