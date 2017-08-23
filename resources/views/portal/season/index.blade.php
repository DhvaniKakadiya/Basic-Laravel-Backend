@extends('layouts.master')
@section('content')
<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Season <a class="btn btn-primary" href="/season/create">Add new</a>
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
                    <th>Series Name</th>
                    <th>Season Number</th>
                    <th>Published date</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php $id = 0;?>
                @foreach ( $season as $s)
				
                    <tr>
                        <td>{{++$id}}</td>
                        <td>{{$s->series_name}}</td>

                        <td>{{$s->season_number}}</td>
                        <td>{{$s->published_date}}</td>
    
                        <td><a href="/season/edit/{{$s->season_id}}" class="btn btn-primary"><i class="fa fa-pencil"></i> </a></td>
                        <td><a href="/season/delete/{{$s->season_id}}" class="btn btn-danger"><i class="fa fa-trash"></i> </a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<!-- /.row -->

@stop