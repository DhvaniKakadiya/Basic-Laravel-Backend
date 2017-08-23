@extends('layouts.master')
@section('content')


<div class="row">
    <div class="col-lg-12">
    	@foreach ( $user as $u )
        <h1 class="page-header">{{$u->name}} <a class="btn btn-primary" href="/users">Back</a></h1>
		<div class="row">
			<div class="col-lg-8">		
				<form action="/users/edit/{{$u->email}}" method="POST">
					{{csrf_field()}}
					<div class="form-group">
						<label>User Role : </label>
						<select class="form-control" name="role" value="" required>
							<option name="{{$u->role}}" value="{{$u->role}}" selected>{{$u->role}}</option>
							<option name="Admin" value="Admin" selected>Admin</option>
							<option name="User" value="User" selected>User</option>
						</select>
					</div>
					@endforeach
					<button type="submit" value="Submit"  class="btn btn-success" name="submit">Submit</button>
				</form>
			</div>
		</div>
	</div>
</div>

@stop