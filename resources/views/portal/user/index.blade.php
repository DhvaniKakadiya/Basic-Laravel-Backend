@extends('layouts.master')
@section('content')
<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Users <a class="btn btn-primary" href="/register">Add New User</a>
        </h1>
        @if (Session::has('success'))
        <div class="row">
                    <div class="col-lg-12">
                        <div class="alert alert-info alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
               				{{ Session::get('success') }}
                        </div>
                    </div>
                </div>
         @endif
        <table class="table">
            <thead>
	        	<tr>
        			<th>Id</th>
        			<th>Name</th>
                    <th>Email Id</th>
        			<th>Role</th>
                    <th>Edit</th>
                    <th>Delete</th>
	        	</tr>
        	</thead>
        	<tbody>
                <?php $id = 0;?>
        		@foreach ( $user as $u )
        			<tr>
        				<td>{{++$id}}</td>
        				<td>{{$u->name}}</td>
                        <td>{{$u->email}}</td>
        				<td>{{$u->role}}</td>
                        <td><a href="/users/edit/{{$u->email}}" class="btn btn-primary"> <i class="fa fa-pencil"></i> </a></td>
                        <td><a href="/users/delete/{{$u->email}}" class="btn btn-danger"> <i class="fa fa-trash"></i> </a></td>
        			</tr>
        		@endforeach
        	</tbody>
        </table>
    </div>
</div>
<!-- /.row -->


@stop