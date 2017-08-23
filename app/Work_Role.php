<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Work_Role extends Model {
  protected $table = 'work_role';
 	protected $fillable = ['work_id', 'role'];
 	protected $guarded = ['id'];
}
