<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Episode_Filmography extends Model{
  	protected $table = 'episode_filmography';
 	protected $fillable = ['person_id', 'work_id','episode_id','created_at','updated_at'];
}
