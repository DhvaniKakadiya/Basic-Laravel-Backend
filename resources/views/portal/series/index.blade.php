@extends('layouts.master')
@section('content')
<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Series <a class="btn btn-primary" href="/series/create">Add new</a>
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
					<th>Summary Text</th>
        			<th>Story:</th>
                    <th>Published date:</th>
                    <th>Trailer link</th>
                    <th>Series Fb</th>
                    <th>Series Insta</th>
                    <th>Series Twitter</th>
                    <th>Poster path</th>
                    <th>Thumbnail path</th>
                    <th>Creator</th>
                    <th>Genre</th>
					<th>Language</th>
                    <th>Country</th>
                    <th>Production Co.</th>
                    <th>Distributors</th>
                    <th>Filminglocation</th>
                    <th>Sound Mix Type</th>
                    <th>Color</th>
                    <th>Aspect Ratio</th>
                    <th>Awards</th>
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
        		@foreach ( $series as $s )
        			<tr>
        				<td>{{++$id}}</td>
        				<td>{{$s->series_name}}</td>
        				<td><?php
                                $string = $s->summary_text;
                                echo charlimit($string, 100);
                            ?>
                        </td>
                        <td><?php
                                $string = $s->storyline;
                                echo charlimit($string, 100);
                            ?>
                        </td>
						<td>{{$s->published_date}}</td>
						<td>{{$s->trailer_link}}</td>
						<td>{{$s->series_fb}}</td>
						<td>{{$s->series_insta}}</td>
						<td>{{$s->series_twitter}}</td>
						<td><img src="/public/image_gallery/{{ $s->poster_path }}" width="100" height="100" alt="Not Found"></img></td>
                        <td><img src="/public/image_gallery/{{ $s->thumbnail_path }}" width="100" height="100" alt="Not Found"></img></td>
                        <td>
                            @foreach($creator as $c)
                                @if ($c->creator_id == $s->creator_id)    
                                    {{$c->creator_name}}
                                @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach ( $series_to_genre_mapping as $sg)
                                @if ($sg->series_id == $s->series_id)    
                                    {{$sg->genre_name}},
                                @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach ( $series_language as $sl)
                                @if ($sl->series_id == $s->series_id)    
                                    {{$sl->language_name}},
                                @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach($series_country as $sc)
                                @if ($sc->series_id == $s->series_id)    
                                    {{$sc->country_name}}<hr>
                                @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach($productionco as $pc)
                                @if ($pc->series_id == $s->series_id)    
                                    {{$pc->production_co}}<hr>
                                @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach($distributors as $d)
                                @if ($d->series_id == $s->series_id)    
                                    {{$d->distributors}}<hr>
                                @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach($filminglocation as $f)
                                @if ($f->series_id == $s->series_id)    
                                    {{$f->city_name}},
                                    @foreach($country as $c)
                                        @if ($f->country_id == $c->country_id)    
                                        {{$c->country_name}}<hr>
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                        </td>
                        @foreach ( $technicalspecs as $t)
                        @if($t->series_id==$s->series_id)
                        <td>{{$t->sound_mix_type}}</td>  
                        <td>{{$t->color}}</td>
                        <td>{{$t->aspect_ratio}}</td>
                        @endif
                        @endforeach
                        <td>
                            @foreach ( $series_awards as $sa)
                                @if ($sa->series_id == $s->series_id)    
                                    <?php
                                        $string = $sa->award_name;
                                        echo charlimit($string, 100);
                                    ?><hr>
                                @endif
                            @endforeach
                        </td>  
                        <td>
                            @foreach ( $series_gallery as $sg)
                                @if ($sg->series_id == $s->series_id) 
                                    <img src="/public/image_gallery/{{ $sg->small_image_path}}" width="100" height="100" alt="Not Found"></img>
                                    <hr>
                                @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach ( $series_gallery as $sg)
                                @if ($sg->series_id == $s->series_id)  
                                    <img src="/public/image_gallery/{{ $sg->large_image_path}}" width="100" height="100" alt="Not Found"></img><hr>
                                @endif
                            @endforeach
                        </td>
        				<td><a href="/series/edit/{{$s->series_id}}" class="btn btn-primary">Edit <i class="fa fa-pencil"></i> </a></td>
                        <td><a href="/series/delete/{{$s->series_id}}" class="btn btn-danger">Delete <i class="fa fa-trash"></i> </a></td>
        			</tr>
        		@endforeach
        	</tbody>
        </table>
    </div>
</div>
<!-- /.row -->


@stop