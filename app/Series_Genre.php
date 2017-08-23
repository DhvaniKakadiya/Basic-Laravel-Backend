<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Series_Genre extends Model
{
    protected $table = 'series_genre';
 	protected $fillable = ['series_genre_id', 'series_id', 'genre_id', 'created_at', 'updated_at'];
 	protected $guarded = ['id'];
}
