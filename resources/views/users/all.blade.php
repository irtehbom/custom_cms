@extends('layouts.backend')

@section('content')
<!-- Hero -->

<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">All Users</h1>
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item">Users</li>
                    <li class="breadcrumb-item active" aria-current="page">All</li>
                </ol>
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
        <div class="block-content">
            <!-- Dynamic Table Simple -->
                <div class="block-content block-content-full">
                    <!-- DataTables init on table by adding .js-dataTable-simple class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
                    <table class="table table-bordered table-striped table-vcenter js-dataTable-simple">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Business Number</th>
                                <th>Mobile Number</th>
                                <th>Primary</th>
                                <th>Project(s)</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $pageData)
                                <tr>
                                    <td><a href="/dashboard/users/edit/{{$pageData->id}}">{{$pageData->name}}</a></td>
                                     <td>{{$pageData->email}}</td>
                                     <td>{{$pageData->business_number}}</td>
                                     <td>{{$pageData->mobile_number}}</td>
                                     <td>
                                         @if($pageData->primary_user)
                                            Yes
                                         @else
                                            No
                                         @endif
                                     </td>
                                     <td>
                                         @if(count($pageData->projects()->get()) > 0)
                                            @foreach($pageData->projects()->get() as $project)
                                                <a href="/dashboard/projects/edit/{{$project->id}}">{{$project->name}}</a> 
                                                @if(!$loop->last) 
                                                |
                                                @endif
                                                @endforeach
                                         @endif
                                     </td>
                                     <td>
                                         <a href="/dashboard/users/edit/{{$pageData->id}}"><span class="badge badge-info">Edit</span></a>
                                     </td>
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
