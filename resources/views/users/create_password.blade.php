@extends('layouts.backend')

@section('content')
<!-- Hero -->

<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Create Password</h1>
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item">Users</li>
                    <li class="breadcrumb-item active" aria-current="page">Create Password</li>
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
            <form action="{{$user_data->password_url}}" method="POST" id="form-validate" name="form-validate" >
                {{ csrf_field() }}
                <h2 class="content-heading pt-0">User Details</h2>
                <div class="row">
                    <div class="col-lg-12">
                        <p class="text-muted">
                            Personal
                        </p>

                        <div class="form-group">
                            <label for="name">
                                Password <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="password" name="password" placeholder="Set Your Password">
                            <input type="hidden" class="form-control" id="guid" name="id" value="{{$user_data->password_url}}">
                        </div>
                    </div>
                </div>
                <!-- Submit -->
                <div class="row push">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-success" style="float:right">
                                <i class="fa fa-check-circle mr-1"></i> Save
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
                password: "required",
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

    });

</script>

@endsection
