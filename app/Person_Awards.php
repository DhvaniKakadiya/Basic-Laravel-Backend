<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Person_Awards extends Model{
    protected $table = 'person_awards';
 	protected $fillable = ['person_id', 'award_name','created_at', 'updated_at'];
 	protected $guarded = ['id'];
}
