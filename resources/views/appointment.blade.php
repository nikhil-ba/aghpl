<!DOCTYPE html>
<html>
<head>
<title>Meeting Scheduler</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
 	<!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/custom.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href=" http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css">
    
</head>
<body>
<div class="container">
<div class="row border" style="padding:20px;">
<div class="col-sm-6">
	<div style="padding:20px;">
		<div><a href="/scheduler/{{$user_id}}"><i class="fa fa-arrow-left fa-2x" aria-hidden="true" style="color:#337ab7;border:2px solid #337ab7;border-radius:30px;"></i></a></div>
		<div class="info"><span><i class="fa fa-user fa-1x" aria-hidden="true" style="color:#337ab7"></i>&nbsp;&nbsp;{{$name}}</span></div>
		<div class="info" style="font-size:30px;font-weight: bold;"><span><i class="fa fa-circle" style="color:#337ab7"></i>&nbsp;&nbsp;{{$event_type}}</span></div>
		<div class="info"><span><i class="fas fa-clock" style="color:#337ab7"></i>&nbsp;&nbsp;{{$duration}} Min</span></div>
	</div>
</div>
<div class="col-sm-6">
	<form method="POST" id="frm-appointment">
		<div style="font-size:30px;font-weight: bold;margin-bottom:20px">Select a Date & Time</div>
		<div id="datepicker" style="margin-bottom:30px;"></div>

		<div style="font-size:20px;margin-bottom:5px" id="lbl-app-type">Select Time Duration For Appointment</div>
		<div class="btn-group" role="group" aria-label="Basic example" id="duration-btn">
		</div>
		<input type="hidden" id="dt-btn-value"/>
		<button class="btn btn-primary pull-right" id="btn-next">Next</button>
	</form>
</div>
</div>
</div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="http://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
<script src="{{ asset('js/moment.js') }}" defer></script>
<script>

$(document).ready(function(){
$("#duration-btn").hide();
$("#lbl-app-type").hide();
var id = '<?php echo $user_id ?>';
var name = '<?php echo $name; ?>';
var event_type = '<?php echo $event_type; ?>';
var duration = <?php echo $duration; ?>;

var $datePicker = $("div#datepicker");
var d = new Date('2020-06-28 10:00:00');
var hr = d.getHours();

for(var z=10;z<19;z++){
	var mn = d.getMinutes();
	for(var c=0;c<4;c++){
		$('#duration-btn').append('<button type="button" class="btn btn-secondary btn-duration">'+hr+':'+mn+':00'+'</button>');
		mn+=15;
	}
	hr++;
}

$("#dt-group-btn button").click(function(e){
	$('#dt-btn-value').val(this.textContent)
})

$("div#datepicker").datepicker({
	changeMonth: true,
	changeYear: true,
	inline: true,
	altField: "#datep",
	dateFormat: 'yy-mm-dd',
	}).change(function(e){
		$("#duration-btn").show();
		$("#lbl-app-type").show();
	setTimeout(function(){   
	$datePicker
	.find('.ui-datepicker-current-day')
	.parent()
	.after();
	});
});

$("#duration-btn button").on('click',function(){
	var selected_date = $datePicker.val();
	var selected_date_time = new Date(selected_date+' '+this.textContent);
	
	var dt = new Date(selected_date+' '+this.textContent);
	var pre_dt = dt;
	var am_pm = '';
	am_pm = getAmPm(pre_dt.getHours())
	
	var dt_from = pre_dt.getHours()+':'+pre_dt.getMinutes()+am_pm;
	dt.setMinutes(dt.getMinutes() + duration);
	am_pm = getAmPm(pre_dt.getHours());
	var dt_to = dt.getHours()+':'+dt.getMinutes()+am_pm;
	this.timeslot = dt_from+'-'+dt_to;
	$('#dt-btn-value').val(this.timeslot);
	
});

$('#frm-appointment').submit(function(e){
	e.preventDefault();
	if($("#dt-btn-value").val() != ''){
		var selected_date = $datePicker.val();
		var timeslot = $('#dt-btn-value').val();
		var user_id = id;
		var data = {'appoinment_date':selected_date,'time_slot':timeslot,'user_id':user_id,'event_type':event_type};
		$.ajax({
			url:'/insert_appointment',
			headers: {
    			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  			},
			method:'post',
			data:data,
			success:function(response){
				var last_inserted_id = response.last_inserted_id;
				
				$(location).attr('href', '/appointment_user/'+name+'/'+event_type+'/'+duration+'/'+selected_date+'/'+timeslot+'/'+last_inserted_id+'/'+user_id);
			}
	});

	}else{
		alert('Select Time Duration For Appointment!');
	}
});
	
function getAmPm(hours){
	var am_pm = '';
	if(hours < 12){
		return am_pm = ' am';
	}else{
		return am_pm = ' pm';
	}
}
});
</script>
<style>
.info{
	padding: 10px;";
	margin:10px;
}
.btn-duration{
	background-color:white;
	color:black;border:2px solid #337ab7;
	margin-right:10px;
	height:50px;border-radius:0;
	color:#337ab7;
	margin-right:15px;
	margin-top:15px;
	width:100px
}
</style>
</html>