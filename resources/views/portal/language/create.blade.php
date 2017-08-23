@extends('layouts.master')
@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Language <a class="btn btn-primary" href="/language">Back</a>
        </h1>
		<div class="row">
			<div class="col-lg-8">		
				<form action="./" method="POST">
					{{csrf_field()}}
					<div class="form-group">
						<label>Language Name : </label>
						<input type="text" class="form-control" name="language_name" required>
					</div>
					<button type="submit" value=" Submit "  class="btn btn-success" name="submit">Submit</button>
				</form>
			</div>
		</div>

</div>

@stop