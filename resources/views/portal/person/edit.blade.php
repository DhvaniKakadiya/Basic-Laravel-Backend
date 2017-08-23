@extends('layouts.master')
@section('content')


<div class="row">
    <div class="col-lg-12">
    	@foreach ( $person as $p )
        <h1 class="page-header">{{$p->person_name}} <a class="btn btn-primary" href="/person">Back</a></h1>
		<div class="row">
			<div class="col-lg-8">
				<form action="./{{$p->person_id}}" method="POST" enctype="multipart/form-data">
					{{csrf_field()}}
					<div class="form-group">
						<label>Person Name : </label>
						<input type="text" class="form-control" name="person_name" value="{{$p->person_name}}" required>
					</div>
					<div class="form-group">
						<label>Person Date of Birth: </label>
						<input class="form-control" type="date" name="birth_date" value="{{$p->birth_date}}">
					</div>
					<div class="form-group">
						<label>Person place of Birth: </label>
						<input class="form-control" type="text" name="birth_place" value="{{$p->birth_place}}">
					</div>
					<div class="form-group">
						<label>Person Date of Death: </label>
						<input class="form-control" type="date" name="death_date" value="{{$p->death_date}}">
					</div>
					<div class="form-group">
						<label>Person place of Death: </label>
						<input class="form-control" type="text" name="death_place" value="{{$p->death_place}}">
					</div>
					<div class="form-group">
						<label>Person Short Bio: </label>
						<textarea class="form-control" name="short_description">{{$p->short_description}}</textarea>
					</div>
					<div class="form-group">
						<label>Person Full Bio: </label>
						<textarea class="form-control" name="full_biography">{{$p->full_biography}}</textarea>
					</div>
                                         <div class="form-group">	
						<label>Square Image: </label>
						<div id="square-image">
							<img src="/public/image_gallery/{{ $p->square_image}}" width="100" height="100" ></img>
						<input type="file" name="square_image" >
						</div>
					</div>
                                        <div class="form-group">	
						<label>Poster Image : </label>
						<div id="poster-image">
							<img src="/public/image_gallery/{{ $p->poster_image}}" width="100" height="100" ></img>
						<input type="file" name="poster_image" >
						</div>
					</div>
        			<div class="form-group">
						<label>Award Name: </label>
						
					    
							@foreach ($person_awards as $pa)
							<div class="award1">
	            				<input value="{{$pa}}" type="text" class="form-control" name="award_name[]">
	            				<a href="#" class="remove_field">Remove</a></div>
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
							@foreach($person_gallery as $pg)
							<div class="gallery1">
						    	<br>
						    	<label>Small Image Path: </label>	
						    	@if ($pg->person_id == $p->person_id) 
									<?php $i++?>
									<img src="/public/image_gallery/{{ $pg->small_image_path}}" width="100" height="100" name="small_image[]"></img>
									<div class="hidden"> <input type="text" name="small<?php echo $i?>" value="hi" >	</div>
								
								<input type="file" name="small_image_path[]" >
								<label>Large Image Path: </label>	
								<img src="/public/image_gallery/{{$pg->large_image_path}}" width="100" height="100" name="large_image[]"></img>
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
					</div>
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
	    var wrapper1=$(".gallery");
	    var add_button1=$(".add-gallery");
	    var gallery_html='<div class="gallery"><br><label>Small Image Path: </label><input type="file" name="small_image_path[]" ><label>Large Image Path: </label>	<input type="file" name="large_image_path[]" ><a href="#" class="remove_field">Remove</a></div>';
	    $(add_button1).click(function(e){
	        e.preventDefault();
	        $(wrapper1).append(gallery_html);
	    });
	    $(wrapper1).on("click",".remove_field", function(e){ 
	        e.preventDefault(); $(this).parent('div').remove();
	    })
	    var award1_html=$(".award1");
		var wrapper11=$(".award1");
		$(wrapper11).on("click",".remove_field", function(e){ 
	        e.preventDefault(); $(this).parent('div').remove();
	    })
	    var wrapper2=$(".award");
	    var add_button2=$(".add-award");
	    var award_html='<div><br><label>Add Award: </label><input type="text" class="form-control" name="award_name[]" ><a href="#" class="remove_field">Remove</a></div>';
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
