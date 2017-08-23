<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quotes extends Model
{
    protected $table = 'quotes';
 	protected $fillable = ['series_id', 'quotes_details','isspoiler'];
 	protected $guarded = ['id'];

 	public function episode()
 	{
 		return $this->belongsTo('App\Series','series_id','series_id');
 	}
 	//Logging 
   	protected static $logAttributes =  ['series_id', 'quotes_details','isspoiler'];
   	protected static $logOnlyDirty = true;
}
