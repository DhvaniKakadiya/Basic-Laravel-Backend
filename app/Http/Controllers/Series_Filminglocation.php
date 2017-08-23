<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Series_Filminglocation extends Model
{
    protected $table = 'series_Filminglocation';
 	protected $fillable = ['series_id','filminglocation_id','created_at','updated_at'];
 	protected $guarded = ['id'];
}
