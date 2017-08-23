<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Series_Filmography extends Model {
  	protected $table = 'series_filmography';
 	protected $fillable = ['person_id', 'work_id','series_id','created_at','updated_at'];
}
