<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Episode_Cast extends Model{
    protected $table = 'episode_cast';
 	protected $fillable = ['episode_id','character_id','person_id','created_at', 'updated_at'];
 	protected $guarded = ['id'];
}
