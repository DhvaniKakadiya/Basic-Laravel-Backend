<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Season_Creator extends Model {
    protected $table = 'season_creator';
 	protected $fillable = ['season_creator_id', 'season_id', 'creator_id', 'created_at', 'updated_at'];
 	protected $guarded = ['id'];
}
