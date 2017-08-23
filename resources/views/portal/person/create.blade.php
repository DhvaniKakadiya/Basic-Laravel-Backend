@extends('layouts.master')
@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Person <a class="btn btn-primary" href="/person">Back</a>
        </h1>
		<div class="row">
			<div class="col-lg-8">		
				<form action="./" method="POST" enctype="multipart/form-data">
					{{csrf_field()}}
					<div class="form-group">
						<label>Person Name : </label>
						<input type="text" class="form-control" name="person_name">
					</div>
					<div class="form-group">	
						<label>Person Date of Birth: </label>
						<input class="form-control" type="date" name="birth_date">
					</div>
					<div class="form-group">	
						<label>Person place of Birth: </label>
						<input class="form-control" type="text" name="birth_place">
					</div>
					<div class="form-group">	
						<label>Person Date of Death: </label>
						<input class="form-control" type="date" name="death_date">
					</div>
					<div class="form-group">	
						<label>Person place of Death: </label>
						<input class="form-control" type="text" name="death_place">
					</div>
					<div class="form-group">	
						<label>Short Description: </label>
						<textarea class="form-control" name="short_description"></textarea>
					</div>
					<div class="form-group">	
						<label>Person Full Bio: </label>
						<textarea class="form-control" name="full_biography"></textarea>
					</div>
                                        <div class="form-group">	
						<label>Square Image: </label><div id="square-image">
						<input type="file" name="square_image" >
						</div>
					</div>
                                        <div class="form-group">	
						<label>Poster Image: </label><div id="poster-image">
						<input type="file" name="poster_image" >
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
	});
</script>
@stop