<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Episode_Review extends Model{
    protected $table = 'episode_review';
 	protected $fillable = ['episode_id', 'author_name','review_title','review_text','created_at', 'updated_at'];
 	protected $guarded = ['id'];
}
