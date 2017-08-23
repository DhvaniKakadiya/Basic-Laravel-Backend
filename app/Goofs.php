<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Goofs extends Model
{
    protected $table = 'goofs';
 	protected $fillable = ['series_id', 'goofs_details','isspoiler'];
 	protected $guarded = ['id'];

 	public function episode()
 	{
 		return $this->belongsTo('App\Series','series_id','series_id');
 	}
 	 	 	 //Logging 
   	protected static $logAttributes = ['series_id', 'goofs_details','isspoiler'];
   	protected static $logOnlyDirty = true;
}
