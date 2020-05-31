@extends('welcome')

@section('content')
<h2>Edit Location </h2>

	
	<form method="PUT" action="{{route('location.update',$location->id)}}">
	<div class="row">
		<div class="form-group col-sm-6">
		Name (*):
			<input type="text" name="location_name" class='form-control'  value="{{$location->location_name}}" required>
		</div>
		
	</div>
		
	<div class="row">
		<div class="form-group" style="padding-left:10px;">
			<input class="btn btn-primary col-sm-2" type="submit">
		</div>
	</div>
	</form>

	
	
	
	
@stop  