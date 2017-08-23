
@extends('layouts.master')
@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            City <a class="btn btn-primary" href="/city">Back</a>
        </h1>
		<div class="row">
			<div class="col-lg-8">		
				<form action="./" method="POST">
					{{csrf_field()}}
					<div class="form-group">
						<label>Country Name : </label>
						<select class="form-control" name="country_id" required>
							<option>Select Country Name</option>
							@foreach ( $country as $cn )
							<option name="{{$cn->country_id}}" value="{{$cn->country_id}}">{{$cn->country_name}}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<lable>City Name:</lable>
						<div class="city">
							<button type="button" class="add-city btn btn-info">
						    	<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
						    </button>	
						</div>
					</div>

					<button type="submit" value=" Submit "  class="btn btn-success" name="submit">Submit</button>
				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">	
	$(document).ready(function() {
	    var wrapper=$(".city");
	    var add_button=$(".add-city");
	    var city_html='<div><br><label>Add City:</label><input type="text" class="form-control" name="city_name[]" required><a href="#" class="remove_field">Remove</a></div>';
	    $(add_button).click(function(e){
	        e.preventDefault();
	        $(wrapper).append(city_html);
	    });
	    $(wrapper).on("click",".remove_field", function(e){ 
	        e.preventDefault(); $(this).parent('div').remove();
	    })
	});
</script>

@stop