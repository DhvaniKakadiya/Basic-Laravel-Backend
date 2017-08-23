<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Episode extends Model{
    protected $table = 'episode';
 	protected $fillable = ['episode_id','episode_name', 'episode_number', 'published_date', 'time_length', 'short_bio', 'storyline', 'poster_image_path','landscape_image_path', 'thumbnail_image_path' ,'created_at', 'updated_at'];
 	protected $guarded = ['id'];
}
