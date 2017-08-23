@extends('layouts.master')
@section('content')
<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Language <a class="btn btn-primary" href="/language/create">Add new</a>
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
                @foreach ( $language as $l )
                    <tr>
                        <td> {{++$id}}</td>
                        <td> {{$l->language_name}}</td>
                        <td><a href="/language/delete/{{$l->language_id}}" class="btn btn-danger"> <i class="fa fa-trash"></i> </a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<!-- /.row -->


@stop