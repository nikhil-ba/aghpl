@extends('layouts.app') 
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-4">

		</div>
		<div class="col-md-4" style="margin-bottom: 20px;">
			<span style="font-size:20px">{{$title}}</span>
		</div>
		<div class="col-md-4">
			
		</div>
	</div>
	<div class="row border" style="padding:30px;">
		<div class="col-md-12" style="height:330px">
			<form id="frmevent" method="post" action="#">
				<div class="form-group">
					<label for="event_name">Event Name</label>
					<input type="text" class="form-control" id="event_name" value="{{$event_name != '' ? $event_name : $event_name}}" required>
				</div>
				<div class="form-group">
					<label for="event_duration">Event Duration</label><br>
					<div class="btn-group" role="group" aria-label="Basic example" id="group-btn">
						<button type="button" class="btn btn-secondary btn-time">15 Min</button>
  						<button type="button" class="btn btn-secondary btn-time">30 Min</button>
  						<button type="button" class="btn btn-secondary btn-time">45 Min</button>
  						<button type="button" class="btn btn-secondary btn-time">60 Min</button>
  						<button type="button" class="btn btn-secondary btn-time">Custom Min</button>
					</div>
					<input type="text" id="btn-custom-value"/>
					<input type="hidden" id="btn-value" value="{{$event_duration}}"/>
				</div>
				<hr/>
				<div class="form-group">
					<button type="submit" class="btn btn-primary pull-right">Submit</button>
					<button type="reset" id="btn-cancel" class="btn btn-default pull-right" style="margin-right:10px">Cancel</button>	
				</div>
			</form>
		</div>
	</div>
</div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script>
$(document).ready(function(){
var name = '';
var duration = '';
var url = '';
var data = {};
$("#btn-custom-value").hide();

$('#btn-cancel').click(function(){
	$(location).attr('href','/home');
});

$("#group-btn button").click(function(e){
	if(this.textContent != 'Custom Min'){
		$('#btn-value').val(this.textContent)
	}else{
		$('#btn-value').val('');
		$('#btn-custom-value').show();
	}
	
})
$("#frmevent").submit(function(e){
	e.preventDefault();
	if(this.duration != ''){
		this.duration = $('#btn-value').val();
	}else{
		if($('#btn-custom-value').val() != ''){
			this.duration = $('#btn-custom-value').val();
		}else{
			this.duration = '30';
		}	
	}
	
	this.name = $("#event_name").val();
	if(getUrlVars()["action"]){
		this.url = '/api/edit_event';
		this.data = {'event_name':this.name,'event_duration':this.duration,'id':getUrlVars()["id"]};
	}else{
		this.url = '/api/insert_event';
		this.data = {'event_name':this.name,'event_duration':this.duration};
	}
	$.ajax({
		url:this.url,
		method:"post",
		data:this.data,
		success:function(response){
			$(location).attr('href','/home');
		}
	});
});

// Read a page's GET URL variables and return them as an associative array.
function getUrlVars()
{
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}
});
</script>
<style>
.btn-time{
	background-color:white!important;
	color:black;border:2px solid #337ab7!important;
	margin-right:10px!important;
	height:50px;border-radius:0!important;
	color:#337ab7!important;
	margin-right:15px!important;
	margin-top:15px!important;
	width:100px!important;
}
</style>