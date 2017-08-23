@extends('layouts.master')
@section('content')
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>

<div class="row">
    <div class="col-lg-12">
    	@foreach ( $series as $s )
        <h1 class="page-header">{{$s->series_name}} <a class="btn btn-primary" href="/series">Back</a></h1>
		<div class="row">
			<div class="col-lg-8">		
				<form action="./{{$s->series_id}}" method="POST" enctype="multipart/form-data">
					{{csrf_field()}}
					<div class="form-group">
						<label>Series Name : </label>
						<input type="text" class="form-control" name="series_name" value="{{$s->series_name}}"required>
					</div>
					<div class="form-group">	
						<label>Summary Text: </label>
						<textarea class="form-control" name="summary_text">{{$s->summary_text}}</textarea>
					</div>
					<div class="form-group">
						<label>Story: </label>
						<input class="form-control" type="text" name="storyline" value="{{$s->storyline}}">
					</div>
					<div class="form-group">
						<label>Published date: </label>
						<input type="date" class="form-control" type="text" name="published_date" value="{{$s->published_date}}">
					</div>
					<div class="form-group">	
						<label>Trailer link: </label>
						<textarea class="form-control" name="trailer_link">{{$s->trailer_link}}</textarea>
					</div>
					<div class="form-group">	
						<label>Series Fb: </label>
						<textarea class="form-control" name="series_fb" >{{$s->series_fb}}</textarea>
					</div>
					<div class="form-group">	
						<label>Series Insta: </label>
						<textarea class="form-control" name="series_insta" >{{$s->series_insta}}</textarea>
					</div>
					<div class="form-group">	
						<label>Series Twitter: </label>
					<textarea class="form-control" name="series_twitter" >{{$s->series_twitter}}</textarea>
					</div>
					<div class="form-group">	
						<label>Poster Image Path: </label>
						<div id="poster-path">
							<img src="/public/image_gallery/{{ $s->poster_path}}" width="100" height="100" ></img>
						<input type="file" name="poster_path" >
						</div>
					</div>
					<div class="form-group">	
						<label>Thumbnail Image Path : </label>
						<div id="thumbnail-path">
							<img src="/public/image_gallery/{{ $s->thumbnail_path}}" width="100" height="100" ></img>
						<input type="file" name="thumbnail_path" >
						</div>
					</div>
					<div class="form-group">
						<label>Creator Name : </label>
						<select class="form-control" id="creator_id" name="creator_id" required>
							@foreach($creator as $c)
							@if ($c->creator_id == $s->creator_id) 
							<option name="{{$c->creator_id}}" selected value="{{$c->creator_id}}">{{$c->creator_name}}</option>
							@else
							<option name="{{$c->creator_id}}" value="{{$c->creator_id}}">{{$c->creator_name}}</option>
							@endif
							@endforeach
						</select>
					</div>
                   				
					<div class="form-group">
						<label>Genre Name : </label>
						<div class="row">
							@foreach ( $genre as $g)								
 									<div class="col-lg-6">
									@if (in_array($g->genre_id, $series_to_genre_mapping))
								    <div class="input-group">
								      <span class="input-group-addon">
								        <input type="checkbox" name="genre_id[]" value="{{$g->genre_id}}" id="genre" checked>
								      </span>
								      <input type="text" class="form-control" value="{{$g->genre_name}}" readonly>
								    </div>
								    @else
								    <div class="input-group">
								      <span class="input-group-addon">
								        <input type="checkbox" name="genre_id[]" value="{{$g->genre_id}}" id="genre">
								      </span>
								      <input type="text" class="form-control" value="{{$g->genre_name}}" readonly>
								    </div>
								    @endif
									</div>
							@endforeach
						</div>
					</div>
					<div class="form-group">
						<label>Language Name : </label>
						<div class="row">
							@foreach ( $language as $l)								
 									<div class="col-lg-6">
									@if (in_array($l->language_id, $series_language))
								    <div class="input-group">
								      <span class="input-group-addon">
								        <input type="checkbox" name="language_id[]" value="{{$l->language_id}}" id="language" checked>
								      </span>
								      <input type="text" class="form-control" value="{{$l->language_name}}" readonly>
								    </div>
								    @else
								    <div class="input-group">
								      <span class="input-group-addon">
								        <input type="checkbox" name="language_id[]" value="{{$l->language_id}}" id="language">
								      </span>
								      <input type="text" class="form-control" value="{{$l->language_name}}" readonly>
								    </div>
								    @endif
									</div>
							@endforeach
						</div>
					</div>
					<div class="form-group">
						<label>Country : </label>
						@foreach ($series_country as $sc)
							<div class="country1">
						    	<br>
								<label>Add Country: </label>
								<select class="form-control" name="country[]" required>
									@foreach ( $country as $c )
										@if ($c->country_id == $sc->country_id) 
										<option name="{{$c->country_id}}" selected value="{{$c->country_id}}">{{$c->country_name}}</option>
										@else
										<option name="{{$c->country_id}}" value="{{$c->country_id}}">{{$c->country_name}}</option>
										@endif
									@endforeach
								</select>
								<a href="#" class="remove_field">Remove</a>
							</div>
				        	@endforeach
            			<div class="country">
							<button type="button" class="add-country btn btn-info">
						    	<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
						    </button>	
						</div>
        			</div>
        			<div class="form-group">
						<label>Production Co. Name : </label>
						@foreach ($productionco as $pc)
							<div class="productionco1">
						    	<br>
								<label>Add Production Co.: </label>
									<input value="{{$pc}}" type="text" class="form-control" name="productionco[]">
								<a href="#" class="remove_field">Remove</a></div>
				        @endforeach
            			<div class="productionco">
			                <button type="button" class="add-productionco btn btn-info">
						    	<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
						    </button>
					    </div>
        			</div>
        			<div class="form-group">
						<label>Distributors Name : </label>
						@foreach ($distributors as $d)
							<div class="distributors1">
						    	<br>
								<label>Add Distributor: </label>

									<input value="{{$d}}" type="text" class="form-control" name="distributors[]">
								<a href="#" class="remove_field">Remove</a></div>
				        @endforeach
            			<div class="distributors">
			                <button type="button" class="add-distributors btn btn-info">
						    	<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
						    </button>
					    </div>
        			</div>
					<div class="form-group">
						<label>Filminglocation: </label>
						@foreach ($filminglocation as $sf)
							<div class="filminglocation1">
						    	<br>
								<label>State Name : </label>
									<select class="form-control" id="filminglocation" name="city[]" required>
										@foreach ( $city as $c )
												@if ($sf->city_id == $c->city_id) 
												<option name="{{$c->city_id}}" selected value="{{$c->city_id}}">{{$c->city_name}}</option>
												@else
												<option name="{{$c->city_id}}" value="{{$c->city_id}}">{{$c->city_name}}</option>
												@endif
										@endforeach
									</select>
								<a href="#" class="remove_field">Remove</a></div>
				        @endforeach
            			<div class="filminglocation">
			                <button type="button" class="add-filminglocation btn btn-info">
						    	<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
						    </button>
					    </div>
        			</div>
					<div class="form-group">
						<label>Technicalspecs: </label>	
						@foreach ($technicalspecs as $t)				
						<div id="technicalspecs" class="technicalspecs">
							<table><tr><td><br>
							<label>Sound Mix Type: </label>	</td><td><br>
							<input type="text" name="sound_mix_type" value="{{$t->sound_mix_type}}"></td></tr><tr><td><br>
							<label>Color: </label>	</td><td><br>
							<input type="text" name="color" value="{{$t->color}}"></td></tr><tr><td><br>
							<label>Aspect Ratio: </label>	</td><td><br>
							<input type="text" name="aspect_ratio" value="{{$t->aspect_ratio}}"></td></tr></table>
		                </div>
		                @endforeach
					</div>
					
        			<div class="form-group">
						<label>Award Name: </label>
						
					    
							@foreach ($series_awards as $sa)
							<div class="award1">
	            				<input value="{{$sa}}" type="text" class="form-control" name="award_name[]">
	            				<a href="#" class="remove_field">Remove</a>
	            			</div>
            				@endforeach
			        	
			        	<div class="award">
			                <button type="button" class="add-award btn btn-info">
						    	<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
						    </button>
					    </div>
					</div>
					<div class="form-group">
						<label>Image Gallery: </label>
						
					    <?php $i=0?>
							@foreach($series_gallery as $sg)
							<div class="gallery1">
						    	<br>
						    	<label>Small Image Path: </label>	
						    	@if ($sg->series_id == $s->series_id) 
									<?php $i++?>
									<img src="/public/image_gallery/{{ $sg->small_image_path}}" width="100" height="100" name="small_image[]"></img>
									<div class="hidden"> <input type="text" name="small<?php echo $i?>" value="hi" >	</div>
								
								<input type="file" name="small_image_path[]" >
								<label>Large Image Path: </label>	
								<img src="/public/image_gallery/{{$sg->large_image_path}}" width="100" height="100" name="large_image[]"></img>
								<div class="hidden"> <input type="text" name="large<?php echo $i?>" value="hi"></div>	
								<input type="file" name="large_image_path[]" >
								<a href="#" class="remove_field">Remove</a></div>
				            @endif
				            @endforeach
			        	
			        	<div class="gallery">
			                <button type="button" class="add-gallery btn btn-info">
						    	<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
						    </button>
					    </div>
					</div>
					
					@endforeach
					<button type="submit" value="Submit"  class="btn btn-success" name="submit">Submit</button>
				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">	
	$(document).ready(function() {

		var gallery1_html=$(".gallery1");
		var wrapper11=$(".gallery1");
		$(wrapper11).on("click",".remove_field", function(e){ 
	        e.preventDefault(); $(this).parent('div').remove();
	    })
	    var award1_html=$(".award1");
		var wrapper12=$(".award1");
		$(wrapper12).on("click",".remove_field", function(e){ 
	        e.preventDefault(); $(this).parent('div').remove();
	    })
	    var filminglocation1_html=$(".filminglocation1");
		var wrapper13=$(".filminglocation1");
		$(wrapper13).on("click",".remove_field", function(e){ 
	        e.preventDefault(); $(this).parent('div').remove();
	    })
	    var distributors1_html=$(".distributors1");
		var wrapper14=$(".distributors1");
		$(wrapper14).on("click",".remove_field", function(e){ 
	        e.preventDefault(); $(this).parent('div').remove();
	    })
	    var productionco1_html=$(".productionco1");
		var wrapper15=$(".productionco1");
		$(wrapper15).on("click",".remove_field", function(e){ 
	        e.preventDefault(); $(this).parent('div').remove();
	    })
	    var country1_html=$(".country1");
		var wrapper16=$(".country1");
		$(wrapper16).on("click",".remove_field", function(e){ 
	        e.preventDefault(); $(this).parent('div').remove();
	    })


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