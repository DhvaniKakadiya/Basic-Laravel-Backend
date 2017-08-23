<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Character_Gallery extends Model{
  	protected $table = 'character_gallery';
 	protected $fillable = ['character_gallery_id','characte_id','small_image_path','large_image_path','created_at', 'updated_at'];
 	protected $guarded = ['id'];
}
