<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Series_To_Season_Mapping extends Model {
    protected $table = 'series_to_season_mapping';
 	protected $fillable = ['series_id', 'season_id','created_at','updated_at'];
 	protected $guarded = ['id'];
	
}