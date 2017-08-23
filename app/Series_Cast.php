<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Series_Cast extends Model {
    protected $table = 'series_cast';
 	protected $fillable = ['series_id','characte_id','person_id','created_at', 'updated_at'];
 	protected $guarded = ['id'];
}
