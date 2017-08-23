@extends('layouts.master')
@section('content')
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Series <a class="btn btn-primary" href="/series">Back</a></h1>
        </h1>
		<div class="row">
			<div class="col-lg-8">		
				<form action="./" method="POST" enctype="multipart/form-data">
					{{csrf_field()}}
					<div class="form-group">
						<label>Series Name : </label>
						<input type="text" class="form-control" name="series_name" required>
					</div>
					<div class="form-group">	
						<label>Summary Text: </label>
						<textarea class="form-control" name="summary_text"></textarea>
					</div>
					<div class="form-group">
						<label>Story: </label>
						<input class="form-control" type="text" name="storyline">
					</div>
					<div class="form-group">
						<label>Published date: </label>
						<input type="date" class="form-control" type="text" name="published_date">
					</div>
					<div class="form-group">	
						<label>Trailer link: </label>
						<textarea class="form-control" name="trailer_link"></textarea>
					</div>
					<div class="form-group">	
						<label>Series Fb: </label>
						<textarea class="form-control" name="series_fb" ></textarea>
					</div>
					<div class="form-group">	
						<label>Series Insta: </label>
						<textarea class="form-control" name="series_insta" ></textarea>
					</div>
					<div class="form-group">	
						<label>Series Twitter: </label>
					<textarea class="form-control" name="series_twitter" ></textarea>
					</div>
					<div class="form-group">	
						<label>Poster Image Path: </label>
						<div id="poster-path">
						<input type="file" name="poster_path" >
						</div>
					</div>
					<div class="form-group">	
						<label>Thumbnail Image Path : </label>
						<div id="thumbnail-path">
						<input type="file" name="thumbnail_path" >
						</div>
					</div>
					<div class="form-group">
						<label>Creator Name : </label>
						<select class="form-control" id="creator_id" name="creator_id" required>
							<option>Select Creator Name</option>
							@foreach ( $creator as $c )
							<option name="{{$c->creator_id}}" value="{{$c->creator_id}}">{{$c->creator_name}}</option>
							@endforeach
						</select>
					</div>
                   				
					<div class="form-group">
						<label>Genre Name : </label>
						<div class="row">
							@foreach ( $genre as $g )
								<div class="col-lg-6">
								    <div class="input-group">
								      <label class="input-group-addon">
								        <input type="checkbox" name="genre_id[]" value="{{$g->genre_id}}" id="genre">
								      </label>
								      <input type="text" class="form-control" value="{{$g->genre_name}}" readonly>
								    </div>
								</div>
							@endforeach
						</div>
					</div>
					<div class="form-group">
						<label>Language Name : </label>
						<div class="row">
							@foreach ( $language as $l )
								<div class="col-lg-6">
								    <div class="input-group">
								      <label class="input-group-addon">
								        <input type="checkbox" name="language_id[]" value="{{$l->language_id}}" id="language">
								      </label>
								      <input type="text" class="form-control" value="{{$l->language_name}}" readonly>
								    </div>
								</div>
							@endforeach
						</div>
					</div>
					<div class="form-group">
						<label>Country: </label>					
						<div class="country">
							<button type="button" class="add-country btn btn-info">
						    	<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
						    </button>	
						</div>
					</div>	
					<div class="form-group">
						<label>Production Co.: </label>					
						<div class="productionco">
							<button type="button" class="add-productionco btn btn-info">
						    	<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
						    </button>	
						</div>
					</div>		
					<div class="form-group">
						<label>Distributors: </label>					
						<div class="distributors">
							<button type="button" class="add-distributors btn btn-info">
						    	<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
						    </button>	
						</div>
					</div>
					<div class="form-group">
						<label>Filminglocation : </label>					
						<div class="filminglocation">
							<button type="button" class="add-filminglocation btn btn-info">
						    	<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
						    </button>	
						</div>
					</div>
					<div class="form-group">
						<label>Technicalspecs: </label>					
						<div id="technicalspecs" class="technicalspecs">
							<table><tr><td><br>
							<label>Sound Mix Type: </label>	</td><td><br>
							<input type="text" name="sound_mix_type" ></td></tr><tr><td><br>
							<label>Color: </label>	</td><td><br>
							<input type="text" name="color" ></td></tr><tr><td><br>
							<label>Aspect Ratio: </label>	</td><td><br>
							<input type="text" name="aspect_ratio" ></td></tr></table>
		                </div>
					</div>
					<div class="form-group">
						<label>Award Name : </label>					
						<div class="award">
							<button type="button" class="add-award btn btn-info">
						    	<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
						    </button>	
						</div>
					</div>
					<div class="form-group">
						<label>Image Gallery: </label>					
						<div class="gallery">
							<button type="button" class="add-gallery btn btn-info">
						    	<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
						    </button>	
						</div>
					</div>
					<button type="submit" value=" Submit "  class="btn btn-success" name="submit">Submit</button>
				</form>
			</div>
		</div>

</div>
<script type="text/javascript">	
	$(document).ready(function() {
	    var wrapper1=$(".gallery");
	    var add_button1=$(".add-gallery");
	    var gallery_html='<div><br><label>Small Image Path:</label><input type="file" name="small_image_path[]"><label>Large Image Path:</label><input type="file" name="large_image_path[]"><a href="#" class="remove_field">Remove</a></div>';
	    var wrapper2=$(".award");
	    var add_button2=$(".add-award");
	    var award_html='<div><br><label>Add Award: </label><input type="text" class="form-control" name="award_name[]" ><a href="#" class="remove_field">Remove</a></div>';
	    var wrapper3=$(".filminglocation");
	    var add_button3=$(".add-filminglocation");
	    var filminglocation_html='<div><br><label>State Name : </label><select class="form-control" id="filminglocation" name="city[]" required><option>Select State Name</option>@foreach ( $city as $c )<option name="{{$c->city_id}}" value="{{$c->city_id}}">{{$c->city_name}}</option>@endforeach</select><a href="#" class="remove_field">Remove</a></div>';
	    var wrapper4=$(".distributors");
	    var add_button4=$(".add-distributors");
	    var distributors_html='<div><br><label>Add Distributor: </label><input type="text" class="form-control" name="distributors[]" ><a href="#" class="remove_field">Remove</a></div>';
	    var wrapper5=$(".productionco");
	    var add_button5=$(".add-productionco");
	    var productionco_html='<div><br><label>Add Production Co: </label><input type="text" class="form-control" name="productionco[]" ><a href="#" class="remove_field">Remove</a></div>';
	    var wrapper6=$(".country");
	    var add_button6=$(".add-country");
	    var country_html='<div><br><label>State Country Name : </label><select class="form-control" id="country" name="country[]" required><option>Select Country Name</option>@foreach ( $country as $c )<option name="{{$c->country_id}}" value="{{$c->country_id}}">{{$c->country_name}}</option>@endforeach</select><a href="#" class="remove_field">Remove</a></div>';
	    
	    
	    $(add_button1).click(function(e){
	        e.preventDefault();
	        $(wrapper1).append(gallery_html);
	    });
	    $(wrapper1).on("click",".remove_field", function(e){ 
	        e.preventDefault(); $(this).parent('div').remove();
	    })	    
	    $(add_button2).click(function(e){
	        e.preventDefault();
	        $(wrapper2).append(award_html);
	    });
	    $(wrapper2).on("click",".remove_field", function(e){ 
	        e.preventDefault(); $(this).parent('div').remove();
	    })
	    $(add_button3).click(function(e){
	        e.preventDefault();
	        $(wrapper3).append(filminglocation_html);
	    });
	    $(wrapper3).on("click",".remove_field", function(e){ 
	        e.preventDefault(); $(this).parent('div').remove();
	    })
	    $(add_button4).click(function(e){
	        e.preventDefault();
	        $(wrapper4).append(distributors_html);
	    });
	    $(wrapper4).on("click",".remove_field", function(e){ 
	        e.preventDefault(); $(this).parent('div').remove();
	    })
	    $(add_button5).click(function(e){
	        e.preventDefault();
	        $(wrapper5).append(productionco_html);
	    });
	    $(wrapper5).on("click",".remove_field", function(e){ 
	        e.preventDefault(); $(this).parent('div').remove();
	    })
	    $(add_button6).click(function(e){
	        e.preventDefault();
	        $(wrapper6).append(country_html);
	    });
	    $(wrapper6).on("click",".remove_field", function(e){ 
	        e.preventDefault(); $(this).parent('div').remove();
	    })
	});
</script>


@stop