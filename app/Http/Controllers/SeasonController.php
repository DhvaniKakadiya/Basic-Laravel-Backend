<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Session;
use App\Episode_Gallery;
use App\Episode_Awards;
use App\Episode_Review;
use App\Episode_Dialogues;
use App\Episode_Cast;
use App\Episode_Filmography;
use App\Work_Role;
use App\Episode_Soundtracks;
use App\Composer;
use App\Series;
use App\Season;
use App\Episode;
use App\Creator;
use App\Season_Creator;
use App\Series_Language;
use App\Series_To_Season_Mapping;
use App\Season_To_Episode_Mapping;
use Redirect;

class SeasonController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    
    public function index() {
        $season = Series_To_Season_Mapping::select("*")
            ->leftJoin('series','series_to_season_mapping.series_id','=','series.series_id')
			->leftJoin('season','series_to_season_mapping.season_id','=','season.season_id')
			->get();
        return view('portal.season.index')->with("season", $season);
    }

    public function create(){
        $series = Series::select("*")->orderBy('id','desc')->get();
        $creator = Creator::select("*")->orderBy('id','desc')->get();
        return view('portal.season.create')->with("series", $series);
    }

    public function store(Request $request){
        $series_to_season_mapping = new Series_To_Season_Mapping();
        $series_to_season_mapping->series_id =  $request->series_id;
        $series_to_season_mapping->save();  
        $id= $series_to_season_mapping->id;
        $s_id = "SE".$id;
        Series_To_Season_Mapping::where("id",$id)->update([
            "season_id" => $s_id,
        ]);
        $season = new Season;
        $season->season_id=$s_id;
        $season->season_number = $request->season_number;
        $season->published_date = $request->published_date;
		$season->runtime = $request->runtime;
        $season->save();
		
        
        Session::flash("success","Added");
        return redirect('/season'); 
    }
    
    public function edit($season_id){
        $series = Series::select("*")->orderBy('id','desc')->get();
        $season = Season::select("*")->where('season_id',$season_id)->get();
        $series_to_season_mapping = Series_To_Season_Mapping::select("*")->where('season_id',$season_id)->get(); 
        $series_id_ = Series_To_Season_Mapping::select("*")->leftJoin("season","season.season_id","=","series_to_season_mapping.season_id")->where('season.season_id',$season_id)->get();
        $current_series_id = $series_id_[0]['series_id'] ;
        return view('portal.season.edit')->with("season", $season)->with("series", $series)
            ->with("series_to_season_mapping",$series_to_season_mapping)->with("current_series_id",$current_series_id);
    }

    public function update($season_id, Request $request){


        Series_To_Season_Mapping::where("season_id",$season_id)->update([
            "series_id" => $request->series_id,
        ]);
        
        Season::where("season_id",$season_id)->update([
            "season_number" => $request->season_number,
            "published_date" => $request->published_date,
       	]);
        Session::flash("success","Edited");
        return redirect('/season');
    }

    public function delete($season_id){
        $season = new Season;
        $episode=Season_To_Episode_Mapping::where("season_id",$season_id)->get();
        foreach ($episode as $e){
            $er=Episode::select("poster_image_path","landscape_image_path","thumbnail_image_path")->where("episode_id",$e->episode_id)->get();
            foreach ($er as $ep){
                if(file_exists($ep->poster_image_path)){
                    Storage::delete($ep->poster_image_path);
                }
                if(file_exists($ep->landscape_image_path)){
                    Storage::delete($ep->landscape_image_path);
                }
                if(file_exists($ep->thumbnail_image_path)){
                    Storage::delete($ep->thumbnail_image_path);
                }        
            }
            $eg=Episode_Gallery::select("*")->where("episode_id",$e->episode_id)->get();
            foreach ($eg as $ep) {
                if(file_exists($ep->small_image_path)){
                    Storage::delete($ep->small_image_path);
                }
                if(file_exists($ep->large_image_path)){
                    Storage::delete($ep->large_image_path);
                }
            }
        }
        Series_To_Season_Mapping::where("season_id",$season_id)->delete();
        Session::flash("success","Deleted");
        return redirect('/season');
    }
}
