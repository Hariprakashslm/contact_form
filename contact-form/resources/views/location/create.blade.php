@extends('welcome')

@section('content')
<h2>Location Master</h2>
@if (Session::get('Success'))
    <div class="alert alert-info">
	{{Session::get('Success')}}
    </div>
@endif
<div class="row">
<form method="post" action="{{Route('location.store')}}" enctype="multipart/form-data">
	{{ csrf_field() }}
	

	<a href="{{ asset('files/location_master.csv') }}"><b><div style="background-color:#204d74;width:20%;font-size:15px;color:white;text-align: center">Download sample Excel</div></b></a>	
	<br>
	<div class="form-group">
	<table class="table">
	<tr>
	<td width="40%" align="right"><label>Select File for upload</label></td>
	<td width="30">
	<input type="file" name="select_file" />
	</td>
	<td width="30%" align="left">
	<input type="submit" name="upload" class="btn btn-primary" value="Upload">
	</td>
	</tr>
	<tr>
	<td width="40%" align="right"></td>
	<td width="30"><span ckass="text-muted">.csv</span></td>
	<td width="30%" align="left"></td>
	</tr>
	</table>
	</div>
</form>


      </div>
	  
  
@stop  