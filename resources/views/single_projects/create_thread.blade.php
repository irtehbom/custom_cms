@extends('layouts.backend')
@section('content')


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
    <div class="block">

        <div class="block-header block-header-default">
            <h3 class="block-title">Create Message</h3>
            <div class="block-options">
                <button type="button" class="btn-block-option" data-toggle="block-option" data-action="fullscreen_toggle"></button>
            </div>
        </div>

        <form action="{{route('singleProjectMessagesCreateSave', $project->id)}}" id="upload" enctype="multipart/form-data" method="post" accept-charset="utf-8"  id="form-validate" name="form-validate">
            <div class="block-content">
                <div class="form-group">
                    <label>Subject</label>
                    <input value="" type="text" class="form-control" id="title" name="title" placeholder="Subject">
                </div>
            </div>
            <div class="block-content">         
                <label>Message</label>
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <td>
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <textarea id="ckeditor" name="message"></textarea>
                                </div>
                            <td>
                        </tr>
                        <tr>
                            <td>
                                <div class="dz-clickable" id="myDrop">
                                    <div class="dz-default dz-message" data-dz-message="">
                                        <span>Drop files or click here to upload</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-hero-primary">
                                        <i class="fa fa-reply mr-1"></i> Send Message
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </form>                           
    </div>
</div>

<script>
    jQuery(function () {

        CKEDITOR.replace('ckeditor');

        var dropzone = null;

        Dropzone.autoDiscover = false;

        $("#myDrop").dropzone({
            url: "{{route('singleProjectMessagesCreateSave', $project->id)}}",
            autoProcessQueue: false,
            createImageThumbnails: true,
            addRemoveLinks: true,
            uploadMultiple: true,
            parallelUploads: 10,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            init: function () {

                dropzone = this;
                dropzone.on("sending", function (file, xhr, formData, e) {
                    formData.append("message", CKEDITOR.instances['ckeditor'].getData());
                    formData.append("title", $('#title').val());

                });
            }
        });

        $("#myDrop").addClass("dropzone");


        $("form[name='form-validate']").validate({
            errorElement: 'div',
            // Specify validation rules
            rules: {
                message: "required",
                title: "required"
            },
            // Specify validation error messages
            messages: {
            },
            // Make sure the form is submitted to the destination defined
            // in the "action" attribute of the form when valid
            submitHandler: function (form) {

                if (dropzone != null && dropzone.getQueuedFiles().length > 0) {
                    dropzone.processQueue();
                    dropzone.on("success", function (file, responseText) {
                        window.location.replace(responseText);
                    });
                } else {
                     form.submit();
                }
            }
        });

    });

</script>

@endsection
