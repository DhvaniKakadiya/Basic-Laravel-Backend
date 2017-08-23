<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Series_Distributors extends Model {
    protected $table = 'series_distributors';
 	protected $fillable = ['series_id','distributors', 'created_at', 'updated_at'];
 	protected $guarded = ['id'];
}
