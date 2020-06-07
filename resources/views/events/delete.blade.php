@extends('layouts.app') 
@section('content')

<div>
	<form  id="del-cnf-id">
		<div class="form-group">
			<label>Do you really want to delete event type ?</label>
		</div>
		<div class="form-group">
			<button type="submit" id="btn-submit" class="btn btn-primary">Yes</button>
			<button type="reset" id="btn-cancel" class="btn btn-default" style="margin-right:10px">No</button>
		</div>
	</form>
</div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script>
$(document).ready(function(){
	var id = <?php echo $id; ?>;
	$("#del-cnf-id").submit(function(e){
	e.preventDefault();
	$.ajax({
		url:'api/delete_event',
		method:'GET',
		data:{'id':id},
		success:function(response){
		$(location).attr('href','/home?action=event_deleted');
		}
		})
	});

	$("#btn-cancel").click(function(){
	$(location).attr('href','/home');
	});
});
</script>