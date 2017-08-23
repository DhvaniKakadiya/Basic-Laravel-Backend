@extends('layouts.master')
@section('content')

<div class="row">
    <div class="col-lg-12">
    	@foreach ( $creator as $c )
        <h1 class="page-header">
            {{$c->creator_name}} <a class="btn btn-primary" href="/creator">Back</a>
        </h1>
		<div class="row">
			<div class="col-lg-8">		
				<form action="./{{$c->creator_id}}" method="POST" enctype="multipart/form-data">
					{{csrf_field()}}
					<div class="form-group">
						<label>Creator Name : </label>
						<input type="text" class="form-control" name="creator_name" value="{{$c->creator_name}}" required>
					</div>
					<div class="form-group">
						<label>Fb Link : </label>
						<input type="text" class="form-control" name="fb_link" value="{{$c->fb_link}}">
					</div>
					<div class="form-group">
						<label>Insta Link : </label>
						<input type="text" class="form-control" name="insta_link" value="{{$c->insta_link}}">
					</div>
					<div class="form-group">
						<label>Twitter Link : </label>
						<input type="text" class="form-control" name="twitter_link" value="{{$c->twitter_link}}">
					</div>
					<div class="form-group">
						<label>Web-Site Link : </label>
						<input type="text" class="form-control" name="website_link" value="{{$c->website_link}}">
					</div>
					<div class="form-group">	
						<label>Creator Short Bio: </label>
						<textarea class="form-control" name="short_description">{{$c->short_description}}</textarea>
					</div>
					<div class="form-group">	
						<label>Creator Full Bio: </label>
						<textarea class="form-control" name="full_bio">{{$c->full_bio}}</textarea>
					</div>
					<div class="form-group">
						<label>Established Date : </label>
						<input type="date" class="form-control" name="established" value="{{$c->established_date}}">
					</div>
					<div class="form-group">	
						<label>Poster Image Path: </label>
						<div id="poster-image-path">
							<img src="/public/image_gallery/{{ $c->poster_image_path}}" width="100" height="100" ></img>
						<input type="file" name="poster_image_path" >
						</div>
					</div>
					<div class="form-group">	
						<label>Lanscape Image Path : </label>
						<div id="landscape-image-path">
							<img src="/public/image_gallery/{{ $c->landscape_image_path}}" width="100" height="100" ></img>
						<input type="file" name="landscape_image_path" >
						</div>
					</div>
					<div class="form-group">	
						<label>Thumbnail Image Path : </label>
						<div id="thumbnail-image-path">
							<img src="/public/image_gallery/{{ $c->thumbnail_image_path}}" width="100" height="100" ></img>
						<input type="file" name="thumbnail_image_path" >
						</div>
					</div>
					@endforeach
					<button type="submit" value=" Submit "  class="btn btn-success" name="submit">Submit</button>
				</form>
			</div>
		</div>

</div>

@stop