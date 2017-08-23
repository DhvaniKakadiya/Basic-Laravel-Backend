@extends('layouts.master')
@section('content')
<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            character <a class="btn btn-primary" href="/character/create">Add new</a>
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
                    <th>Biography</th>
                	<th>Poster Path</th>
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
        		@foreach ( $characte as $c )
        			<tr>
        				<td>{{++$id}}</td>
                        <td>{{$c->characte_name}}</td>
                        
            
                        <td><?php
                                $string = $c->biography;
                                echo charlimit($string, 100);
                            ?>
                        </td>

						<td><img src="/public/image_gallery/{{ $c->poster_path}}" width="100" height="100" alt="Not Found"></img></td>
                        <td>
                            @foreach ( $character_gallery as $cg)
                                @if ($cg->characte_id == $c->characte_id) 
                                    <img src="/public/image_gallery/{{ $cg->small_image_path}}" width="100" height="100" alt="Not Found"></img>
                                    <hr>
                                @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach ( $character_gallery as $cg)
                                @if ($cg->characte_id == $c->characte_id) 
                                    <img src="/public/image_gallery/{{ $cg->large_image_path}}" width="100" height="100" alt="Not Found"></img><hr>
                                @endif
                            @endforeach
                        </td>
        				<td><a href="/character/edit/{{$c->characte_id}}" class="btn btn-primary"> <i class="fa fa-pencil"></i> </a></td>
                        <td><a href="/character/delete/{{$c->characte_id}}" class="btn btn-danger"> <i class="fa fa-trash"></i> </a></td>
        			</tr>
        		@endforeach
        	</tbody>
        </table>
    </div>
</div>
<!-- /.row -->



            <!---->

@stop