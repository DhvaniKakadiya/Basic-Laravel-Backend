<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Technicalspecs extends Model {
    protected $table = 'technicalspecs';
    protected $fillable = ['series_id', 'sound_mix_type', 'color','aspect_ratio', 'created_at','updated_at'];
 	protected $guarded = ['id'];
}
