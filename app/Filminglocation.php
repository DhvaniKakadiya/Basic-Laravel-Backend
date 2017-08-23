<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Filminglocation extends Model
{
	protected $table = 'filminglocation';
 	protected $fillable = ['filminglocation_prefix', 'filminglocation_id', 'filminglocation_name'];
 	protected $guarded = ['id'];
}
