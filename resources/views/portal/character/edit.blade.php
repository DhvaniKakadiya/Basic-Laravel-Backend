@extends('layouts.master')
@section('content')


<div class="row">
    <div class="col-lg-12">
    	@foreach ( $characte as $c )
        <h1 class="page-header">{{$c->characte_name}} <a class="btn btn-primary" href="/character">Back</a></h1>
		<div class="row">
			<div class="col-lg-8">		
				<form action="./{{$c->characte_id}}" method="POST" enctype="multipart/form-data">
					{{csrf_field()}}
					<div class="form-group">
						<label>character Name : </label>
						<input type="text" class="form-control" name="characte_name" value="{{$c->characte_name}}" required>
					</div>
					<div class="form-group">	
						<label>Biography : </label>
						<textarea class="form-control" name="biography">{{$c->biography}}</textarea>
					</div>
					<div class="form-group">	
						<label>Poster Path</label>
						<div id="poster">
							<img src="/public/image_gallery/{{ $c->poster_path}}" width="100" height="100" ></img>
							<input type="file" name="poster_path" >
						</div>
					</div>
					<div class="form-group">
						<label>Image Gallery: </label>
						
					    <?php $i=0?>
							@foreach($character_gallery as $cg)
							<div class="gallery1">
						    	<br>
								<label>Small Image Path: </label>
								@if ($cg->characte_id == $c->characte_id) 
									<?php $i++?>
									<img src="/public/image_gallery/{{ $cg->small_image_path}}" width="100" height="100" name="small_image[]"></img>
									<div class="hidden"> <input type="text" name="small<?php echo $i?>" value="hi" >	</div>
									<input type="file" name="small_image_path[]" >
									<label>Large Image Path: </label>
									<img src="/public/image_gallery/{{$cg->large_image_path}}" width="100" height="100" name="large_image[]"></img>
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
		var wrapper1=$(".gallery1");
		$(wrapper1).on("click",".remove_field", function(e){ 
	        e.preventDefault(); $(this).parent('div').remove();
	    })
	    var wrapper=$(".gallery");
	    var add_button=$(".add-gallery");
	    var gallery_html='<div class="gallery"><br><label>Small Image Path: </label><input type="file" name="small_image_path[]" ><label>Large Image Path: </label>	<input type="file" name="large_image_path[]" ><a href="#" class="remove_field">Remove</a></div>';
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