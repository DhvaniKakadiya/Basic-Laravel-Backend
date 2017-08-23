<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Series_Awards extends Model {
    protected $table = 'series_awards';
 	protected $fillable = ['series_id', 'award_name','created_at', 'updated_at'];
 	protected $guarded = ['id'];
}
