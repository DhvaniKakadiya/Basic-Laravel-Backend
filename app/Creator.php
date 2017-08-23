<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Creator extends Model{
    protected $table = 'creator';
 	protected $fillable = ['creator_prefix', 'creator_id', 'creator_name', 'fb_link', 'insta_link', 'twitter_link', 'website_link', 'short_description', 'full_bio','established_date','poster_image_path','landscape_image_path','thumbnail_image_path', 'created_at', 'updated_at'];
 	protected $guarded = ['id'];
}
