<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Episode_Soundtracks extends Model{
    protected $table = 'episode_soundtracks';
    protected $fillable = ['soundtracks_id','episode_id', 'song_name', 'composerlist_id', 'created_at','updated_at'];
 	protected $guarded = ['id'];
}
