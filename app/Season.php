<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Season extends Model {
    protected $table = 'season';
 	protected $fillable = ['season_id', 'published_date', 'season_number', 'runtime','created_at','updated_at'];
 	protected $guarded = ['id'];
}
