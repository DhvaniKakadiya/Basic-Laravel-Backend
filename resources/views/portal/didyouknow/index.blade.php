@extends('layouts.master')
@section('content')
<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Did You Know <a class="btn btn-primary" href="/DidYouKnow/create">Add new</a>
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
                    <th>Travia</th>
                    <th>Goofs</th>
                    <th>Quotes</th>
                    <th>Crazy Credits</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php $id = 0;?>
                <?php
                    function charlimit($string, $limit) {

                        return substr($string, 0, $limit) . (strlen($string) > $limit ? "..." : '');
                    }
                ?>
                @foreach ( $dyk_episode as $dyk )
                    <tr>
                        <td>{{++$id}}</td>
                        <td>{{$dyk -> series_name }}</td>
                        <td>
                            @foreach ( $travia as $tr)
                                @if ($tr->series_id== $dyk->series_id)    
                                    <?php
                                        $string = $tr->travia_details;
                                        echo charlimit($string, 100);
                                    ?> <hr>
                                @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach ( $goofs as $tr)
                                @if ($tr->series_id == $dyk->series_id)    
                                    <?php
                                        $string = $tr->goofs_details;
                                        echo charlimit($string, 100);
                                    ?> <hr>
                                @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach ( $quotes as $tr)
                                @if ($tr->series_id== $dyk->series_id)    
                                    <?php
                                        $string = $tr->quotes_details;
                                        echo charlimit($string, 100);
                                    ?> <hr>
                                @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach ( $crazy as $tr)
                                @if ($tr->series_id== $dyk->series_id)    
                                    <?php
                                        $string = $tr->crazy_credits_details;
                                        echo charlimit($string, 100);
                                    ?><hr>
                                @endif
                            @endforeach
                        </td>
                        <td><a href="/DidYouKnow/edit/{{$dyk -> series_id}}" class="btn btn-primary"> <i class="fa fa-pencil"></i> </a></td>
                        <td><a href="/DidYouKnow/delete/{{$dyk -> series_id}}" class="btn btn-danger"> <i class="fa fa-trash"></i> </a></td>
                    </tr>
                @endforeach
            </tbody> 
            
        </table>
    </div>
</div>
<!-- /.row -->


@stop