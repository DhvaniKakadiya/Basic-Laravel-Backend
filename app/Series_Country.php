<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Series_Country extends Model{
    protected $table = 'series_country';
    protected $fillable = ['series_id', 'country_id', 'created_at','updated_at'];
 	protected $guarded = ['id'];
}
