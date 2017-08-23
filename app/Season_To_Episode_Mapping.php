<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Season_To_Episode_Mapping extends Model {
    protected $table = 'season_to_episode_mapping';
 	protected $fillable = ['season_id','episode_id','created_at','updated_at'];
 	protected $guarded = ['id'];
	
}