@extends('layouts.master')
@section('content')
<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Genre <a class="btn btn-primary" href="/genre/create">Add new</a>
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
                    <th>Delete</th>

                </tr>
            </thead>
            <tbody>
                <?php $id = 0;?>
                @foreach ( $genre as $g )
                    <tr>
                        <td> {{++$id}}</td>
                        <td> {{$g->genre_name}}</td>
                        <td><a href="/genre/delete/{{$g->genre_id}}" class="btn btn-danger"> <i class="fa fa-trash"></i> </a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<!-- /.row -->


@stop