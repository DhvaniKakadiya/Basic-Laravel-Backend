<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Person_Type extends Model {
    protected $table = 'person_type';
 	protected $fillable = ['person_type_prefix', 'person_type_id', 'person_type_name', 'created_at', 'updated_at'];
 	protected $guarded = ['id'];
}
