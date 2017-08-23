@extends('layouts.master')
@section('content')
<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Person <a class="btn btn-primary" href="/person/create">Add new</a>
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
                    <th>Date of Birth</th>
                    <th>Place of Birth</th>
                    <th>Date of Death</th>
                    <th>Place of Death</th>
                    <th>Short Bio</th>
                    <th>Full Bio</th>
                    <th>Square Image</th>
                     <th> Poster Image</th>   
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
        		@foreach ( $person as $p )
        			<tr>
        				<td>{{++$id}}</td>
                        <td>{{$p->person_name}}</td>
                        <td>{{$p->birth_date}}</td>
                        <td>{{$p->birth_place}}</td>
                        <td>{{$p->death_date}}</td>
                        <td>{{$p->death_place}}</td>
                        <td><?php
                                $string = $p->short_description;
                                echo charlimit($string, 100);
                            ?>
                        </td>
                        <td><?php
                                $string = $p->full_biography;
                                echo charlimit($string, 100);
                            ?>
                        </td>
                        <td><img src="/public/image_gallery/{{ $p->square_image }}" width="100" height="100" alt="Not Found"></img></td>
                        <td><img src="/public/image_gallery/{{ $p->poster_image }}" width="100" height="100" alt="Not Found"></img></td>
						<td>
						    @foreach ( $person_awards as $pa)
                                @if ($pa->person_id == $p->person_id)    
                                    <?php
                                        $string = $pa->award_name;
                                        echo charlimit($string, 100);
                                    ?><hr>
                                @endif
                            @endforeach
						</td>
                        <td>
                            @foreach ( $person_gallery as $pg)
                                @if ($pg->person_id == $p->person_id) 
                                    <img src="/public/image_gallery/{{ $pg->small_image_path}}" width="100" height="100" alt="Not Found"></img>
                                    <hr>
                                @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach ( $person_gallery as $pg)
                                @if ($pg->person_id == $p->person_id) 
                                    <img src="/public/image_gallery/{{ $pg->large_image_path}}" width="100" height="100" alt="Not Found"></img><hr>
                                @endif
                            @endforeach
                        </td>
        				<td><a href="/person/edit/{{$p->person_id}}" class="btn btn-primary"> <i class="fa fa-pencil"></i> </a></td>
                        <td><a href="/person/delete/{{$p->person_id}}" class="btn btn-danger"> <i class="fa fa-trash"></i> </a></td>
        			</tr>
        		@endforeach
        	</tbody>
        </table>
    </div>
</div>
<!-- /.row -->


@stop