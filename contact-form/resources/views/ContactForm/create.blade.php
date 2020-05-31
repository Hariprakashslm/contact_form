@extends('welcome')

@section('content')
<h2>Contact Form</h2>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if (Session::get('Success'))
    <div class="alert alert-info">
	{{Session::get('Success')}}
    </div>
@endif
<form method="post" action="{{Route('ContactForm.store')}}" enctype="multipart/form-data">
	{{ csrf_field() }}
	
	<div class="row">
		<div class="col-lg-6">
			<div class="form-group">
				First Name
				<input type="text" name="FirstName" class="form-control" required >
			</div>
		</div>
		<div class="col-lg-6">
			<div class="form-group">
				Last Name
				<input type="text" name="LastName" class="form-control" required>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-6">
			<div class="form-group">
				Email
				<input type="email" name="Email" class="form-control" required>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="form-group">
				Phone Number
				<input type="number" name="PhoneNumber" min="1111111111" class="form-control" required>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-6">
			<div class="form-group">
				Location
				<select name="Location" class="form-control" required>
					<option value=''>Select</option>
					@foreach($locations as $location)
					<option value="{{$location->id}}">{{$location->location_name}}</option>
					@endforeach
				</select>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-6">
			<input type="submit" class="btn btn-primary">
		</div>
	</div>	
</form>

<table class="table table-bordered">
    <thead>
      <tr>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Phone Number</th>
        <th>Location</th>
      </tr>
    </thead>
    <tbody>
      
	@foreach($ContactForm as $contact)
	  <tr>
        <td>{{$contact->FirstName}}</td>
        <td>{{$contact->LastName}}</td>
        <td>{{$contact->Email}}</td>
        <td>{{$contact->PhoneNumber}}</td>
        <td>{{isset($contact->LocationMaster) ? $contact->LocationMaster->location_name : 'Location Removed'}}</td>
      </tr>
	@endforeach
    </tbody>
  </table>
  
@stop  