<!DOCTYPE html>
<html>
<head>
<title>Meeting Scheduler</title>
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

		<div class="row" style="border-bottom:2px solid #ddd;">
        <div><a href="/home"><i class="fa fa-arrow-left fa-2x" aria-hidden="true" style="color:#337ab7;border:2px solid #337ab7;border-radius:30px;"></i></a></div>
      <div class="col-xs-3 center-block" style="padding:20px;">
			   <span>{{$name}}</span>
      </div>
		</div>
		<div class="row" style="border-bottom:2px solid #ddd;margin-bottom: 20px;">
      <div class="col-xs-5 center-block" style="padding:20px;">
			<span>Welcome to my scheduling page.Please follow the instructions to add an event to my calender</span>
      </div>
		</div>
		<div class="row">
			<ul class="list-group" id="eventType">
			</ul>
			
		</div>
	</div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script>
$(document).ready(function(){

$.ajax({
    url:"/api/getEvent",
    method:'GET',
    success:function(data){
       var name = '<?php echo $name; ?>';
       var id = '<?php echo $id; ?>';
        for(var i=0;i<data.data.length;i++){
            (function(){ 
                var x = $('#etype'+i);
                $("#eventType").append('<a href="/appointment/'+name+'/'+data.data[i].event_name+'/'+data.data[i].event_duration+'/'+id+'"><li class="list-group-item" style="width:500px;">'+data.data[i].event_name+'<span class="glyphicon glyphicon-chevron-right" style="position:relative;float:right;"></span>	</li></a>');
            })()
        }
    }
});

});
</script>
<style>
  .list-group li{
    padding:30px;
  }
</style>
</html>

