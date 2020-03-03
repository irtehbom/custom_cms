@extends('layouts.backend')

@section('content')
<!-- Hero -->

<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Outreach for {{$project->name}}</h1>
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                @include('partials.links_header')
            </nav>
        </div>
        <div class="spacer"></div>
    </div>
</div>
<!-- END Hero -->

<div class="content">
    <div class="block block-rounded block-bordered">
        <div class="block-header block-header-default">
            @include('partials.outreach_links')
            <div class="pull-right">
                <a href="/dashboard/project/{{$project->id}}/guest-post-pipeline/sourcing-analysing/add" type="button" class="btn-block-option mr-2">
                    <i class="fa fa-plus mr-1"></i> Add Prospect(s)
                </a>
            </div>
        </div>
    </div>
</div>
<!-- Page Content -->
<div class="content">
    <div class="block block-rounded block-bordered">

        <div class="block-header block-header-default">
            <h3 class="block-title">Sourcing & Analysing</h3>
            <div class="block-options">
                <button id="copyToClipboard" class="btn btn-default pull-right">
                    <i class="fa fa-copy mr-1"></i> Copy To Clipboard
                </button>
                <button id="copyToExcel" class="btn btn-default pull-right">
                    <i class="fa fa-copy mr-1"></i> Copy To Excel
                </button>
                
            </div>
        </div>

        <div class="content content-full time-table">
            <table class='table' id='datatable' style="table-layout: unset;">
                <thead>
                    <tr class="hide-head">
                        <th>Domain</th>
                        <th>Path</th>
                        <th>Category</th>
                        <th>Stage</th>
                        <th>Date Added</th>
                    </tr>
                </thead>
                @if(isset($domains))
                <tbody id='data'>
                    @foreach ($domains as $domain)
                    <tr>
                        <td id='hidden-id' class="hidden-id" style="display:none;">{{$domain->id}}</td>
                        <td class="host" id='host'>
                            <div class="host-modal" id="host-modal-id-{{$domain->id}}" data-id="{{$domain->id}}" data-domain-root-notes="<a target='_blank' href='{{$domain->scheme}}://{{$domain->root_domain}}'>{{$domain->scheme}}://{{$domain->root_domain}} </a>" data-domain-path-notes="<a target='_blank' href='{{$domain->scheme}}://{{$domain->root_domain}}{{$domain->url}}'>{{$domain->url}}</a>" data-domain="{{$domain->root_domain}}" data-notes="{{$domain->notes}}">
                                {{$domain->root_domain}}
                            </div>
                            <a target="_blank" href='{{$domain->scheme}}://{{$domain->root_domain}}'> 
                                <i class="fas fa-external-link-alt"></i>
                            </a>
                        </td>
                        <td class="path" id='path'><a target="_blank" href='{{$domain->scheme}}://{{$domain->root_domain}}{{$domain->url}}'>{{$domain->url}}</a></td>
                        <td id='category' class="category">
                            <select class="custom-select" id="Category" name="category" data-id="{{$domain->id}}">
                                @foreach($category as $key => $value)
                                @if($domain->category == $key)
                                <option selected value="{{$key}}">{{$value}}</option>
                                @else
                                <option value="{{$key}}">{{$value}}</option>
                                @endif
                                @endforeach
                            </select>
                        </td>
                        <td id='stage' class="stage" data->
                            <select class="custom-select" id="Stage" name="stage" data-id="{{$domain->id}}">
                                @foreach($stage as $key => $value)
                                @if($domain->stage == $key)
                                <option selected value="{{$key}}">{{$value}}</option>
                                @else
                                <option value="{{$key}}">{{$value}}</option>
                                @endif
                                @endforeach
                            </select>
                        </td>
                        <td class="date">{{$domain->created_at->format('d/m/Y')}}</td>

                    </tr>
                    @endforeach
                </tbody>
                @endif
            </table> 
         
        </div>

    </div>
</div>

<aside id="side-overlay" style="width:50%">
    <div class="bg-image" style="background-image: url('{{ asset('media/various/bg_side_overlay_header.jpg') }}');">
        <div class="bg-primary-op">
            <div class="content-header">
                <div class="ml-2">
                    <a class="text-white font-w600" href="javascript:void(0)">Notes on <span id="domain-name"></span></a>
                    <div class="text-white-75 font-size-sm font-italic"></div>
                </div>
                <a class="ml-auto text-white" href="javascript:void(0)" data-toggle="layout" data-action="side_overlay_close">
                    <i class="fa fa-times-circle"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="content-side">
        <div class="row">
            <div class="col-md-12">
                <small>
                    <strong>Root Path:</strong>
                    <span id="root-domain-notes">

                    </span>
                </small>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <small>
                    <strong>Domain Path:</strong>
                    <span id="root-path-notes">

                    </span>
                </small>
            </div>
        </div>
        <div class="spacer"></div>
        <div class="row">
            <div class="col-md-11">
                <p id="domain-notes"></p>
            </div>
            <div class="col-md-1">
                <i id="edit-button-outreach" class="far fa-edit" style="pull-right"></i>
            </div>
        </div>
        <button id="notes-submit" data-domain="" class="btn btn-success pull-right">
            <i class="fa fa-check-circle mr-1"></i> Update
        </button>
    </div>
</aside>

<script src="//cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>

<script>
$(document).ready(function () {
    
    $('select').on('change', function () {

        var id = $(this).attr('data-id');
        var type = $(this).attr('id');
        var value = $(this).val();
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        jQuery.ajax({
            url: "{{ route('saveDomainDetails',$project->id) }}",
            method: 'post',
            data: {
                projectID: "{{$project->id}}",
                id: id,
                type: type,
                value: value
            },
            success: function (result) {
               Dashmix.helpers('notify', {type: 'success', icon: 'fa fa-check mr-1', message: type + ' Saved'});
            },
            error: function (request, status, error) {
                console.log(error);
            }
        });
    });
    
});

var ckeditor = null;


jQuery('#copyToClipboard').click(function (e) {
    e.preventDefault();
    copyToClipBoard();
});

jQuery('#copyToExcel').click(function (e) {
    e.preventDefault();
    copyToExcel();
});

jQuery('.host-modal').click(function (e) {

    var id = $(this).attr('data-id');
    var domain = $(this).attr('data-domain');
    var notes = $(this).attr('data-notes');
    var domainRoot = $(this).attr('data-domain-root-notes');
    var domainPath = $(this).attr('data-domain-path-notes');


    $('#domain-name').empty();
    $('#domain-notes').empty();
    $('#root-domain-notes').empty();
    $('#root-path-notes').empty();

    $('#domain-name').text(domain);
    $('#notes-submit').attr('data-domain', id);

    $('#root-domain-notes').append(domainRoot);
    $('#root-path-notes').append(domainPath);

    if (notes != '') {
        $('#domain-notes').append(notes);
        $('#edit-button-outreach').show();
    } else {
        $('#domain-notes').append('<textarea id="ckeditor" name="message"></textarea>');
        ckeditor = CKEDITOR.replace('ckeditor');
        $('#edit-button-outreach').hide();
    }

    Dashmix.layout('side_overlay_toggle');

});

jQuery('#notes-submit').click(function (e) {

    var id = $(this).attr('data-domain');
    var notes = ckeditor.getData();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    jQuery.ajax({
        url: "{{ route('saveDomainNotes',$project->id) }}",
        method: 'post',
        data: {
            projectID: "{{$project->id}}",
            id: id,
            notes: notes
        },
        success: function (result) {
            ckeditor.destroy();
            $('#domain-notes').empty();
            $('#domain-notes').append(notes);
            $('#edit-button-outreach').show();

            if (notes == '') {
                $('#domain-notes').append('<textarea id="ckeditor" name="message"></textarea>');
                ckeditor = CKEDITOR.replace('ckeditor');
                $('#edit-button-outreach').hide();
            }

            $('#host-modal-id-' + id).attr('data-notes', notes);

        },
        error: function (request, status, error) {
            console.log(error);
        }
    });

});

jQuery('#edit-button-outreach').click(function (e) {
    $(this).hide();
    var notes = $('#domain-notes').text();
    $('#domain-notes').empty();
    $('#domain-notes').append('<textarea id="ckeditor" name="message">' + notes + '</textarea>');
    ckeditor = CKEDITOR.replace('ckeditor');
});


function copyToClipBoard() {

    var domains = [];
    var domainsString = '';

    jQuery('#datatable > tbody  > tr').each(function () {
        var host = $(this).find('#host').text();
        domains.push(host);
    });

    $(domains).each(function () {
        domainsString += this + "\r\n";
    });

    $('<textarea>').val(domainsString).appendTo('body').select();

    document.execCommand('copy');

}

function copyToExcel() {

    $("#datatable").table2excel({
        exclude: ".path, .hidden-id, .date, .status, .hide-head",
        name: "{{$project->name}}",
        filename: "{{$project->name}} Sourcing Data" //do not include extension
    });

}

</script>

@endsection
