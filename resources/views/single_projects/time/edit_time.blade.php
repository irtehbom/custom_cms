@extends('layouts.backend')
@section('content')

<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Edit Time for {{$project->name}}</h1>
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
    <div class="block">

        <div class="block-header block-header-default">
            <h3 class="block-title">Create Time Entry</h3>
            <div class="block-options">
                <button type="button" class="btn-block-option" data-toggle="block-option" data-action="fullscreen_toggle"></button>
            </div>
        </div>

        <form action="{{route('timeEditSave', [$project->id, $time->id])}}" method="post" id="form-validate" name="form-validate" >
            {{ csrf_field() }}
            <div class="row">
                <div class="col-sm-6">

                    <div class="block-content">
                        <div class="form-group">
                            <label>Title</label>
                            <input value="{{$time->title}}" type="text" class="form-control" id="title" name="title" placeholder="Title">
                        </div>
                        <div class="form-group">
                            <label>Date</label>
                            <div id="datepicker" class="input-group date" data-date-format="d/m/yyyy">
                                <input class="form-control" name="date" type="text" value="{{$time->date}}" />
                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="block-content">
                        <label>Description</label>
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <textarea id="js-ckeditor" name="description">{{$time->description}}</textarea>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-sm-6">

                    <div class="block-content">
                        <div class="form-group">
                            <label>Hours</label>
                            <input value="{{$time->hours}}" type="text" class="form-control" id="hours" name="hours" placeholder="Hours">
                        </div>
                        <div class="form-group">
                            <label>Minutes</label>
                            <input value="{{$time->minutes}}" type="text" class="form-control" id="minuites" name="minuites" placeholder="Minuites">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-hero-primary">
                                <i class="fa fa-reply mr-1"></i> Log Time
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </form>   

    </div>
</div>

<script>
    jQuery(function () {

        $("form[name='form-validate']").validate({
            errorElement: 'div',
            // Specify validation rules
            rules: {
                hours: "required",
                minuites: "required",
                title: "required",
                date: "required"
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


        $("#datepicker").datepicker({
            autoclose: true,
            todayHighlight: true,
        }).datepicker('update', new Date());

        $("#datepicker").datepicker("setDate", "{{$time->date->format('d/m/Y')}}");
        
        console.log(new Date());

        CKEDITOR.replace('js-ckeditor');
    });
</script>

@endsection
