@extends('layouts.backend')
@section('content')

<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Edit User
                <span style="font-size:20px;position: relative;top: -3px;"><span style="color:black;">[ </span><span style="color:green;">{{$data->name}}</span><span style="color:black;"> ]</span></span>
            </h1>
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item">Users</li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
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
            <form action="{{ route('usersEditSave', $data->id) }}" id="form-validate" name="form-validate" method="POST">
                {{ csrf_field() }}
                <h2 class="content-heading pt-0">User Details</h2>
                <div class="row push">
                    <div class="col-lg-6">
                        <p class="text-muted">
                            Personal
                        </p>

                        <div class="form-group">
                            <label for="name">
                                Name <span class="text-danger">*</span>
                            </label>
                            <input value="{{$data->name}}" type="text" class="form-control" id="name" name="name" placeholder="Name">
                        </div>

                        <div class="form-group">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <input value="{{$data->email}}" class="form-control" id="description" name="email" placeholder="Email">
                        </div>

                        <div class="form-group">
                            <label for="business_number">
                                Business Number 
                            </label>
                            <input value="{{$data->business_number}}" type="text" class="form-control" id="business_number" name="business_number" placeholder="Tel.">
                        </div>

                        <div class="form-group">
                            <label for="mobile_number">
                                Mobile Number 
                            </label>
                            <input value="{{$data->mobile_number}}" type="text" class="form-control" id="mobile_number" name="mobile_number" placeholder="Tel.">
                        </div>

                    </div>
                    <div class="col-lg-6">

                        <p class="text-muted">
                            Settings
                        </p>

                        <label for="level">
                            User Level <span class="text-danger">*</span>
                        </label>

                        <select class="custom-select" id="level" name="level">
                            @foreach ($roles as $role)    
                            @if($data->roles->first()->id == $role->id)
                            <option selected value="{{$data->roles->first()->id}}">{{$data->roles->first()->name}}</option>
                            @else
                            <option value="{{$role->id}}">{{$role->name}}</option>
                            @endif
                            @endforeach
                        </select>

                        <div class="spacer"></div>

                        <label for="primary_user">
                            Primary User <span class="text-danger">*</span>
                        </label>
                        <select class="custom-select" id="primary_user" name="primary_user">
                            @if($data->primary_user)
                            <option selected value="1">Yes</option>
                            <option value="0">No</option>
                            @else
                            <option selected value="0">No</option>
                            <option value="1">Yes</option>
                            @endif
                        </select>

                        <div class="spacer"></div>

                        <label for="projects">
                            Project <span class="text-danger">*</span>
                        </label>
                        <select class="custom-select" id="projects" name="projects[]" multiple="multiple">
                            @foreach($projects as $project)
                            @if($data->projects()->get()->contains($project->id))
                            <option selected="selected" value="{{$project->id}}">{{$project->name}}</option>
                            @else
                             <option value="{{$project->id}}">{{$project->name}}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Submit -->
                <div class="row push">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-success" style="float:right">
                                <i class="fa fa-check-circle mr-1"></i> Save User
                            </button>
                        </div>
                    </div>
                </div>
                <!-- END Submit -->
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {

        $("form[name='form-validate']").validate({
            errorElement: 'div',
            // Specify validation rules
            rules: {
                // The key name on the left side is the name attribute
                // of an input field. Validation rules are defined
                // on the right side
                email: "required",
                name: "required",
                level: "required",
                projects: "required"
            },
            // Specify validation error messages
            messages: {
            },
            // Make sure the form is submitted to the destination defined
            // in the "action" attribute of the form when valid
            submitHandler: function (form) {
                form.submit();
            }
        });

        $('#projects').multiselect();

    });
</script>

@endsection
