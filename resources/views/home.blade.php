@extends('layouts.app') 

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="padding-top:20px;padding-bottom:20px;">My Schedule&nbsp;&nbsp;<i class="fas fa-arrow-down" style="color:#337ab7;"></i></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div role="tabpanel">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#tab1" aria-controls="tab1" role="tab" data-toggle="tab">Event Types</a></li>
                            <li role="presentation"><a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab">Scheduled Events</a></li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content" style="margin-top:10px;">
                            <div role="tabpanel" class="tab-pane active" id="tab1">
                               <div class="container">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <span>My Link</span><br>
                                        <a href="/scheduler/{{ Auth::user()->id }}">appointment.com/{{ Auth::user()->name }}-bookings</a>
                                    </div>
                                    <div class="col-sm-6">
                                        <a href="/insertEvents"><button type="button" class="btn btn-default" style="border:2px solid #337ab7;color:#337ab7;float:right;">+ New Event Type</button></a>
                                    </div>
                                </div>
                                <hr/>
                                <div id="event_deleted" style="color:red;">
                                        Event Deleted Successfully
                                </div>
                                <div class="row" id="eventType">

                                </div>
                            
                               </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="tab2">
                                <div class="container">
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li role="presentation" class="active"><a href="#tab21" aria-controls="tab21" role="tab" data-toggle="tab">Upcoming</a></li>
                                        <li role="presentation"><a href="#tab22" aria-controls="tab22" role="tab" data-toggle="tab">Past</a></li>
                                    </ul>
                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="tab21">
                                            <div class="panel-css">
                                                <div class="table-responsive">
                                                <table class="table" id="tbl-schedule1">
                                                    
                                                </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div role="tabpanel" class="tab-pane" id="tab22">
                                            <div class="panel-css">
                                                <div class="table-responsive">
                                                <table class="table" id="tbl-schedule2">
                                                    
                                                </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="{{ asset('js/custom.js') }}"></script>
<script>
$(document).ready(function(){
$("#event_deleted").hide();

if((getUrlVars()["action"]) == 'event_deleted'){
    $("#event_deleted").show();
    setTimeout(function(){
        $("#event_deleted").hide();
        $(location).attr('href','/home');
    },5000);
}

$.ajax({
    url:"/api/getEvent",
    method:'GET',
    success:function(data){
    for(var i=0;i<data.data.length;i++){
    (function(){ 
    var x = $('#etype'+i);
    $("#eventType").append('<div class="col-sm-3" id="etype'+i+'" style="border-top:4px solid #337ab7 !important;border:1px solid grey;margin-right:30px;height:200px;padding-top:8px;margin-bottom:20px;"></div>');
        $("#etype"+i).append('<div  style="position:absolute;bottom:100px;font-style:bold;font-size:20px;">'+data.data[i].event_name+'</div><br><div style="position:absolute;bottom:80px">'+data.data[i].event_duration+' Mins</div><div style="position:absolute;bottom:10px"><a href="/insertEvents?action=edit&id='+data.data[i].id+'"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;<a href="/deleteEvents?action=delete&id='+data.data[i].id+'"><i class="fas fa-trash-alt"></i></a></div>');
        })()
    }
    }
});

$.ajax({
    url:'/getDistictDate',
    method:'GET',
    success:function(response){
    for(var i=0;i<response.data.length;i++){
    var d = new Date(response.data[i].appoinment_date);
    var CurrentDate = new Date();
    var app_type = '';
    var tbl_schedule;
    if(d < CurrentDate){
    app_type = 'past';
    tbl_schedule = 2;

    }else{
    app_type = 'upcoming';
    tbl_schedule = 1;
    }

    (function(){
    var event_dt = new Date(response.data[i].appoinment_date);
    yr      = event_dt.getFullYear(),
    month   = event_dt.getMonth() < 10 ? '0' + event_dt.getMonth() : event_dt.getMonth(),
    day     = event_dt.getDate()  < 10 ? '0' + event_dt.getDate()  : event_dt.getDate(),
    newDate = yr + '-' + month + '-' + day;

    var weekday = getWeekDays(event_dt.getDay());
    var month = getMonthName(event_dt.getMonth());

    var printDate = weekday+','+day+' '+month+' '+yr;
    $('#tbl-schedule'+tbl_schedule).append(
    '<tr id="app-dt'+i+'"><td style="margin-bottom:40px;">'+printDate+'</td></tr>'
    );

    var counter = i;
    var app_dt = response.data[i].appoinment_date
    $.ajax({
        url:'/getEventByDate',
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method:'GET',
        data:{'app_date':response.data[i].appoinment_date,'app_type':app_type},
        success:function(response){
        console.log(response.app_type);
        for(var j=0;j<response.data.length;j++){
        if(response.app_type == 'upcoming'){
        console.log(app_dt);
        if(app_dt == response.data[j].appoinment_date){
            $('<tr class="tbl-tr-content"><td><i class="fa fa-circle">&nbsp&nbsp'+response.data[j].time_slot+'</td><td>'+response.data[j].fname+' '+response.data[j].lname+'<br> Event Type :'+response.data[j].event_type+'</td></tr>').insertAfter('#app-dt'+counter);
            }
        }

        if(response.app_type == 'past'){
            if(app_dt == response.data[j].appoinment_date){
            $('<tr class="tbl-tr-content"><td>'+response.data[j].time_slot+'</td><td>'+response.data[j].fname+response.data[j].lname+'<br> Event Type :'+response.data[j].event_type+'</td></tr>').insertAfter('#app-dt'+counter);
            }
        }
    }
    }
    });
    })()
    }
}
});


});
</script>
<style>
.panel-css{
    margin-top:25px;
    position:relative;
    width:80%;
}
.tbl-tr-content{
    margin-bottom:7px;
    position:relative;
    padding:30px;
    margin-bottom:10px;
    background-color:#337ab7;
    color:#ffffff;
}
</style>


