@extends('layouts.master')
@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Did You Know <a class="btn btn-primary" href="/DidYouKnow">Back</a>
        </h1>
		<div class="row">
			<div class="col-lg-8">		
				<form action="./" method="POST">
					{{csrf_field()}}
					<div class="form-group">
						<label>Series Name</label>
						<select class="form-control" id="dialogues" name="episode" required>
								<option>Select Series</option>
								@foreach ( $episode as $c )
								<option name="{{$c->series_id}}" value="{{$c->series_id}}">
								{{$c->series_name}}</option>
								@endforeach
						</select>
					</div>
					<div class="form-group">
						<label>Travia</label>
					    <div class="input_fields_wrap-tr">
						    <button type="button" class="add_field_button-tr btn btn-info">
						    	<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
						    </button>					
					    </div>

					</div>
					<div class="form-group">
						<label>Quotes</label>
						<div class="input_fields_wrap-qu">
						    <button type="button" class="add_field_button-qu btn btn-info">
						    	<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
						    </button>					
					    </div>
					</div>
					<div class="form-group">
						<label>CrazyCredits</label>
						<div class="input_fields_wrap-cc">
						    <button type="button" class="add_field_button-cc btn btn-info">
						    	<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
						    </button>					
					    </div>
					</div>
					<div class="form-group">
						<label>Goofs</label>
						<div class="input_fields_wrap-go">
						    <button type="button" class="add_field_button-go btn btn-info">
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
	      //Travia
	    var t_count = 0 ; 
	    var wrapper         = $(".input_fields_wrap-tr"); //Fields wrapper
	    var add_button      = $(".add_field_button-tr"); //Add button ID
	    var travia_html = '<div><br><label>Add Travia : </label><textarea class="form-control" name="travia[]"></textarea><input type="checkbox" name="travia-chk-box['+t_count+']" value="true">Contain Spoiler<br><a href="#" class="remove_field">Remove</a></div>';
	    function update_travia_html() {
	    	travia_html = '<div><br><label>Add Travia : </label><textarea class="form-control" name="travia[]"></textarea><input type="checkbox" name="travia-chk-box['+t_count+']" value="true">Contain Spoiler<br><a href="#" class="remove_field">Remove</a></div>';
	    }
	    $(add_button).click(function(e){ //on add input button click
	        e.preventDefault();
	        $(wrapper).append(travia_html); //add input box
	        t_count = t_count+1;
	        update_travia_html();
	    });
	    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
	        e.preventDefault(); $(this).parent('div').remove();
	        t_count = t_count-1;
	        update_travia_html();
	    })
	    //Quotes
	    var q_count = 0 ;
	    var wrapper1         = $(".input_fields_wrap-qu"); //Fields wrapper
	    var add_button1      = $(".add_field_button-qu"); //Add button ID
	    var quotes_html = '<div><br><label>Add Quotes : </label><textarea class="form-control" name="quotes[]"></textarea><input type="checkbox" name="quotes-chk-box['+q_count+']" value="true">Contain Spoiler<br><a href="#" class="remove_field">Remove</a></div>';
	    function update_quotes_html() {
	    	quotes_html = '<div><br><label>Add Quotes : </label><textarea class="form-control" name="quotes[]"></textarea><input type="checkbox" name="quotes-chk-box['+q_count+']" value="true">Contain Spoiler<br><a href="#" class="remove_field">Remove</a></div>';
	    }
	    $(add_button1).click(function(e){ //on add input button click
	        e.preventDefault();
	        $(wrapper1).append(quotes_html); //add input box
	        q_count++;
	        update_quotes_html();
	    });
	    $(wrapper1).on("click",".remove_field", function(e){ //user click on remove text
	        e.preventDefault(); $(this).parent('div').remove();
	        q_count--;
	        update_quotes_html();
	    })

	    //CrazyCredits
	    var cc_c = 0 ;
	    var wrapper2         = $(".input_fields_wrap-cc"); //Fields wrapper
	    var add_button2      = $(".add_field_button-cc"); //Add button ID
	    var crazy_credits_html = '<div><br><label>Add CrazyCredits : </label><textarea class="form-control" name="crazy_credits[]"></textarea><input type="checkbox" name="crazy_credits-chk-box['+cc_c+']" value="true">Contain Spoiler<br><a href="#" class="remove_field">Remove</a></div>';
	    function update_crazy_credits_html() {
	    	crazy_credits_html = '<div><br><label>Add CrazyCredits : </label><textarea class="form-control" name="crazy_credits[]"></textarea><input type="checkbox" name="crazy_credits-chk-box['+cc_c+']" value="true">Contain Spoiler<br><a href="#" class="remove_field">Remove</a></div>';
	    }
	    $(add_button2).click(function(e){ //on add input button click
	        e.preventDefault();
	        $(wrapper2).append(crazy_credits_html); //add input box
	        cc_c++;
	        update_crazy_credits_html();
	    });
	    $(wrapper2).on("click",".remove_field", function(e){ //user click on remove text
	        e.preventDefault(); $(this).parent('div').remove();
	        cc_c--;
	        update_crazy_credits_html();
	    })

	    //Goofs
	    var g_count = 0 ;
	    var wrapper3         = $(".input_fields_wrap-go"); //Fields wrapper
	    var add_button3      = $(".add_field_button-go"); //Add button ID
	    var goofs_html = '<div><br><label>Add Goofs : </label><textarea class="form-control" name="goofs[]"></textarea><input type="checkbox" name="goofs-chk-box['+g_count+']" value="true">Contain Spoiler<br><a href="#" class="remove_field">Remove</a></div>';
	    function update_goofs_html() {
	    	goofs_html = '<div><br><label>Add Goofs : </label><textarea class="form-control" name="goofs[]"></textarea><input type="checkbox" name="goofs-chk-box['+g_count+']" value="true">Contain Spoiler<br><a href="#" class="remove_field">Remove</a></div>';
	    }
	    $(add_button3).click(function(e){ //on add input button click
	        e.preventDefault();
	        $(wrapper3).append(goofs_html); //add input box
	        g_count++;
	        update_goofs_html();
	    });
	    $(wrapper3).on("click",".remove_field", function(e){ //user click on remove text
	        e.preventDefault(); $(this).parent('div').remove();
	        g_count--;
	        update_goofs_html();
	    })

	});
</script>

@stop