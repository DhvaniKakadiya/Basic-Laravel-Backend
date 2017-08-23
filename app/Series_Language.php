<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Series_Language extends Model {
   	protected $table = 'series_language';
 	protected $fillable = ['series_id', 'language_id', 'created_at', 'updated_at'];
 	protected $guarded = ['id'];
}
