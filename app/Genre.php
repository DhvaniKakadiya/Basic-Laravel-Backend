<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model{
    protected $table = 'genre';
    protected $fillable = ['genre_prefix', 'genre_id', 'genre_name'];
 	protected $guarded = ['id'];
}
