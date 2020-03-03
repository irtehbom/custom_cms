@extends('layouts.backend')
@section('content')

<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Files for {{$project->name}}</h1>
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
    <div class="row">
        <div class="col-lg-12">

            <div class="block block-rounded block-fx-shadow" >
                <div class="block-content block-content-full">
                    <h2 class="content-heading">All Files</h2>
                    <div class="row">
                        @foreach($files as $file)
                        <div class="col-sm-1 attachment-file text-center" data-id="{{$file->id}}">
                            <a href='{{$file->path}}' target='_blank' download>
                                <div class="attachment-image">
                                    <i class="fa fa-file"></i>
                                </div>
                                <div class="attachment-filename"><small>{{str_limit($file->originalName, 15)}}</small></div>
                            </a>
                            <span class='removeFile'>
                                <i style="font-size:24px;cursor:pointer" id="removeFile" class="fa fa-times" aria-hidden="true" data-file-id="{{$file->id}}"></i>
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="block block-rounded block-fx-shadow" >
                <div class="block-content block-content-full">
                    <h2 class="content-heading">Add New Files</h2>
                    <form action="{{route('fileUploadFilesView', [$project->id])}}" id="upload" enctype="multipart/form-data" method="post" accept-charset="utf-8"  id="form-validate" name="form-validate">
                        <div class="block-content">
                            <table class="table table-borderless">
                                <tbody>
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
                                                    <i class="fa fa-reply mr-1"></i> Upload
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

        </div>
    </div>
</div>

<script>
    jQuery(function () {

        var dropzone = null;

        Dropzone.autoDiscover = false;

        $('#myDrop').dropzone({
            url: "{{route('fileUploadFilesView', [$project->id])}}",
            autoProcessQueue: false,
            createImageThumbnails: true,
            addRemoveLinks: true,
            uploadMultiple: true,
            parallelUploads: 50,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            init: function () {
                dropzone = this;
                dropzone.on("sending", function (file, xhr, formData, e) {

                });
            }
        });

        $("#myDrop").addClass("dropzone");

        $("form[name='form-validate']").validate({
            errorElement: 'div',
            // Specify validation rules
            rules: {
                message: "required"
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

        $('.removeFile').click(function () {

            var file = $(this).children();
            var file_id = $(file).attr('data-file-id');
            Dashmix.layout('header_loader_on');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "{{ route('fileDelete',$project->id) }}",
                method: 'post',
                data: {
                    file_id: file_id
                },
                success: function (result) {
                    window.location.href = '/dashboard/project/{{$project->id}}/files';
                    Dashmix.layout('header_loader_off');
                },
                error: function (request, status, error) {
                    console.log(error);
                    Dashmix.layout('header_loader_off');
                }
            });
        });

    });
</script>

@endsection
