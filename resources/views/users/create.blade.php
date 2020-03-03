@extends('layouts.backend')

@section('content')
<!-- Hero -->

<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Create User</h1>
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item">Users</li>
                    <li class="breadcrumb-item active" aria-current="page">Create</li>
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
            <form action="{{ route('usersSave') }}" method="POST" id="form-validate" name="form-validate" >
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
                            <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                        </div>

                        <div class="form-group">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <input class="form-control" id="description" name="email" placeholder="Email">
                        </div>

                        <div class="form-group">
                            <label for="business_number">
                                Business Number 
                            </label>
                            <input type="text" class="form-control" id="business_number" name="business_number" placeholder="Tel.">
                        </div>

                        <div class="form-group">
                            <label for="mobile_number">
                                Mobile Number 
                            </label>
                            <input type="text" class="form-control" id="mobile_number" name="mobile_number" placeholder="Tel.">
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
                            <option value="Customer">Customer</option>
                            <option value="Consultant">Consultant</option>
                            <option value="Administrator">Administrator</option>
                        </select>

                        <div class="spacer"></div>

                        <label for="primary_user">
                            Primary User <span class="text-danger">*</span>
                        </label>
                        
                        <select class="custom-select" id="primary_user" name="primary_user">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>

                        <div class="spacer"></div>

                        <label for="projects">
                            Project(s) <span class="text-danger">*</span>
                        </label>

                        <select class="multiple-select" id="projects" name="projects[]" multiple="multiple">
                            @foreach($projects as $project)
                            <option value="{{$project->id}}">{{$project->name}}</option>
                            @endforeach
                        </select>

                    </div>
                </div>

                <!-- Submit -->
                <div class="row push">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-success" style="float:right">
                                <i class="fa fa-check-circle mr-1"></i> Create User
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
                projects: {required: true}
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

});
</script>

@endsection
