<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Series_To_Genre_Mapping extends Model {
    protected $table = 'series_to_genre_mapping';
 	protected $fillable = ['series_id', 'genre_id', 'created_at', 'updated_at'];
 	protected $guarded = ['id'];
}
