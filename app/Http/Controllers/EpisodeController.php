<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Session;
use App\Series;
use App\Season;
use App\Episode;
use App\Person;
use App\Characte;
use App\Episode_Gallery;
use App\Episode_Awards;
use App\Episode_Review;
use App\Episode_Dialogues;
use App\Episode_Cast;
use App\Series_Cast;
use App\Episode_Filmography;
use App\Series_Filmography;
use App\Work_Role;
use App\Episode_Soundtracks;
use App\Composer;
use App\Season_To_Episode_Mapping;
use App\Series_To_Season_Mapping;
use Redirect;

class EpisodeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        $episode = Episode::get();
        $episode_awards = Episode_Awards::orderBy('episode.episode_id','desc')
            ->leftJoin('episode','episode_awards.episode_id','=','episode.episode_id')
            ->get();
        $episode_gallery = Episode_Gallery::orderBy('episode.episode_id','desc')
            ->leftJoin('episode','episode_gallery.episode_id','=','episode.episode_id')
            ->get(); 
        $episode_review = Episode_Review::orderBy('episode.episode_id','desc')
            ->leftJoin('episode','episode_review.episode_id','=','episode.episode_id')
            ->get();
        $episode_dialogues=Episode_Dialogues::select("*")->get();
        $series = Series_To_Season_Mapping::select("*")->leftJoin("series","series_to_season_mapping.series_id","=","series.series_id")->get();
        $season = Season_To_Episode_Mapping::select("*")->leftJoin("season","season_to_episode_mapping.season_id","=","season.season_id")->get();
        return view('portal.episode.index')->with("episode",$episode)->with("episode_gallery",$episode_gallery)
            ->with("episode_awards",$episode_awards)->with("episode_review",$episode_review)
            ->with("episode_dialogues",$episode_dialogues)->with("season",$season)->with("series",$series);
    }

    public function create(){
        $series = Series::select("*")->get();
        $series = $series->sortBy("series_name");
        $person = Person::select("*")->get();
        $person = $person->sortBy("person_name");
        $character = Characte::select("*")->get();
        $character = $character->sortBy("characte_name");
        $episode_awards = Episode_Awards::select("*")->orderBy('episode_id','asc')->get();
        $episode_review = Episode_Review::select("*")->orderBy('episode_id','asc')->get();
        $work=Work_Role::select("*")->get();
        return view('portal.episode.create')->with("series",$series)->with("episode_awards",$episode_awards)
            ->with("episode_review",$episode_review)->with("person",$person)->with("character",$character)->with("work",$work);
    }

    public function getSeasonList($series_id){
        $season = Season::select("season.season_number","season.season_id")
            ->leftJoin("series_to_season_mapping","series_to_season_mapping.season_id","=","season.season_id")
            ->where("series_id",$series_id)->get();
        return response()->json($season);
    }

    public function store(Request $request){


        $season_to_episode_mapping = new Season_To_Episode_Mapping();
        $season_to_episode_mapping->season_id = $request->season_id; 
        $season_to_episode_mapping->save(); 
        $id= $season_to_episode_mapping->id;
        $p_id = "EE".$season_to_episode_mapping->id;
        Season_To_Episode_Mapping::where("id",$id)->update([
            "episode_id" => $p_id,
        ]); 
        $episode_name=$request->episode_name;
        $episode_name=explode(" ",$episode_name);
        $episode_name=implode("-",$episode_name);
        $episode_name=explode("'",$episode_name);
        $episode_name=implode("-",$episode_name);
        $episode = new Episode;
        $episode->episode_id=$p_id;
        $episode->episode_name = $request->episode_name;
        $episode->episode_number = $request->episode_number;
        $episode->published_date = $request->published_date;
        $episode->time_length = $request->time_length;
        $episode->short_bio = $request->short_bio;
        $episode->storyline = $request->storyline;
        $episode->poster_image_path='POSTER_'.$episode_name.'_'.$p_id.'.jpg';
        $episode->landscape_image_path='LANDSCAPE_'.$episode_name.'_'.$p_id.'.jpg';
        $episode->thumbnail_image_path='THUMBNAIL_'.$episode_name.'_'.$p_id.'.jpg';
        $episode->save();        
        $character = $request->get('characterd');
        $dialogues = $request->get('dialogues');
        for($i=0;$i<count($character);$i++){
            if ($character){
                $episode_dialogues= new Episode_Dialogues;
                $episode_dialogues->episode_id = $p_id;
                $episode_dialogues->dialogues=$dialogues[$i];
                $episode_dialogues->characte_id = $character[$i];
                $episode_dialogues->save();
            }
        }
        $award_name = $request->get('award_name');
        if ($award_name){
            foreach($award_name as $key => $value){
                $episode_awards= new Episode_Awards;
                $episode_awards->episode_id = $p_id;
                $episode_awards->award_name = $award_name[$key];
                $episode_awards->save();
            }
        }
        $review_text = $request->get('review_text');
        $author_name = $request->get('author_name');
        $review_title = $request->get('review_title');
        $i=0;
        if ($review_text){
            foreach($review_text as $key => $value){
                $episode_review= new Episode_Review;
                $episode_review->episode_id = $p_id;
                $episode_review->author_name = $author_name[$i];
                $episode_review->review_title =$review_title[$i];
                $episode_review->review_text = $review_text[$key];
                $episode_review->save();
                $i++;
            }
        }
        $file=$request->file('poster_image_path');
        $filename='POSTER_'.$episode_name.'_'.$p_id.'.jpg';
        if($file){
            Storage::disk('local')->put($filename,File::get($file));
        }
        $file=$request->file('landscape_image_path');
        $filename='LANDSCAPE_'.$episode_name.'_'.$p_id.'.jpg';
        if($file){
            Storage::disk('local')->put($filename,File::get($file));
        }
        $file=$request->file('thumbnail_image_path');
        $filename='THUMBNAIL_'.$episode_name.'_'.$p_id.'.jpg';
        if($file){
            Storage::disk('local')->put($filename,File::get($file));
        }
        $files=$request->file('small_image_path');
        $i=0;
 if(count($files)!=0){
        foreach ($files as $file){
            $i++;
            $filename=$episode_name.'_'.$p_id.'_SMALL_'.$i.'.jpg';
            if($file){
                Storage::disk('local')->put($filename,File::get($file));
            }
        }
        $files=$request->file('large_image_path');
       
            $j=0;
            foreach ($files as $file){
                $j++;
                $filename=$episode_name.'_'.$p_id.'_LARGE_'.$j.'.jpg';
                if($file){
                    Storage::disk('local')->put($filename,File::get($file));
                }
            }
            for($i=1;$i<=$j;$i++){
                $episode_gallery=new Episode_Gallery;
                $episode_gallery->episode_id=$p_id;
                $episode_gallery->small_image_path=$episode_name.'_'.$p_id.'_SMALL_'.$i.'.jpg';
                $episode_gallery->large_image_path=$episode_name.'_'.$p_id.'_LARGE_'.$i.'.jpg';
                $episode_gallery->save();
                $id= $episode_gallery->id;
                $eg_id = "EG".$episode_gallery->id;
                Episode_Gallery::where("id",$id)->update([
                        "episode_gallery_id" => $eg_id,
                ]);
            }  
        }
        $work = $request->get('work');
        $person = $request->get('personf');
        for($i=0;$i<count($person);$i++){
            if ($person){
                $episode_filmography= new Episode_Filmography;
                $episode_filmography->person_id = $person[$i];
                $episode_filmography->work_id = $work[$i];
                $episode_filmography->episode_id = $p_id;
                $episode_filmography->save();
            }
        }
        for($i=0;$i<count($person);$i++){
            if ($person){
                $series_filmography= new Series_Filmography;
                $series_filmography->person_id = $person[$i];
                $series_filmography->work_id = $work[$i];
                $series_filmography->series_id = $request->series_id;
                $series_filmography->save();
            }
        }
        $all_series_filmography=Series_Filmography::groupBy('person_id','work_id')->get();
        Series_Filmography::select("*")->delete();
        
        foreach ($all_series_filmography as $s) {
                $series_filmography= new Series_Filmography;
                $series_filmography->person_id = $s->person_id;
                $series_filmography->work_id = $s->work_id;
                $series_filmography->series_id = $s->series_id;
                $series_filmography->save();
        }
                
            
        $character = $request->get('character');
        $person = $request->get('person');
        for($i=0;$i<count($character);$i++){
            if ($character){
                $episode_cast= new Episode_Cast;
                $episode_cast->episode_id = $p_id;
                $episode_cast->characte_id = $character[$i];
                $episode_cast->person_id = $person[$i];
                $episode_cast->save();
            }
        }
        for($i=0;$i<count($character);$i++){
            if ($character){
                $series_cast= new Series_Cast;
                $series_cast->series_id = $request->series_id;
                $series_cast->characte_id = $character[$i];
                $series_cast->person_id = $person[$i];
                $series_cast->save();
            }
        }

        $all_series_cast=Series_Cast::groupBy('characte_id','person_id')->get();
        Series_Filmography::select("*")->delete();
        
        foreach ($all_series_cast as $s) {
                $series_cast= new Series_Cast;
                $series_cast->series_id = $s->series_id;
                $series_cast->characte_id = $s->characte_id;
                $series_cast->person_id = $s->person_id;
                $series_cast->save();
        }
 
        Session::flash("success"," $episode_name Added");
        return redirect('/episode'); 
    }
    
    public function edit($episode_id){
        $episode = Episode::select("*")->where('episode_id',$episode_id)->get();
        $episode_gallery =Episode_Gallery::select("*")->orderBy('episode_gallery.id','asc')
            ->where('episode_gallery.episode_id',$episode_id)
            ->get();
        $person = Person::select("*")->orderBy('id','desc')->get();
        $character = Characte::select("*")->orderBy('id','desc')->get();
        $episode_awards = array_flatten(Episode_Awards::select("award_name")->where('episode_awards.episode_id',$episode_id)
            ->get()->toArray());
        $episode_review = Episode_Review::select("*")->where('episode_review.episode_id',$episode_id)
            ->get();
        $episode_cast=Episode_Cast::select("episode_cast.characte_id","characte.characte_name","episode_cast.person_id","episode_cast.episode_id","person.person_name")
            ->leftJoin("characte","characte.characte_id","=","episode_cast.characte_id")
            ->leftJoin("person","person.person_id","=","episode_cast.person_id")
            ->get();
        $episode_dialogues=Episode_Dialogues::select("characte.characte_name","episode_dialogues.characte_id","episode_dialogues.episode_id","episode_dialogues.dialogues")
            ->leftJoin("characte","characte.characte_id","=","episode_dialogues.characte_id")
            ->get();
        $episode_filmography=Episode_Filmography::select("work_role.role","episode_filmography.person_id","episode_filmography.episode_id","episode_filmography.work_id","person.person_name")
            ->leftJoin("person","person.person_id","=","episode_filmography.person_id")
            ->leftJoin("work_role","work_role.work_id","=","episode_filmography.work_id")
            ->get();
        $work=Work_Role::select("*")->get();
        $series = Series::select("series_id","series_name")->get();
        $series = $series->sortBy("series_name");
        
        $series_id_ = Season_To_Episode_Mapping::select("*")->leftJoin("series_to_season_mapping","season_to_episode_mapping.season_id","=","series_to_season_mapping.season_id")->where('episode_id',$episode_id)->get(); 
        $current_series_id = $series_id_[0]['series_id'] ;

        $current_season_id = Season_To_Episode_Mapping::select("*")->leftJoin("season","season_to_episode_mapping.season_id","=","season.season_id")->where('episode_id',$episode_id)->get();
        $current_season_id = $current_season_id[0]['season_id']; 
        
        $season = Series_To_Season_Mapping::select("series_to_season_mapping.season_id","season.season_number")->leftJoin("season","series_to_season_mapping.season_id","=","season.season_id")->where('series_id',$current_series_id)->get();

        return view('portal.episode.edit')->with("episode",$episode)->with('episode_awards',$episode_awards)
            ->with('episode_review',$episode_review)->with('episode_gallery',$episode_gallery)->with('episode_cast',$episode_cast)
            ->with("person",$person)->with("character",$character)->with("episode_dialogues",$episode_dialogues)
            ->with("work",$work)->with("episode_filmography",$episode_filmography)->with("season",$season)->with("series",$series)
            ->with("current_season_id",$current_season_id)
            ->with("current_series_id",$current_series_id);
            
    }

    public function update($episode_id, Request $request){

        Season_To_Episode_Mapping::where("episode_id",$episode_id)->update([
            "season_id" => $request->season_id,
            "episode_id" => $episode_id,
        ]); 
        episode::where("episode_id",$episode_id)->update([
            "episode_name" => $request->episode_name,
            "episode_number" => $request->episode_number,
            "published_date" =>$request->published_date,
            "time_length" =>$request->time_length,
            "short_bio"=> $request->short_bio,
            "storyline"=> $request->storyline,
        ]);
        Episode_Dialogues::where("episode_id",$episode_id)->delete();
        $character = $request->get('characterd');
        $dialogues = $request->get('dialogues');
        for($i=0;$i<count($character);$i++){
            if ($character){
                $episode_dialogues= new Episode_Dialogues;
                $episode_dialogues->episode_id = $episode_id;
                $episode_dialogues->dialogues = $dialogues[$i];
                $episode_dialogues->characte_id = $character[$i];
                $episode_dialogues->save();
            }
        }
        Episode_Cast::where("episode_id",$episode_id)->delete();
        $character = $request->get('character');
        $person = $request->get('person');
        for($i=0;$i<count($character);$i++){
            if ($character) {
                $episode_cast= new Episode_Cast;
                $episode_cast->episode_id = $episode_id;
                $episode_cast->characte_id = $character[$i];
                $episode_cast->person_id = $person[$i];
                $episode_cast->save();
                        
            }
        }
        Series_Cast::where("series_id",$request->series_id)->delete();
        for($i=0;$i<count($character);$i++){
            if ($character) {
                $series_cast= new Series_Cast;
                $series_cast->series_id = $request->series_id;
                $series_cast->characte_id = $character[$i];
                $series_cast->person_id = $person[$i];
                $series_cast->save();
                    
            }
        }
        $all_series_cast=Series_Cast::groupBy('characte_id','person_id')->get();
        Series_Filmography::select("*")->delete();
        
        foreach ($all_series_cast as $s) {
                $series_cast= new Series_Cast;
                $series_cast->series_id = $s->series_id;
                $series_cast->characte_id = $s->characte_id;
                $series_cast->person_id = $s->person_id;
                $series_cast->save();
        }

        Episode_Filmography::where("episode_id",$episode_id)->delete();
        $work = $request->get('work');
        $person = $request->get('personf');
        for($i=0;$i<count($person);$i++){
            if ($person) {
                $episode_filmography= new Episode_Filmography;
                $episode_filmography->person_id = $person[$i];
                $episode_filmography->work_id = $work[$i];
                $episode_filmography->episode_id = $episode_id;
                $episode_filmography->save();
            }
        }
        Series_Filmography::where("series_id",$request->series_id)->delete();
        for($i=0;$i<count($person);$i++){
            if ($person) {
                $series_filmography= new Series_Filmography;
                $series_filmography->person_id = $person[$i];
                $series_filmography->work_id = $work[$i];
                $series_filmography->series_id = $request->series_id;
                $series_filmography->save();
            }
        }
        $all_series_filmography=Series_Filmography::groupBy('person_id','work_id')->get();
        Series_Filmography::select("*")->delete();
        
        foreach ($all_series_filmography as $s) {
                $series_filmography= new Series_Filmography;
                $series_filmography->person_id = $s->person_id;
                $series_filmography->work_id = $s->work_id;
                $series_filmography->series_id = $s->series_id;
                $series_filmography->save();
        }
        Episode_Awards::where("episode_id",$episode_id)->delete();
        $award_name = $request->get('award_name');
        if ($award_name){
            foreach($award_name as $key => $value){
                $episode_award = new Episode_Awards();
                $episode_award->episode_id = $episode_id;
                $episode_award->award_name = $value;
                $episode_award->save();
            }
        }
        Episode_Review::where("episode_id",$episode_id)->delete();
        $review_text = $request->get('review_text');
        if ($review_text){
            foreach($review_text as $key => $value){
                $episode_review= new Episode_Review();
                $episode_review->episode_id = $episode_id;
                $episode_review->author_name = $request->author_name;
                $episode_review->review_title = $request->review_title;
                $episode_review->review_text = $value;
                $episode_review->save();
            }
        }
        $en=array_flatten(Episode::select("episode_name")->where("episode_id",$episode_id)->get()->toArray());
        $episode_name=$en[0];
        $episode_name=explode(" ",$episode_name);
        $episode_name=implode("-",$episode_name);
        $episode_name=explode("'",$episode_name);
        $episode_name=implode("-",$episode_name);
        $file=$request->file('poster_image_path');
        $filename='POSTER_'.$episode_name.'_'.$episode_id.'.jpg';
        if(!empty($file)){
            if(file_exists($filename)){
                Storage::delete($filename);
            }          
            Storage::disk('local')->put($filename,File::get($file));
         }
        $file=$request->file('landscape_image_path');
        $filename='LANDSCAPE_'.$episode_name.'_'.$episode_id.'.jpg';
        if(!empty($file)){
            if(file_exists($filename)){
                Storage::delete($filename);
            }              
            Storage::disk('local')->put($filename,File::get($file));
         }
        $file=$request->file('thumbnail_image_path');
        $filename='THUMBNAIL_'.$episode_name.'_'.$episode_id.'.jpg';
        if(!empty($file)){
            if(file_exists($filename)){
                Storage::delete($filename);
            }         
            Storage::disk('local')->put($filename,File::get($file));
         }


        $count=Episode_Gallery::select("*")->where("episode_id",$episode_id)->get()->count();
        $files=$request->file('small_image_path');
        $c=count($files);
        if($c!=0){
            if($c>$count){
                $files=$request->file('small_image_path');
                $i=0;
                foreach ($files as $file) {
                    $i++;
                    $filename=$episode_name.'_'.$episode_id.'_SMALL_'.$i.'.jpg';
                    if(!empty($file)){
                        Storage::disk('local')->put($filename,File::get($file));
                    }              
                }
                $files=$request->file('large_image_path');
                $i=0;
                foreach ($files as $file) {
                    $i++;
                    $filename=$episode_name.'_'.$episode_id.'_LARGE_'.$i.'.jpg';
                    if(!empty($file)){
                        Storage::disk('local')->put($filename,File::get($file));
                    }        
                }
                for($j=1;$j<=$i;$j++){
                    if($j>$count){
                        $episode_gallery=new Episode_Gallery;
                        $episode_gallery->episode_id=$episode_id;
                        $episode_gallery->small_image_path=$episode_name.'_'.$episode_id.'_SMALL_'.$j.'.jpg';
                        $episode_gallery->large_image_path=$episode_name.'_'.$episode_id.'_LARGE_'.$j.'.jpg';
                        $episode_gallery->save();
                    }
                }   
            }
            else{           
                for($j=1;$j<=$count;$j++){
                    if($j>$c){
                        $filename=$episode_name.'_'.$episode_id.'_SMALL_'.$j.'.jpg';
                        $filelarge=$episode_name.'_'.$episode_id.'_LARGE_'.$j.'.jpg';
                        Episode_Gallery::where("small_image_path",$filename)->delete();
                    }
                }
                $files=$request->file('small_image_path');
                $c=count($files);
                $i=1;
                for($j=1;$j<=$count;$j++){
                    $n='small'.$j;
                    $f=$request->$n;        
                    if(!empty($f)){
                        $filename=$episode_name.'_'.$episode_id.'_SMALL_'.$j.'.jpg';
                        $name=$episode_name.'_'.$episode_id.'_SMALL_'.$i.'.jpg';
                        if(strcmp($name,$filename)!=0){
                            Storage::move($filename,$name);
                        }
                        $i++;
                    }
                    else{
                        $filename=$episode_name.'_'.$episode_id.'_SMALL_'.$j.'.jpg';
                        Storage::delete($filename);
                    }
                }  
                $i=0;
                foreach ($files as $file) {
                    $i++;
                    $filename=$episode_name.'_'.$episode_id.'_SMALL_'.$i.'.jpg';
                    if(!empty($file)){
                        Storage::delete($filename);
                        Storage::disk('local')->put($filename,File::get($file));
                    }
                }
                $files=$request->file('large_image_path');
                $c=count($files);
                $i=1;
                for($j=1;$j<=$count;$j++){
                    $n='large'.$j;
                    $f=$request->$n;              
                    if(!empty($f)){
                        $filename=$episode_name.'_'.$episode_id.'_LARGE_'.$j.'.jpg';
                        $name=$episode_name.'_'.$episode_id.'_LARGE_'.$i.'.jpg';
                        if(strcmp($name,$filename)!=0){
                            Storage::move($filename,$name);
                        }
                        $i++;
                    }
                    else{
                        $filename=$episode_name.'_'.$episode_id.'_LARGE_'.$j.'.jpg';
                        Storage::delete($filename);
                    }
                }  
                $i=0;
                foreach ($files as $file) {
                    $i++;
                    $filename=$episode_name.'_'.$episode_id.'_LARGE_'.$i.'.jpg';
                    if(!empty($file)){
                        Storage::delete($filename);
                        Storage::disk('local')->put($filename,File::get($file));
                    }
                }         
            }
        }
        else if($count!=0){
            for($j=1;$j<=$count;$j++){
                    
                        $filename=$episode_name.'_'.$episode_id.'_SMALL_'.$j.'.jpg';
                        $filelarge=$episode_name.'_'.$episode_id.'_LARGE_'.$j.'.jpg';
                        Episode_Gallery::where("small_image_path",$filename)->delete();
                        if(file_exists($filename)){
                            Storage::delete($filename);
                        }
                    
                }

        }


         
        $episode = new Episode;
        $episode_name = $episode->episode_name;
        Session::flash("success","$episode_name Edited");
        return redirect('/episode');
    }

    public function delete($episode_id){
        $episode = new Episode;
        $er=Episode::select("poster_image_path","landscape_image_path","thumbnail_image_path")->where("episode_id",$episode_id)->get();
        $episode_name= $episode->episode_name;
        foreach ($er as $e){
            if(file_exists($e->poster_image_path)){
                Storage::delete($ep->poster_image_path);
            }
            if(file_exists($e->landscape_image_path)){
                Storage::delete($ep->landscape_image_path);
            }
            if(file_exists($e->thumbnail_image_path)){
                Storage::delete($ep->thumbnail_image_path);
            }   
        }
        $eg=Episode_Gallery::select("*")->where("episode_id",$episode_id)->get();
        foreach ($eg as $e){
            if(file_exists($e->small_image_path)){
                        Storage::delete($ep->small_image_path);
                    }
                    if(file_exists($e->large_image_path)){
                        Storage::delete($ep->large_image_path);
                    }   
        }
        Season_To_Episode_Mapping::where("episode_id",$episode_id)->delete();
        Session::flash("success","$episode_name Deleted");
        return redirect('/episode');
    }
}
