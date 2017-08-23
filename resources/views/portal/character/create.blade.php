@extends('layouts.master')
@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            character <a class="btn btn-primary" href="/character">Back</a>
        </h1>
		<div class="row">
			<div class="col-lg-8">		
				<form action="./" method="POST" enctype="multipart/form-data">
					{{csrf_field()}}
					<div class="form-group">
						<label>character Name : </label>
						<input type="text" class="form-control" name="characte_name" required>
					</div>
					<div class="form-group">	
						<label>Biography : </label>
						<textarea class="form-control" name="biography"></textarea>
					</div>
					<div class="form-group">	
						<label>Poster Path </label>
						<div id="poster">
						<input type="file" name="poster_path">
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
					<button type="submit" value="Submit"  class="btn btn-success" name="submit">Submit</button>
				</form>
			</div>
		</div>

</div>
<script type="text/javascript">	
	$(document).ready(function() {
	    var wrapper=$(".gallery");
	    var add_button=$(".add-gallery");
	    var gallery_html='<div><br><label>Small Image Path: </label><input type="file" name="small_image_path[]" ><label>Large Image Path: </label>	<input type="file" name="large_image_path[]" ><a href="#" class="remove_field">Remove</a></div>';
	    $(add_button).click(function(e){
	        e.preventDefault();
	        $(wrapper).append(gallery_html);
	    });
	    $(wrapper).on("click",".remove_field", function(e){ 
	        e.preventDefault(); $(this).parent('div').remove();
	    })
	});
</script>
@stop