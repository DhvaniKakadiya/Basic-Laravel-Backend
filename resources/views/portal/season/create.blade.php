@extends('layouts.master')
@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Season <a class="btn btn-primary" href="/season">Back</a></h1>
        </h1>
		<div class="row">
			<div class="col-lg-8">		
				<form action="./" method="POST">
					{{csrf_field()}}
					<div class="form-group">
						<label>Series Name : </label>
						<select class="form-control" name="series_id" required>
							<option>Select Series Name</option>
							@foreach ( $series as $s )
							<option name="{{$s->series_id}}" value="{{$s->series_id}}">{{$s->series_name}}</option>
							@endforeach
						</select>
					</div>

					<div class="form-group">
						<label>Season No. : </label>
						<input type="number" class="form-control" name="season_number">
					</div>




					<div class="form-group">
						<label>Season Year : </label>
						<input type="date" class="form-control" name="published_date">
					</div>
					<div class="form-group">
						<label>Run time: </label>
						<input type="number" class="form-control" name="runtime">
					</div>





					<button type="submit" value=" Submit "  class="btn btn-success" name="submit">Submit</button>
				</form>
			</div>
		</div>

</div>

@stop