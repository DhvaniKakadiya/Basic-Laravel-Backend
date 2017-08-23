@extends('layouts.master')
@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Creator <a class="btn btn-primary" href="/creator">Back</a>
        </h1>
		<div class="row">
			<div class="col-lg-8">		
				<form action="./" method="POST" enctype="multipart/form-data">
					{{csrf_field()}}
					<div class="form-group">
						<label>Creator Name : </label>
						<input type="text" class="form-control" name="creator_name" required>
					</div>
					<div class="form-group">
						<label>fb link : </label>
						<input type="text" class="form-control" name="fb_link">
					</div>
					<div class="form-group">
						<label>insta link : </label>
						<input type="text" class="form-control" name="insta_link">
					</div>
					<div class="form-group">
						<label>twitter link : </label>
						<input type="text" class="form-control" name="twitter_link">
					</div>
					<div class="form-group">
						<label>website link : </label>
						<input type="text" class="form-control" name="website_link">
					</div>
					<div class="form-group">	
						<label>Short Bio: </label>
						<textarea class="form-control" name="short_description"></textarea>
					</div>
					<div class="form-group">	
						<label>Full Biography: </label>
						<textarea class="form-control" name="full_bio"></textarea>
					</div>
					<div class="form-group">	
						<label>Established_date </label>
						<input type="date" class="form-control" name="established_date"></textarea>
					</div>
					<div class="form-group">	
						<label>Poster Image Path: </label>
						<div id="poster-image-path">
						<input type="file" name="poster_image_path">
						</div>
					</div>
					<div class="form-group">	
						<label>Lanscape Image Path : </label>
						<div id="landscape-image-path">
						<input type="file" name="landscape_image_path">
						</div>
					</div>
					<div class="form-group">	
						<label>Thumbnail Image Path : </label>
						<div id="thumbnail-image-path">
						<input type="file" name="thumbnail_image_path">
						</div>
					</div>
					<button type="submit" value=" Submit "  class="btn btn-success" name="submit">Submit</button>
				</form>
			</div>
		</div>

</div>

@stop