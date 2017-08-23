<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Composer extends Model{
    protected $table = 'composer';
    protected $fillable = ['composerlist_id', 'person_id', 'created_at','updated_at'];
 	protected $guarded = ['id'];
}
