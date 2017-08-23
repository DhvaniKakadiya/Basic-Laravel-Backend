<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Characte extends Model
{
  protected $table = 'characte';
 	protected $fillable = ['characte_prefix', 'characte_id', 'characte_name', 'biography','poster_path','created_at','updated_at']
}
