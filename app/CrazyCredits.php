<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CrazyCredits extends Model
{
    protected $table = 'crazy_credits';
 	protected $fillable = ['series_id', 'crazy_credits_details', 'isspoiler'];
 	protected $guarded = ['id'];

 	public function episode()
 	{
 		return $this->belongsTo('App\Series','series_id','series_id');
 	}

 	 //Logging 
   	protected static $logAttributes = ['series_id', 'crazy_credits_details', 'isspoiler'];
   	protected static $logOnlyDirty = true;
}
