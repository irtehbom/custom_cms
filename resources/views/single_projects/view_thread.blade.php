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
            <h3 class="block-title" style="font-weight:600;font-size:26px">{{$thread->title}}</h3>
            <div class="block-options">
                <button type="button" class="btn-block-option" data-toggle="block-option" data-action="fullscreen_toggle"></button>
            </div>
        </div>
        
        <table class="table table-borderless table-fixed">
            @foreach($messages as $message)
            <tbody class="data-message" data-message="{{$message->id}}">
                <tr class="table-coloured">
                    <td class="d-none d-sm-table-cell"></td>
                    <td class="font-size-sm text-white">
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td class="d-none d-sm-table-cell text-center" style="width: 140px;">
                        <p>
                        <div class="circle-profile"><span class="profile-center">{{substr($message->user_name, 0, 1)}}</span></div>
                        </p>
                        <div class="user-name">By {{$message->user_name}}</div>
                        <p class="font-size-sm"><small> {{$message->created_at->toDayDateTimeString()}}</small></p>
                    </td>
                    <td colspan="" class="content-full">
                        <div class="message-area">
                            {!!$message->message!!}
                        </div>
                    </td>
                    <td colspan="" class="full-td">
                        <div class="edit-message-inline">
                            <i class="fa fa-edit edit-message"></i>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="d-none d-sm-table-cell"></td>
                    <td colspan="5" class="files-list">
                        <div class="row">

                            @if($message->files()->get()->isEmpty())
                            <div class="add-more-files col-sm-1">
                            </div>
                            @endif

                            @foreach($message->files()->get() as $files)

                            <div class="col-sm-1 attachment-file text-center" data-id="{{$files->id}}">
                                <a href='{{$files->path}}' target='_blank' download>
                                    <div class="attachment-image">
                                        <i class="fa fa-file"></i>
                                    </div>
                                    <div class="attachment-filename"><small>{{str_limit($files->originalName, 15)}}</small></div>
                                </a>
                                <span class='removeFile'></span>
                            </div>

                            @if($loop->last)
                            <div class="add-more-files col-sm-1">
                            </div>
                            @endif

                            @endforeach
                        </div>

                    </td>
                    <td>

                    </td>
                </tr>
                <tr>
                    <td class="d-none d-sm-table-cell"></td>
                    <td>
                        <div class="dropzone-add">
                        </div>
                    </td>

                </tr>
                <tr>
                    <td class="d-none d-sm-table-cell"></td>
                    <td>
                        <div class="saveCancel">
                        </div>
                    </td>
                    <td>
                    </td>
                </tr>
            </tbody>
            @endforeach
        </table>
        
        <div class="block-header block-header-default">
            <h3 class="block-title" style="font-weight:600;font-size:26px">Reply to this thread</h3>
        </div>


        <form action="{{route('singleProjectMessagesThreadSave', [$project->id, $thread->id])}}" id="upload" enctype="multipart/form-data" method="post" accept-charset="utf-8"  id="form-validate" name="form-validate">
            <div class="block-content">
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
                                        <i class="fa fa-reply mr-1"></i> Reply
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

        $('#myDrop').dropzone({
            url: "{{route('singleProjectMessagesThreadSave', [$project->id, $thread->id])}}",
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
                    formData.append("message", CKEDITOR.instances['ckeditor'].getData());
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
    });

    $('.edit-message').click(function () {

        $(this).hide();
        var editButton = $(this);
        var parent = $(this).closest('.data-message');
        var messageID = $(parent).attr('data-message');
        var messageArea = $(parent).find('.message-area');
        var saveCancel = $(parent).find('.saveCancel');
        var removeFile = $(parent).find('.removeFile');
        var addMoreFiles = $(parent).find('.add-more-files');
        var files = $(parent).find('.files-list');
        var filesList = files.html();
        var addDropZone = $(parent).find('.dropzone-add');
        var content = messageArea.html();
        var filesToRemove = [];
        var dropzoneDynamic = null;

        var textAreaHtml = '<div class="form-group text-area-remove"><textarea id="editcontent-' + messageID + '" name="message">' + content + '</textarea></div>';
        var saveCancelHtml = '<div class="form-group save-cancel-remove"><button type="submit" id="save-' + messageID + '" class="btn btn-hero-primary"><i class="fa fa-reply mr-1"></i> Save</button> <button type="submit" id="cancel-' + messageID + '" class="btn btn-hero-danger"><i class="fa fa-reply mr-1"></i> Cancel</button></div>';
        var removeFileHtml = '<i style="font-size:24px;cursor:pointer" id="removeFile-' + messageID + '" class="fa fa-times" aria-hidden="true"></i>';
        var addMoreFilesHtml = '<button type="submit" class="btn btn-sm btn-secondary" id="addMoreFiles-' + messageID + '">Add Files </button>';
        var addDropZoneHTML = '<div class="dz-clickable restyle-dropzone" id="dropZone-' + messageID + '"><div class="dz-default dz-message" data-dz-message=""><span>Drop files or click here to upload</span></div></div>';

        $(messageArea).empty();
        $(messageArea).append(textAreaHtml);
        CKEDITOR.replace('editcontent-' + messageID);

        $(saveCancel).append(saveCancelHtml);
        $(removeFile).append(removeFileHtml);
        $(addMoreFiles).append(addMoreFilesHtml);

        $('#save-' + messageID).click(function () {

            if (dropzoneDynamic != null && dropzoneDynamic.getQueuedFiles().length > 0) {

                dropzoneDynamic.processQueue();
                dropzoneDynamic.on("success", function (file, responseText) {
                    window.location.replace(responseText);
                });

            } else {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{route('singleProjectMessagesEdit', [$project->id, $thread->id])}}",
                    method: 'post',
                    data: {
                        message_id: messageID,
                        thread_id: '{{$thread->id}}',
                        project_id: '{{$project->id}}',
                        files_to_remove: filesToRemove,
                        message: CKEDITOR.instances['editcontent-' + messageID].getData()
                    },
                    success: function (result) {
                        window.location.replace(result);
                    }});
            }

        });

        $('#cancel-' + messageID).click(function () {
            $(editButton).show();
            $(messageArea).empty();
            $(saveCancel).empty();
            $(messageArea).append(content);
            $(removeFile).empty();
            $(files).empty();
            $(files).append(filesList);
            $(addMoreFiles).empty();
            $(addDropZone).empty();
            $(filesToRemove).empty();
        });

        $('#addMoreFiles-' + messageID).click(function () {

            if ($(this).text() !== 'Cancel') {

                $(this).text('Cancel');
                $(addDropZone).append(addDropZoneHTML);
                $('#dropZone-' + messageID).addClass("dropzone");

                $('#dropZone-' + messageID).dropzone({
                    url: "{{route('singleProjectMessagesEdit', [$project->id, $thread->id])}}",
                    autoProcessQueue: false,
                    createImageThumbnails: true,
                    addRemoveLinks: true,
                    uploadMultiple: true,
                    parallelUploads: 50,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    init: function () {
                        dropzoneDynamic = this;
                        dropzoneDynamic.on("sending", function (file, xhr, formData, e) {
                            formData.append("message", CKEDITOR.instances['editcontent-' + messageID].getData());
                            formData.append("files_to_remove", filesToRemove);
                            formData.append("message_id", messageID);
                            formData.append("thread_id", '{{$thread->id}}');
                            formData.append("project_id", '{{$project->id}}');
                        });
                    }
                });

            } else {
                $(this).text('Add More Files');
                $(addDropZone).empty();
            }

        });

        $('.removeFile').click(function () {
            var file = $(this).parent();
            var id = $(file).attr('data-id');
            filesToRemove.push(id);
            $(file).remove();
        });

    });


</script>

@endsection
