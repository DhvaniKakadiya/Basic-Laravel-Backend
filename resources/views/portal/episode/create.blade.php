@extends('layouts.master')
@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Episode <a class="btn btn-primary" href="/episode">Back</a></h1>
        </h1>
		<div class="row">
			<div class="col-lg-8">		
				<form action="./" method="POST" enctype="multipart/form-data">
					{{csrf_field()}}
					
					<div class="form-group">
						<label>Series Name : </label>
						<select class="form-control" id="series" name="series_id" required>
							<option>Select Series Name</option>
							@foreach ( $series as $s )
							<option name="{{$s->series_id}}" value="{{$s->series_id}}">{{$s->series_name}}</option>
							@endforeach
						</select>
					</div>
					
					<div class="form-group">
						<label>Season Name : </label>
						<select class="form-control" id="season" name="season_id" required >
							<option>Select Season Name</option>
						</select>
					</div>
					
					<div class="form-group">
						<label>Episode Name : </label>
						<input type="text" class="form-control" name="episode_name" required>
					</div>
					<div class="form-group">
						<label>Episode No. : </label>
						<input type="number" class="form-control" name="episode_number">
					</div>
					<div class="form-group">	
						<label>Published Date : </label>
						<input type="date" class="form-control" name="published_date">
					</div>
					<div class="form-group">	
						<label>Time Length : </label>
						<input type="number" class="form-control" name="time_length">
					</div>
					<div class="form-group">	
						<label>Short Description: </label>
						<textarea class="form-control" name="short_bio"></textarea>
					</div>
					<div class="form-group">	
						<label>Storyline: </label>
						<textarea class="form-control" name="storyline"></textarea>
					</div>
					<div class="form-group">	
						<label>Poster Image Path: </label>
						<div id="poster-image-path">
						<input type="file" name="poster_image_path" >
						</div>
					</div>
					<div class="form-group">	
						<label>Lanscape Image Path : </label>
						<div id="landscape-image-path">
						<input type="file" name="landscape_image_path" >
						</div>
					</div>
					<div class="form-group">	
						<label>Thumbnail Image Path : </label>
						<div id="thumbnail-image-path">
						<input type="file" name="thumbnail_image_path" >
						</div>
					</div>
					<div class="form-group">
						<lable>Filmography</lable>				
						<div class="filmography">
							<button type="button" class="add-filmography btn btn-info">
						    	<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
						    </button>	
						</div>
					</div>
					<div class="form-group">
						<label>Dialogues: </label>				
						<div class="dialogues">
							<button type="button" class="add-dialogues btn btn-info">
						    	<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
						    </button>	
						</div>
					</div>
					<div class="form-group">
						<label>Cast: </label>					
						<div class="cast">
							<button type="button" class="add-cast btn btn-info">
						    	<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
						    </button>	
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
						<label>Review : </label>					
						<div class="review">
							<button type="button" class="add-review btn btn-info">
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

    $('#series').change(function(){
    var series_id = $(this).val();
       
    if(series_id.length>0){
    	$.get("/episode/create/getseasonlist/"+series_id , function( d ){
    		$("#season").empty();
    		$.each(d,function(k, season){
    			var opt = $('<option>',{
    						value:season.season_id,
    						text:season.season_number,
    					});
    			$('#season').append( opt );
    		});
    		$("#season").removeAttr("disabled");

    	});
    }else{
        $("#season").empty();
    }      
   });
</script> 
                                                                                                                                                                                                                                                                                                                                                                                                                                                
<script type="text/javascript">	
	$(document).ready(function() {
	    var wrapper1=$(".gallery");
	    var add_button1=$(".add-gallery");
	    var gallery_html='<div><br><label>Small Image Path:</label><input type="file" name="small_image_path[]"><label>Large Image Path:</label><input type="file" name="large_image_path[]"><a href="#" class="remove_field">Remove</a></div>';
	    var wrapper2=$(".award");
	    var add_button2=$(".add-award");
	    var award_html='<div><br><label>Add Award: </label><input type="text" class="form-control" name="award_name[]" ><a href="#" class="remove_field">Remove</a></div>';
	    var wrapper3=$(".filmography");
	    var add_button3=$(".add-filmography");
	    var filmography_html='<div><br><label>Person Name : </label><select class="form-control" id="filmography" name="personf[]" required><option>Select Person Name</option>@foreach ( $person as $p )<option name="{{$p->person_id}}" value="{{$p->person_id}}">{{$p->person_name}}</option>@endforeach</select><label>Work Role : </label><select class="form-control" id="filmography" name="work[]" required><option>Select Work Role</option>@foreach ( $work as $w )<option name="{{$w->work_id}}" value="{{$w->work_id}}">{{$w->role}}</option>@endforeach</select><a href="#" class="remove_field">Remove</a></div>';
	    var wrapper4=$(".dialogues");
	    var add_button4=$(".add-dialogues");
	    var dialogues_html='<div><br><label>Add Dialogue : </label><textarea class="form-control" name="dialogues[]"></textarea><label>Character Name : </label><select class="form-control" id="dialogues" name="characterd[]" required><option>Select Character Name</option>@foreach ( $character as $c )<option name="{{$c->characte_id}}" value="{{$c->characte_id}}">{{$c->characte_name}}</option>@endforeach</select><a href="#" class="remove_field">Remove</a></div>';
	    var wrapper5=$(".cast");
	    var add_button5=$(".add-cast");
	    var cast_html='<div><br><label>Character Name : </label><select class="form-control" id="cast" name="character[]" required><option>Select Character Name</option>@foreach ( $character as $c )<option name="{{$c->characte_id}}" value="{{$c->characte_id}}">{{$c->characte_name}}</option>@endforeach</select><label>Person Name : </label><select class="form-control" id="cast" name="person[]" required><option>Select Person Name</option>@foreach ( $person as $p )<option name="{{$p->person_id}}" value="{{$p->person_id}}">{{$p->person_name}}</option>@endforeach</select><a href="#" class="remove_field">Remove</a></div>';
	    var wrapper6=$(".review");
	    var add_button6=$(".add-review");
	    var review_html='<div><br><label>Author Name : </label><input type="text" class="form-control" name="author_name[]" ><label>Review Title : </label><input type="text" class="form-control" name="review_title[]" ><label>Review Text: </label><input type="text" class="form-control" name="review_text[]" ><a href="#" class="remove_field">Remove</a></div>';
	    
	    
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
	        $(wrapper3).append(filmography_html);
	    });
	    $(wrapper3).on("click",".remove_field", function(e){ 
	        e.preventDefault(); $(this).parent('div').remove();
	    })
	    $(add_button4).click(function(e){
	        e.preventDefault();
	        $(wrapper4).append(dialogues_html);
	    });
	    $(wrapper4).on("click",".remove_field", function(e){ 
	        e.preventDefault(); $(this).parent('div').remove();
	    })
	    $(add_button5).click(function(e){
	        e.preventDefault();
	        $(wrapper5).append(cast_html);
	    });
	    $(wrapper5).on("click",".remove_field", function(e){ 
	        e.preventDefault(); $(this).parent('div').remove();
	    })
	    $(add_button6).click(function(e){
	        e.preventDefault();
	        $(wrapper6).append(review_html);
	    });
	    $(wrapper6).on("click",".remove_field", function(e){ 
	        e.preventDefault(); $(this).parent('div').remove();
	    })
	});
</script>


@stop