@extends('layouts.master')
@section('content')

<div class="row">
    <div class="col-lg-12">
    	@foreach ( $season as $sn )
        
		<div class="row">
			<div class="col-lg-8">		
				<form action="./{{$sn->season_id}}" method="POST">
					{{csrf_field()}}
					<div class="form-group">
						<label>Series Name : </label>
						<select class="form-control" id="series" name="series_id" required>
								@foreach ( $series as $s )
									@if($s->series_id == $current_series_id )
										<option name="{{$s->series_id}}" selected value="{{$s->series_id}}">{{$s->series_name}} </option>
									@else
										<option name="{{$s->series_id}}" value="{{$s->series_id}}">{{$s->series_name}} </option>
									@endif
								@endforeach
						</select>
					</div>

					<div class="form-group">
						<label>Season No. : </label>
						<input type="number" class="form-control" name="season_number" value="{{$sn->season_number}}">
					</div>

					<div class="form-group">
						<label>Season Date : </label>
						<input type="date" class="form-control" name="published_date" value="{{$sn->published_date}}">
					</div>
					@endforeach
					<button type="submit" value="Submit"  class="btn btn-success" name="submit">Submit</button>
				</form>
			</div>
		</div>
	</div>
</div>

@stop