@extends('layouts.master')
@section('content')

<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Creator <a class="btn btn-primary" href="/creator/create">Add new</a>
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
                    <th>Fb Link</th>
                    <th>Insta Link</th>
                    <th>Twitter Link</th>
                    <th>Web-Site Link</th>
                    <th>Short Description</th>
                    <th>Full Biography</th>
                    <th>Established Date</th>
                    <th>Poster Image </th>
                    <th>Landscape Image</th>
                    <th>Thumbnail Image</th>
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

        		@foreach ( $creator as $c )
        			<tr>
        				<td> {{++$id}}</td>
        				<td> {{$c->creator_name}}</td>
                        <td> {{$c->fb_link}}</td>
                        <td> {{$c->insta_link}}</td>
                        <td> {{$c->twitter_link}}</td>
                        <td> {{$c->website_link}}</td>
                        <td> <?php
                                $string = $c->short_description;
                            ?>
                        </td>


                        <td><?php
                                $string = $c->full_bio;
                                echo charlimit($string, 100);
                            ?>
                        </td>
                        <td> {{$c->established_date}}</td>
                        <td><img src="/public/image_gallery/{{ $c->poster_image_path }}" width="100" height="100" alt="Not Found"></img></td>
                        <td><img src="/public/image_gallery/{{ $c->landscape_image_path }}" width="100" height="100" alt="Not Found"></img></td>
                        <td><img src="/public/image_gallery/{{ $c->thumbnail_image_path }}" width="100" height="100" alt="Not Found"></img></td> 
                        <td><a href="/creator/edit/{{$c->creator_id}}" class="btn btn-primary"> <i class="fa fa-pencil"></i> </a></td>
                        <td><a href="/creator/delete/{{$c->creator_id}}" class="btn btn-danger"> <i class="fa fa-trash"></i> </a></td>
        			</tr>
        		@endforeach
        	</tbody>
        </table>
    </div>
</div>
<!-- /.row -->


@stop