<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Episode_Gallery extends Model{
  	protected $table = 'episode_gallery';
 	protected $fillable = ['episode_gallery_id','episode_id','small_image_path','large_image_path','created_at', 'updated_at'];
 	protected $guarded = ['id'];
}
