@extends('layouts.backend')

@section('content')
<!-- Hero -->

<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Sourcing & Analysing for {{$project->name}}</h1>
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
                        <th>Analysed</th>
                        <th>Date Added</th>
                        <th>Status</th>
                    </tr>
                </thead>
                @if(isset($domains))
                <tbody id='data'>
                    @foreach ($domains as $domain)
                    <tr>
                        <td id='hidden-id' class="hidden-id" style="display:none;">{{$domain->id}}</td>
                        <td style="min-width:200px" class="host" id='host'><a target="_blank" href='{{$domain->scheme}}://{{$domain->root_domain}}'>{{$domain->root_domain}}</a></td>
                        <td style="min-width:200px" class="path" id='path'><a target="_blank" href='{{$domain->scheme}}://{{$domain->root_domain}}{{$domain->url}}'>{{$domain->url}}</a></td>
                        <td id='analysis' class="analysis">
                            <select class="custom-select" id="analysed" name="analysed">
                                @foreach($analysis as $key => $value)
                                @if($domain->analysed == $key)
                                <option selected value="{{$key}}">{{$value}}</option>
                                @else
                                <option value="{{$key}}">{{$value}}</option>
                                @endif
                                @endforeach
                            </select>
                        </td>

                        <td class="date">{{$domain->created_at->format('d/m/Y')}}</td>
                        <td id="status" class="status">
                            @if(isset($domain->updated_by_user))
                            <span class="badge badge-success">Updated</span>
                            @else
                            <span class="badge badge-danger">Not Updated</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                @endif
            </table> 
            <button type="submit" id="ajaxSubmit" class="btn btn-success pull-right">
                <i class="fa fa-check-circle mr-1"></i> Update
            </button>
        </div>

    </div>
</div>
@if (Session::has('domains_added') || Session::has('domains_exist') || Session::has('domains_flagged'))

<aside id="side-overlay" style="width:450px">
    <!-- Side Header -->
    <div class="bg-image" style="background-image: url('{{ asset('media/various/bg_side_overlay_header.jpg') }}');">
        <div class="bg-primary-op">
            <div class="content-header">


                <!-- User Info -->
                <div class="ml-2">
                    <a class="text-white font-w600" href="javascript:void(0)">Domain Details</a>
                    <div class="text-white-75 font-size-sm font-italic"></div>
                </div>
                <!-- END User Info -->

                <!-- Close Side Overlay -->
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                <a class="ml-auto text-white" href="javascript:void(0)" data-toggle="layout" data-action="side_overlay_close">
                    <i class="fa fa-times-circle"></i>
                </a>

                <!-- END Close Side Overlay -->
            </div>
        </div>
    </div>
    <!-- END Side Header -->

    <!-- Side Content -->
    <div class="content-side">
        <p>
            @if (Session::has('domains_added'))
        <div class="alert alert-success" role="alert">
            The following domains have been added
        </div>
        <div class="spacer"></div>
        @foreach(session('domains_added') as $domain)
        {!! $domain !!}<br>
        @endforeach
        @endif

        @if (Session::has('domains_exist'))
        <div class="spacer"></div>
        <div class="alert alert-warning" role="alert">
            The following Domains already exist
        </div>
        <div class="spacer"></div>
        @foreach(session('domains_exist') as $domain)
        {!! $domain !!}<br>
        @endforeach
        @endif

        @if (Session::has('domains_flagged'))
        <div class="spacer"></div>
        <div class="alert alert-danger" role="alert">
            The following domains have been flagged
        </div>
        <div class="spacer"></div>
        @foreach(session('domains_flagged') as $domain)
        {!! $domain !!}<br>
        @endforeach
        @endif
        </p>
    </div>
    <!-- END Side Content -->
</aside>

@endif

<script src="//cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>

<script>
$(document).ready(function () {
@if (Session::has('domains_added') || Session::has('domains_exist') || Session::has('domains_flagged'))
        Dashmix.layout('side_overlay_toggle');
@endif
});
</script>

<script>

jQuery('#ajaxSubmit').click(function (e) {
    e.preventDefault();
    getRowData();
});
jQuery('#copyToClipboard').click(function (e) {
    e.preventDefault();
    copyToClipBoard();
});
jQuery('#copyToExcel').click(function (e) {
    e.preventDefault();
    copyToExcel();
});
function getRowData() {

    Dashmix.layout('header_loader_on');
    jQuery('#datatable > tbody  > tr').each(function () {

        var id = $(this).find('#hidden-id').text();
        var host = $(this).find('#host').text();
        var path = $(this).find('#path').text();
        var analyses = $(this).find('#analysed option:selected').val();
        var status = $(this).find('#status');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery.ajax({
            url: "{{ route('GuestPostingPipelineSourcingAjax',$project->id) }}",
            method: 'post',
            data: {
                projectID: "{{$project->id}}",
                id: id,
                analyses: analyses
            },
            success: function (result) {

            },
            error: function (request, status, error) {
                console.log(error);
            }
        });
    });
    setTimeout(function () {
        Dashmix.layout('header_loader_off');
        window.location = window.location.pathname;
    }, 4000);
}

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

{!! Session::forget(['domains_added', 'domains_exist', 'domains_flagged']) !!}


@endsection
