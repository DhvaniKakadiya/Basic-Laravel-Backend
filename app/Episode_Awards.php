<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Episode_Awards extends Model{
    protected $table = 'episode_awards';
 	protected $fillable = ['episode_id', 'award_name','created_at', 'updated_at'];
 	protected $guarded = ['id'];
}
