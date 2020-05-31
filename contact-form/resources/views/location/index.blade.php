@extends('welcome')

@section('content')

  <div class="container-fluid">
  <h2>Location  <a href="AddLocation" class="btn btn-success">ADD LOCATION</a></h2>
@if (Session::get('Success'))
    <div class="alert alert-info">
	{{Session::get('Success')}}
    </div>
@endif	
  <br>
		<table class="table table-responsive table-bordered">
			<thead>
				<tr>
					<th>S.NO</th>
					<th>Location Name</th>
					<th>Action</th>
					
				</tr>
			</thead>
			
				@foreach($locations as $key => $location)
				<tr>
					<td>{{$key+1}}</td>
					<td>{{$location->location_name}}</td>
					<td>
					<button class="edit_location btn btn-primary" value="{{$location->id}}">Edit</button>
								<form method="post" action="LocationDelete" enctype="multipart/form-data" style="display:inline">
								{{ csrf_field() }}
									<button name="id" class="btn btn-danger" value="{{$location->id}}">Delete</button>
								</form>		
					</td>
				</tr>
				@endforeach
			<tbody>
			</tbody>
		</table>
		<div class="modal fade" id="myModal" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Location Edit</h4>
					</div>
					<div class="modal-body">
						<form method="post" action="locationUpdate">
						{{csrf_field()}}
							<div class="row">
								<div class="form-group col-sm-6">
									 Location Name
									 <input type="text" id="location_name" class="form-control" name="location_name">
									 <input type="hidden" id="location_id" class="form-control" name="location_id">
									
								</div>
								
							</div>
							<div class="row">
								<div class="form-group col-sm-6">
									<input type="submit"  class="btn btn-primary" value="save">
								</div>
							</div>	
						</form>	
						<div class="modal-footer">
						  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>
		</div>
@stop  
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
	$('.edit_location').click(function(){
		//alert($(this).val());
		$.get("getLocationDataById?id="+$(this).val(),function(data){
			console.log(data)
			$('#location_name').val(data.location_name);
			$('#location_id').val(data.id);
			$("#myModal").modal("toggle");
		})
	})
})
</script>