<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Series_Filminglocation extends Model {
	protected $table = 'series_filminglocation';
 	protected $fillable = ['series_id', 'city_id','country_id','created_at','updated_at'];
 	protected $guarded = ['id'];
}
