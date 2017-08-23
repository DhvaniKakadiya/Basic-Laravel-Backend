<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Travia extends Model
{
    protected $table = 'travia';
 	protected $fillable = ['series_id', 'travia_details','isspoiler'];
 	protected $guarded = ['id'];

 	public function episode()
 	{
 		return $this->belongsTo('App\Series','series_id','series_id');
 	}
 	 	//Logging 
   	protected static $logAttributes =  ['series_id', 'travia_details','isspoiler'];
   	protected static $logOnlyDirty = true;
   }
