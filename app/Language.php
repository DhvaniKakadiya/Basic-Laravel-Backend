<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Language extends Model{
    protected $table = 'language';
    protected $fillable = ['language_prefix', 'language_id', 'language_name'];
 	protected $guarded = ['id'];
}
