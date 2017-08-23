<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Series extends Model {
	protected $table = 'series';
 	protected $fillable = ['series_id', 'series_name', 'summary_text', 'storyline', 'published_date', 'trailer_link', 'series_fb', 'series_insta', 'series_twitter','creator_id', 'poster_path', 'thumbnail_path','created_at', 'updated_at'];
 	protected $guarded = ['id'];
}
