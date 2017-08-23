@extends('layouts.master')
@section('content')
<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Episode <a class="btn btn-primary" href="/episode/create">Add new</a>
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
                    <th>Episode Number</th>
                    <th>Published Date</th>
                    <th>Time Length</th>
                    <th>Storyline</th>
                    <th>Poster Image Path</th>
                    <th>Landscape Image Path</th>
                    <th>Thumbnail Image Path</th>
                    <th>Dialogues</th>
                    <th>Awards</th>
                    <th>Reviews</th>
                    <th>Small Images</th>
                    <th>Large Images</th>
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
                @foreach ( $episode as $e )
                    <tr>
                        <td>{{++$id}}</td>
                        <td>
                            @foreach ( $season as $se )
                                @if($se->episode_id==$e->episode_id)
                                @foreach ( $series as $s )
                                    @if($s->season_id==$se->season_id)
                                        {{$s->series_name}}
                                    @endif
                                @endforeach
                                @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach ( $season as $se )
                                @if( $se->episode_id == $e->episode_id)
                                    {{$se->season_number}}
                                @endif
                            @endforeach
                        </td>
                        <td>{{$e->episode_name}}</td>
                        <td>{{$e->episode_number}}</td>
                        <td>{{$e->published_date}}</td>
                        <td>{{$e->time_length}}</td>
                        <td><?php
                                $string = $e->storyline;
                                echo charlimit($string, 100);
                            ?>
                        </td>
                        <td><img src="/public/image_gallery/{{ $e->poster_image_path }}" width="100" height="100" alt="Not Found"></img></td>
                        <td><img src="/public/image_gallery/{{ $e->landscape_image_path }}" width="100" height="100" alt="Not Found"></img></td>
                        <td><img src="/public/image_gallery/{{ $e->thumbnail_image_path }}" width="100" height="100" alt="Not Found"></img></td> 
                        <td>
                            @foreach ( $episode_dialogues as $ed)
                                @if ($ed->episode_id == $e->episode_id)    
                                    <?php
                                        $string = $ed->dialogues;
                                        echo charlimit($string, 100);
                                    ?><hr>
                                @endif
                            @endforeach
                        </td>  
                        <td>
                            @foreach ( $episode_awards as $pa)
                                @if ($pa->episode_id == $e->episode_id)    
                                    <?php
                                        $string = $pa->award_name;
                                        echo charlimit($string, 100);
                                    ?><hr>
                                @endif
                            @endforeach
                        </td>  
                        
                        
                        <td>
                            @foreach ( $episode_review as $r)
                            @if ($r->episode_id == $e->episode_id)    
                                <?php
                                    $string = $r->review_text;
                                    echo charlimit($string, 100);
                                ?><hr>
                            @endif
                            @endforeach
                        </td>
                        
                        
                                         
                        <td>
                            @foreach ( $episode_gallery as $cg)
                                @if ($cg->episode_id == $e->episode_id) 
                                    <img src="/public/image_gallery/{{ $cg->small_image_path}}" width="100" height="100" alt="Not Found"></img>
                                    <hr>
                                @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach ( $episode_gallery as $cg)
                                @if ($cg->episode_id == $e->episode_id) 
                                    <img src="/public/image_gallery/{{ $cg->large_image_path}}" width="100" height="100" alt="Not Found"></img><hr>
                                @endif
                            @endforeach
                        </td>
                        <td><a href="/episode/edit/{{$e->episode_id}}" class="btn btn-primary"> <i class="fa fa-pencil"></i> </a></td>
                        <td><a href="/episode/delete/{{$e->episode_id}}" class="btn btn-danger"> <i class="fa fa-trash"></i> </a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<!-- /.row -->


@stop