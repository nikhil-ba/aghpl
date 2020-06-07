<!DOCTYPE html>
<html>
<title>Meeting Scheduler</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
 	<!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/custom.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>
<div class="container">
<div class="row border" style="padding:20px;">
<div class="col-sm-6">
	<div><a href="/appointment/{{$name}}/{{$event_type}}/{{$duration}}/{{$user_id}}"><i class="fa fa-arrow-left fa-2x" aria-hidden="true" style="color:#337ab7;border:2px solid #337ab7;border-radius:30px;"></i></a></div>
	<div class="info"><span><i class="fa fa-user fa-1x" aria-hidden="true" style="color:#337ab7"></i>&nbsp;&nbsp;{{$name}}</span></div>
	<div class="info" style="font-size:30px;font-weight: bold;"><span><i class="fa fa-circle" style="color:#337ab7"></i>&nbsp;&nbsp;{{$event_type}}</span></div>
	<div class="info"><span><i class="fas fa-clock" style="color:#337ab7"></i>&nbsp;&nbsp;{{$duration}} Min</span></div>
	<div class="info"><p style="font-size:20px;"><i class="fa fa-calendar fa-1x" aria-hidden="true" style="color:#337ab7"></i>&nbsp;&nbsp;{{$timeslot}} {{$selected_date}}</p></div>
</div>
<div class="col-sm-6">
	<form method="POST" id="frm-appointment-user">
		<div class="form-group">
			<label>First Name</label>
			<input type="text" class='form-control' id="fname" required>
		</div>
		<div class="form-group">
			<label>Last Name</label>
			<input type="text" class='form-control' id="lname" required>
		</div>
		<div class="form-group">
			<label>Email</label>
			<input type="email" class='form-control' id="email">
		</div>
		<div class="form-group">
					<button type="submit" class="btn btn-primary">Submit</button>
					<button type="reset" class="btn btn-default">Cancel</button>	
		</div>
	</form>
</div>
</div>
</div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="http://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
<script>
$(document).ready(function(){
$("#frm-appointment-user").submit(function(e){
	e.preventDefault();
	var fname = $("#fname").val();
	var lname = $("#lname").val();
	var email = $("#email").val();
	var appointment_id = '<?php echo $last_inserted_id; ?>';
	var user_id = '<?php echo $user_id; ?>';

	var data = {
		'appointment_id':appointment_id,
		'fname':fname,
		'lname':lname,
		'email':email
	}
	$.ajax({
		url:'/insert_appointment_user',
		headers: {
    			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  			},
		method:'POST',
		data:data,
		success:function(response){
			var message = 'Confirmed';
			var name = '<?php echo $name; ?>';
			var event_type = '<?php echo $event_type; ?>';
			var selected_date = '<?php echo $selected_date; ?>';
			var timeslot = '<?php echo $timeslot; ?>';

			$(location).attr('href', '/appointment_confirmed/'+name+'/'+event_type+'/'+selected_date+'/'+timeslot+'/'+message+'/'+user_id);
		}
	});
});
});
</script>
<style>
.info{
	padding: 10px;";
	margin:10px;
}
</style>
</html>