<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Episode_Details extends Model
{
    protected $table = 'episode_details';
 	protected $fillable = ['episode_details_id','series_id', 'season_id', 'episode_id', 'person_id', 'person_type_id', 'character_name', 'character_role', 'created_at', 'updated_at'];
 	protected $guarded = ['id'];
}
