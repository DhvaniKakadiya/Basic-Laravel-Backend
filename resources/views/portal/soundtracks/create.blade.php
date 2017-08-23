@extends('layouts.master')
@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Soundtracks <a class="btn btn-primary" href="/soundtracks">Back</a>
        </h1>
		<div class="row">
			<div class="col-lg-8">		
				<form action="./" method="POST">
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
						<select class="form-control" id="episode" name="episode_id" required>
							<option>Select Episode Name</option>
						</select>
					</div>
					<div class="form-group">
						<label>Song Name : </label>			
						<input type="text" class="form-control" name="song_name" >
					</div>
					
					<div class="form-group">
						<label>Composer List : </label>					
						<div class="composerlist">
							<button type="button" class="add-composerlist btn btn-info">
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

    $('#series').change(function(){
    var series_id = $(this).val();
       
    if(series_id.length>0){
    	$.get("/soundtracks/create/getseasonlist/"+series_id , function( d ){
    		$("#season").empty();
    		var opt = $('<option>',{
    						value:'1',
    						text:'Select Season Number',
    					});
    		$('#season').append( opt );
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

    $('#season').change(function(){
    var season_id = $(this).val();
       
    if(season_id.length>0){
    	$.get("/soundtracks/create/getepisodelist/"+season_id , function( d ){
    		$("#episode").empty();
    		$.each(d,function(k, episode){
    			var opt = $('<option>',{
    						value:episode.episode_id,
    						text:episode.episode_name,
    					});
    			$('#episode').append( opt );
    		});
    		$("#episode").removeAttr("disabled");

    	});
    }else{
        $("#episode").empty();
    }      
   });
</script> 
<script type="text/javascript">	
	$(document).ready(function() {
	    var wrapper=$(".composerlist");
	    var add_button=$(".add-composerlist");
	    var composerlist_html='<div><br><label>Add Composer Name: </label><select class="form-control" id="composerlist" name="composerlist[]" required><option>Select Person Name</option>@foreach ( $person as $p )<option name="{{$p->person_id}}" value="{{$p->person_id}}">{{$p->person_name}}</option>@endforeach</select><a href="#" class="remove_field">Remove</a></div>';
	    $(add_button).click(function(e){
	        e.preventDefault();
	        $(wrapper).append(composerlist_html);
	    });
	    $(wrapper).on("click",".remove_field", function(e){ 
	        e.preventDefault(); $(this).parent('div').remove();
	    })
	    });
</script>
@stop