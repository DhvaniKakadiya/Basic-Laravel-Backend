<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Series_Gallery extends Model {
  protected $table = 'series_gallery';
 	protected $fillable = ['series_id','small_image_path','large_image_path','created_at', 'updated_at'];
 	protected $guarded = ['id'];
}
