<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use App\Episode_Soundtracks;
use App\Episode;
use App\Composer;
use App\Person;
use App\Series;
use App\Season;
use App\Series_To_Season_Mapping;
use App\Season_To_Episode_Mapping;
use Redirect;

class SoundtracksController extends Controller{

    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $soundtracks=Episode_Soundtracks::select("*")->orderBy("soundtracks_id",'asc')->get();
        $composer=Composer::select("*")->orderBy("composerlist_id",'asc')->get();
        $episode=Episode::select("*")->groupBy("episode_id")->orderBy("episode_id",'asc')->get();
        $person = Person::select("*")->groupBy("person_id")->orderBy('id','asc')->get();
        $series = Series_To_Season_Mapping::select("*")->leftJoin("series","series_to_season_mapping.series_id","=","series.series_id")->get();
        $season = Season_To_Episode_Mapping::select("*")->leftJoin("season","season_to_episode_mapping.season_id","=","season.season_id")->get();
        return view('portal.soundtracks.index')->with("episode",$episode)->with("person",$person)->with("soundtracks",$soundtracks)
            ->with("composer",$composer)->with("season",$season)->with("series",$series);
    }

    public function create(){
        $series = Series::select("*")->orderBy('id','desc')->get();
        $episode=Episode::select("*")->groupBy("episode_id")->orderBy("episode_id",'asc')->get();
        $person = Person::select("*")->groupBy("person_id")->orderBy('id','asc')->get();
        return view('portal.soundtracks.create')->with("person",$person)->with("episode",$episode)->with("series",$series);
    }
    public function getSeasonList($series_id){
        $season = Season::select("season.season_number","season.season_id")
            ->leftJoin("series_to_season_mapping","series_to_season_mapping.season_id","=","season.season_id")
            ->where("series_id",$series_id)->get();
        return response()->json($season);
    }
    public function getEpisodeList($season_id){
        $episode = Episode::select("episode.episode_name","episode.episode_id")
            ->leftJoin("season_to_episode_mapping","season_to_episode_mapping.episode_id","=","episode.episode_id")
            ->where("season_id",$season_id)->get();
        return response()->json($episode);
    }
    
    public function store(Request $request){
        $soundtracks=new Episode_Soundtracks;
        $soundtracks->episode_id=$request->episode_id;
        $soundtracks->song_name=$request->song_name;
        $soundtracks->save();
        $id=$soundtracks->id;
        $s_id="ST".$id;
        $cl_id="CL".$id;
        Episode_Soundtracks::where("id",$id)->update([
            "soundtracks_id" => $s_id,
            "composerlist_id" => $cl_id,
        ]);
        $composer1 = $request->get('composerlist');
        if ($composer1){
            foreach($composer1 as $key => $value){
                $composer= new Composer;
                $composer->composerlist_id = $cl_id;
                $composer->person_id = $composer1[$key];
                $composer->save();
            }
        }
        
        Session::flash("success",'Added');
        return redirect('/soundtracks');
    }

    public function edit($soundtracks_id){
        $soundtracks=Episode_Soundtracks::select("*")->where("soundtracks_id",$soundtracks_id)->get();
        $episode=Episode::select("*")->groupBy("episode_id")->orderBy("episode_id",'asc')->get();
        $person = Person::select("*")->groupBy("person_id")->orderBy('id','asc')->get();
        $composer=Composer::select("*")->orderBy("composerlist_id",'asc')->get();
        $episode1=array_flatten(Episode_Soundtracks::select("episode_id")->where("soundtracks_id",$soundtracks_id)->get()->toArray());
        $episode_id=$episode1[0];
        //echo $episode_id;
        $series = Series_To_Season_Mapping::select("*")->leftJoin("series","series_to_season_mapping.series_id","=","series.series_id")
            ->groupBy("series.series_id")
            ->get();
        $season = Season_To_Episode_Mapping::select("*")->leftJoin("season","season_to_episode_mapping.season_id","=","season.season_id")
            ->where('episode_id',$episode_id)
            ->get();
        return view('portal.soundtracks.edit')->with("person",$person)->with("episode",$episode)->with("soundtracks",$soundtracks)
            ->with("composer",$composer)->with("season",$season)->with("series",$series);
    }

    public function update($soundtracks_id, Request $request){
        Episode_Soundtracks::where("soundtracks_id",$soundtracks_id)->update([
            "episode_id" => $request->episode_id,
            "song_name" => $request->song_name,
        ]);
        $composerlist=array_flatten(Episode_Soundtracks::select("composerlist_id")->where("soundtracks_id",$soundtracks_id)->get()->toArray());
        $composerlist=$composerlist[0];
        Composer::where("composerlist_id",$composerlist)->delete();
        $composer1 = $request->get('composerlist');
        if ($composer1){
            foreach($composer1 as $key => $value){
                $composer= new Composer;
                $composer->composerlist_id = $composerlist;
                $composer->person_id = $composer1[$key];
                $composer->save();
            }
        }
        Session::flash("success","Edited");
        return redirect('/soundtracks');
    
    }

    public function delete($soundtracks_id){
        Episode_Soundtracks::where("soundtracks_id",$soundtracks_id)->delete();
        Session::flash("success","Deleted");
        return redirect('/soundtracks');
    }
    
}
