<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Episode_Dialogues extends Model{
    protected $table = 'episode_dialogues';
 	protected $fillable = ['episode_id', 'dialogues','character_id','created_at', 'updated_at'];
 	protected $guarded = ['id'];
}
