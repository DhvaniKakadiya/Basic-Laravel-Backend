<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Series_Productionco extends Model {
    protected $table = 'series_productionco';
 	protected $fillable = ['series_id','production_co', 'created_at', 'updated_at'];
 	protected $guarded = ['id'];
}
