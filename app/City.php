<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class City extends Model{
    protected $table = 'city';
    protected $fillable = ['city_prefix', 'city_id', 'city_name', 'country_id','created_at','updated_at'];
 	protected $guarded = ['id'];
}
