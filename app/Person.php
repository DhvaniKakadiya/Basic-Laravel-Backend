<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Person extends Model{
  protected $table = 'person';
 	protected $fillable = ['person_prefix','person_id','person_name','birth_date','birth_place','death_date','death_place','short_description','full_biography','square_image','poster_image','created_at','updated_at'];
 	protected $guarded = ['id'];
}
