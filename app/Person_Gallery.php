<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Person_Gallery extends Model {
  protected $table = 'person_gallery';
 	protected $fillable = ['person_id','small_image_path','large_image_path','created_at', 'updated_at'];
 	protected $guarded = ['id'];
}
