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
</body>
<div class="container">
	<div class="row border">
		<ul class="list-group list-group-flush border" style="width:500px;height:400px;position: relative;left:300px;margin-top: 100px;margin-bottom: 100px;">
			  <li class="list-group-item">
			  	<label>{{$message}}</label><br/>
				<p>You are scheduled with {{$name}}</p>
			  </li>
  			  <li class="list-group-item">
  			  	<p style="font-size:30px;font-weight:bold"><i class="fa fa-circle" style="color:#337ab7"></i>&nbsp;&nbsp;{{$event_type}}</p><br/>
				<p style="font-size:20px;"><i class="fa fa-calendar fa-1x" aria-hidden="true" style="color:#337ab7"></i>&nbsp;&nbsp;{{$timeslot}} {{$selected_date}}</p>
  			  </li>
  			  <li class="list-group-item">
  			  	<a href="/scheduler/{{$user_id}}">Schedule another event</a>
  			  </li>
		</ul>
	</div>
</div>
</html>
<style>
.align-items-center {
  -ms-flex-align: center!important;
  align-items: center!important;
  border:1px solid green;
}
.d-flex {
  display: -ms-flexbox!important;
  display: flex!important;
}
</style>