@extends('layouts.master')
@section('content')
<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Soundtracks <a class="btn btn-primary" href="/soundtracks/create">Add new</a>
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
                    <th>Episode Name</th>
                    <th>Song Name</th>
                    <th>Composer List</th>
                    <th>Edit</th>
                    <th>Delete</th>
	        	</tr>
        	</thead>
        	<tbody>
                <?php $id = 0;?>
        		@foreach ( $soundtracks as $s )
        			<tr>
        				<td>{{++$id}}</td>
                        <td>
                            @foreach ( $season as $se )
                                @if($se->episode_id==$s->episode_id)
                                @foreach ( $series as $sr )
                                    @if($sr->season_id==$se->season_id)
                                        {{$sr->series_name}}
                                    @endif
                                @endforeach
                                @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach ( $season as $se )
                                @if( $se->episode_id == $s->episode_id)
                                    {{$se->season_number}}
                                @endif
                            @endforeach
                        </td>
                        @foreach ( $episode as $e )
                            @if($e->episode_id==$s->episode_id)
                                <td>{{$e->episode_name}}</td>
                            @endif
                        @endforeach
            
                        <td>{{$s->song_name}}</td>
                        <td>
                            @foreach ( $composer as $c)
                                @if($c->composerlist_id==$s->composerlist_id)
                                    @foreach($person as $p)
                                        @if ($p->person_id == $c->person_id) 
                                            {{$p->person_name}}
                                            <hr>
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                        </td>
        				<td><a href="/soundtracks/edit/{{$s->soundtracks_id}}" class="btn btn-primary"> <i class="fa fa-pencil"></i> </a></td>
                        <td><a href="/soundtracks/delete/{{$s->soundtracks_id}}" class="btn btn-danger"> <i class="fa fa-trash"></i> </a></td>
        			</tr>
        		@endforeach
        	</tbody>
        </table>
    </div>
</div>
<!-- /.row -->



            <!---->

@stop