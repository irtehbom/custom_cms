@extends('layouts.backend')

<link rel="stylesheet" href="https://fullcalendar.io/releases/core/4.2.0/main.min.css">
<link rel="stylesheet" href="https://fullcalendar.io/releases/daygrid/4.2.0/main.min.css">
<link rel="stylesheet" href="https://fullcalendar.io/releases/timegrid/4.2.0/main.min.css">


@section('content')
<!-- Hero -->
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Project Planning</h1>
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" aria-current="page">Dashboard</li>
                    <li class="breadcrumb-item active">Planning</li>
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
    <div class="row">
        <div class="col-lg-12">
            <div class="block block-rounded block-bordered">
                <div class="block-header block-header-default">
                    <div id='calendar'></div>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="block block-rounded block-bordered">
                <div class="block-header block-header-default">
                    <button type="button" id="savePlanning" class="btn btn-success">Save</button>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="modal" id="taskDiaglog" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add Tasks for <span id="userName"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <label for="project">
                    Select Project <span class="text-danger"></span>
                </label>
                <select class="custom-select" id="projectSelect" name="project">
                    @foreach($projects as $project)
                    <option value="{{$project->id}}">{{$project->name}}</option>
                    @endforeach
                </select>

                <div class="spacer"></div>

                <label for="task">
                    Select Task <span class="text-danger"></span>
                </label>
                <select class="custom-select" id="task" name="task">
                    <option value="1">Link Building</option>
                    <option value="2">SEO</option>
                    <option value="3">Citations</option>
                    <option value="4">Development</option>
                </select>

                <div class="spacer"></div>

                <div class="form-group">
                    <label for="notes">Notes</label>
                    <textarea class="form-control" id="ckeditor" name="notes" rows="6" placeholder="Notes"></textarea>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" id="addEvent" class="btn btn-primary">Add Event</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="notesDialog" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Notes</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <div id="projectNameContainer" style="font-weight:bold">Project: <span id="projectName" style="font-weight:300"></span></div>
                <div id="taskNameContainer" style="font-weight:bold">Task: <span id="taskName" style="font-weight:300"></span></div>

                <hr>

                <div class="form-group">
                    <div id="event-notes"></div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="http://momentjs.com/downloads/moment.js"></script>
<script src="{{ asset('js/plugins/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
<script src="{{ asset('js/fullcalander_main.js') }}"></script>
<script src="https://fullcalendar.io/releases/daygrid/4.2.0/main.min.js"></script>
<script src="https://fullcalendar.io/releases/timegrid/4.2.0/main.min.js"></script>
<script src="https://fullcalendar.io/releases/resource-common/4.2.0/main.min.js"></script>
<script src="https://fullcalendar.io/releases/resource-daygrid/4.2.0/main.min.js"></script>
<script src="https://fullcalendar.io/releases/resource-timegrid/4.2.0/main.min.js"></script>
<script src="https://fullcalendar.io/releases/interaction/4.2.0/main.min.js"></script>
<script src="https://unpkg.com/tooltip.js/dist/umd/tooltip.min.js"></script>


<script>


document.addEventListener('DOMContentLoaded', function () {

    CKEDITOR.replace('ckeditor');
    
    var calendarEl = document.getElementById('calendar');
    
    var calendar = new FullCalendar.Calendar(calendarEl, {
        
        header: {
          left: 'prev,next',
          center: 'title',
          right: 'resourceTimeGridDay,resourceTimeGridWeek'
        },
        
        plugins: ['resourceTimeGrid', 'interaction', ],
        selectable: true,
        timeZone: 'UTC',
        locale: false,
        locales: false,
        resources: [
            @foreach($users as $user)
                {id: '{{$user->id}}', title: '{{$user->name}}'},
            @endforeach
        ],
        events: [
            @foreach($planningData as $data)
                {
                    resourceId: '{{$data->user_id}}',
                    title: '{{$data->title}}',
                    start: '{{$data->start_date}}',
                    end: '{{$data->end_date}}',
                    projectName: '{{$data->title}}',
                    projectID: '{{$data->project_id}}',
                    taskName: '{{$data->task_name}}',
                    taskID: '{{$data->task_id}}',
                    notes: '{!!$data->notes!!}',
                    guid: '{{$data->guid}}'
                },
             @endforeach
        ],
        editable: false,
        droppable: true, // this allows things to be dropped onto the calendar
        businessHours: true,
        defaultView: 'resourceTimeGridDay',
        minTime: '09:00:00',
        maxTime: '17:30:00',
        slotDuration: '00:30:00',
        slotLabelInterval: 30,
        slotMinutes: 30,
        weekends: false,
        editable: true,
        allDaySlot: false,
        eventOverlap: false,
        slotEventOverlap: false,
        select: function (arg) {

            var userID = arg.resource.id;
            var userName = arg.resource.title;
            //var date = new Date('2019-06-13' + 'T00:00:00'); // will be in local time

            $('#userName').empty();
            $('#userName').text(userName);
            $('#taskDiaglog').modal('show');
            
            $("#addEvent").click(function () {

                var projectID = $('#projectSelect :selected').val();
                var projectName = $('#projectSelect :selected').text();
                var taskID = $('#task :selected').val();
                var taskName = $('#task :selected').text();
                var notes = CKEDITOR.instances['ckeditor'].getData();
                if (!isNaN(arg.start.valueOf())) {
                    calendar.addEvent({
                        resourceId: userID,
                        start: arg.start,
                        title: projectName,
                        end: arg.end,
                        allDay: false,
                        overlap: false,
                        projectName: projectName,
                        projectID: projectID,
                        taskName: taskName,
                        taskID: taskID,
                        notes: notes,
                        guid:create_UUID(),
                        constraint: {
                            resourceId: userID // constrain dragging to these
                        }
                    });
                }

                $('#taskDiaglog').modal('hide');
                $("#addEvent").off("click");
            });
            
        },
        eventClick: function (info) {

            var projectName = info.event.extendedProps.projectName;
            var notes = info.event.extendedProps.notes;
            var taskName = info.event.extendedProps.taskName;
            if (notes != "") {
                $('#event-notes').html(notes);
                $('#projectName').html(projectName);
                $('#taskName').html(taskName);
                $('#notesDialog').modal('show');
            }

        },
        eventClickInfo: function (stillEvent, movingEvent) {

            return stillEvent.allDay && movingEvent.allDay;
        },
        eventRender: function (info) {

            var eventContent = $(info.el).find(".fc-content");
            var eventTitle = $(info.el).find(".fc-title");
            var projectName = info.event.extendedProps.projectName;
            var taskName = info.event.extendedProps.taskName;
            var notes = info.event.extendedProps.notes;
            $(eventTitle).after('<div id="fc-task"><strong>Task: </strong>' + taskName + '</div>');
            if (notes != "") {
                var task = $(info.el).find("#fc-task");
                $(task).after('<div id="fc-notes"><i class="fa fa-info-circle"></i></div>');
            }

        }

    });
    
    calendar.render();
    
    $("#savePlanning").click(function () {

        var calanderData = calendar.getEvents();
        calanderEventsArr = [];
        
        $.each(calanderData, function (key, value) {
            calanderEventsArr.push({
                data: value._def,
                instance: value._instance,
                start: value._instance.range.start.toUTCString(),
                end: value._instance.range.end.toUTCString(),
            });
        });
        
        console.log(calanderEventsArr);
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        jQuery.ajax({
            url: "{{ route('planningViewSave') }}",
            method: 'post',
            data: {
                calanderData: calanderEventsArr,
            },
            success: function (result) {
                //Dashmix.helpers('notify', {type: 'success', icon: 'fa fa-check mr-1', message: type + ' Saved'});
            },
            error: function (request, status, error) {
                console.log(error);
            }
        });
        
    });
    
});

function create_UUID(){
    var dt = new Date().getTime();
    var uuid = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
        var r = (dt + Math.random()*16)%16 | 0;
        dt = Math.floor(dt/16);
        return (c=='x' ? r :(r&0x3|0x8)).toString(16);
    });
    return uuid;
}


</script>

@endsection

