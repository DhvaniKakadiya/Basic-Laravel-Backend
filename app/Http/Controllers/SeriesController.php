<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Session;
use App\City;
use App\Series_Country;
use App\Country;
use App\Creator;
use App\Series;
use App\Episode;
use App\Season;
use App\Genre;
use App\Language;
use App\Series_To_Genre_Mapping;
use App\Series_Language;
use App\Series_Gallery;
use App\Series_Awards;
use App\Technicalspecs;
use App\Series_Filminglocation;
use App\Series_Distributors;
use App\Series_Productionco;
use App\Series_To_Season_Mapping;
use App\Season_To_Episode_Mapping;
use App\Episode_Gallery;
use App\Episode_Awards;
use App\Episode_Review;
use App\Episode_Dialogues;
use App\Episode_Cast;
use App\Episode_Filmography;
use App\Work_Role;
use App\Episode_Soundtracks;
use App\Composer;
use Redirect;

class SeriesController extends Controller{

    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $series = Series::select("*")->orderBy('id','desc')->get();
        $series_genre = Series_To_Genre_Mapping::orderBy('series_to_genre_mapping.genre_id','desc')
            ->leftJoin('genre','series_to_genre_mapping.genre_id','=','genre.genre_id')
            ->get();
        $creator=Creator::select("*")->orderBy('id','desc')->get();
        $series_language = Series_Language::orderBy('series_language.language_id','desc')
            ->leftJoin('language','series_language.language_id','=','language.language_id')
            ->get();
        $series_gallery = Series_Gallery::orderBy('series.series_id','desc')
            ->leftJoin('series','series_gallery.series_id','=','series.series_id')
            ->get();
        $series_awards = Series_Awards::orderBy('series.series_id','desc')
            ->leftJoin('series','series_awards.series_id','=','series.series_id')
            ->get();
        $series_country = Series_Country::select("*")->leftJoin('country','series_country.country_id','=','country.country_id')->get();
        $technicalspecs=Technicalspecs::select("*")->get();
        $productionco=Series_Productionco::select("*")->get();
        $distributors=Series_Distributors::select("*")->get();
        $country=Country::select("*")->get();
        $filminglocation=Series_Filminglocation::select("*")->rightJoin("city","city.city_id","=","series_filminglocation.city_id")->get();
        return view('portal.series.index')->with("series", $series)->with("series_to_genre_mapping", $series_genre)
            ->with("series_language", $series_language)->with("series_gallery",$series_gallery)->with("creator",$creator)
            ->with("series_awards",$series_awards)->with("technicalspecs",$technicalspecs)->with("filminglocation",$filminglocation)
            ->with("country",$country)->with("productionco",$productionco)->with("distributors",$distributors)->with("series_country",$series_country);
    }

    public function create(){
	    $genre = Genre::select("*")->orderBy('id','asc')->get();
        $creator = Creator::select("*")->orderBy('id','desc')->get();
		$language = Language::select("*")->orderBy('id','desc')->get();
        $series_awards = Series_Awards::select("*")->orderBy('series_id','asc')->get();
        $city=City::select("*")->get();
        $country=Country::select("country_id","country_name")->orderBy('id','desc')->get();
        //print_r($country);
        return view('portal.series.create')->with("creator",$creator)->with("genre",$genre)->with("language",$language)->with("country",$country)
            ->with("series_awards",$series_awards)->with("city",$city);
    }

    public function store(Request $request){
    	$series = new Series();
    	$series->series_name = $request->series_name;
    	$series->summary_text = $request->summary_text;
        $series->storyline = $request->storyline;
        $series->published_date = $request->published_date;
        $series->trailer_link = $request->trailer_link;
        $series->series_fb= $request->series_fb;
        $series->series_insta = $request->series_insta;
        $series->series_twitter = $request->series_twitter;
		$series->creator_id = $request->creator_id;
    	$series->save();
        $series_name= $series->series_name;
        $series_name=explode(" ",$series_name);
        $series_name=implode("-",$series_name);
        $series_name=explode("'",$series_name);
        $series_name=implode("-",$series_name);        
        $id= $series->id;
        $s_id = "SR".$series->id;
        Series::where("id",$id)->update([
            "series_id" => $s_id,
            "poster_path"=>'POSTER_'.$series_name.'_'.$s_id.'.jpg',
            "thumbnail_path"=>'THUMBNAIL_'.$series_name.'_'.$s_id.'.jpg',
        ]);
        $file=$request->file('poster_path');
        $filename='POSTER_'.$series_name.'_'.$s_id.'.jpg';
        if($file){
            Storage::disk('local')->put($filename,File::get($file));
        }
        $file=$request->file('thumbnail_path');
        $filename='THUMBNAIL_'.$series_name.'_'.$s_id.'.jpg';
        if($file){
            Storage::disk('local')->put($filename,File::get($file));
        }
        $genre_id = $request->get('genre_id');
        if ($genre_id){
            foreach($genre_id as $key => $value) {
                $series_genre = new Series_To_Genre_Mapping();
                $series_genre->series_id = $s_id;
                $series_genre->genre_id = $value;
                $series_genre->save();
            }
        }
        $language_id = $request->get('language_id');
        if ($language_id) {
            foreach($language_id as $key => $value) {
                $series_language = new Series_Language();
                $series_language->series_id = $s_id;
                $series_language->language_id = $value;
                $series_language->save();
            }
        }
        $files=$request->file('small_image_path');
        if(count($files)!=0){
            $i=0;
            foreach ($files as $file) {
                $i++;
                $filename=$series_name.'_'.$s_id.'_SMALL_'.$i.'.jpg';
                if($file){
                    Storage::disk('local')->put($filename,File::get($file));
                }
            }
            $files=$request->file('large_image_path');
            $j=0;
            foreach ($files as $file){
                $j++;
                $filename=$series_name.'_'.$s_id.'_LARGE_'.$j.'.jpg';
                if($file){
                    Storage::disk('local')->put($filename,File::get($file));
                }
            }
            for($i=1;$i<=$j;$i++){
                $series_gallery=new Series_Gallery;
                $series_gallery->series_id=$s_id;
                $series_gallery->small_image_path=$series_name.'_'.$s_id.'_SMALL_'.$i.'.jpg';
                $series_gallery->large_image_path=$series_name.'_'.$s_id.'_LARGE_'.$i.'.jpg';
                $series_gallery->save();
            }
        }

        $award_name = $request->get('award_name');
        if ($award_name) {
            foreach($award_name as $key => $value) {
                $series_awards= new Series_Awards;
                $series_awards->series_id = $s_id;
                $series_awards->award_name = $award_name[$key];
                $series_awards->save();
            }
        }
        $country = $request->get('country');
        if ($country) {
            foreach($country as $key => $value) {
                $series_country = new Series_Country;
                $series_country->series_id=$s_id;
                $series_country->country_id=$country[$key];
                $series_country->save();
            }
        }
        $technicalspecs = new Technicalspecs;
        $technicalspecs->series_id=$s_id;
        $technicalspecs->sound_mix_type=$request->sound_mix_type;
        $technicalspecs->color=$request->color;
        $technicalspecs->aspect_ratio=$request->aspect_ratio;
        $technicalspecs->save();
        $city = $request->get('city');
        if ($city) {
            foreach($city as $key => $value) {
                $city1 = City::select("country_id")->where('city_id',$city[$key])->get();
                $series_filminglocation= new Series_Filminglocation;
                $series_filminglocation->series_id = $s_id;
                $series_filminglocation->city_id = $city[$key];
                foreach ($city1 as $c) {
                   $series_filminglocation->country_id = $c->country_id;
                }
                $series_filminglocation->save();
            }
        }
        $distributors = $request->get('distributors');
        if ($distributors){
            foreach($distributors as $key => $value) {
                $series_distributors= new Series_Distributors;
                $series_distributors->series_id = $s_id;
                $series_distributors->distributors = $distributors[$key];
                $series_distributors->save();
            }
        }
        $productionco = $request->get('productionco');
        if ($productionco){
            foreach($productionco as $key => $value){
                $series_productionco= new Series_Productionco;
                $series_productionco->series_id = $s_id;
                $series_productionco->production_co = $productionco[$key];
                $series_productionco->save();
            }
        }
        Session::flash("success"," $series_name Added");
        return redirect('/series');
    }

    public function edit($series_id){
        $series = Series::select("*")->where('series_id',$series_id)->get();
        $genre = Genre::select("*")->orderBy('id','asc')->get();
        $language = Language::select("*")->orderBy('id','asc')->get();
        $creator=Creator::select("*")->orderBy('id','desc')->get();
        $series_genre = array_flatten(Series_To_Genre_Mapping::select("genre_id")->orderBy('series_to_genre_mapping.genre_id','desc')
            ->where('series_to_genre_mapping.series_id',$series_id)->get()->toArray());
        $series_country = Series_Country::select("*")->where('series_country.series_id',$series_id)->get();
        $series_language = array_flatten(Series_Language::select("language_id")->orderBy('series_language.language_id','desc')
            ->where('series_language.series_id',$series_id)->get()->toArray());
        $series_gallery =Series_Gallery::select("*")->orderBy('series_gallery.series_id','asc')
            ->where('series_gallery.series_id',$series_id)
            ->get();
        $series_awards = array_flatten(Series_Awards::select("award_name")->where('series_awards.series_id',$series_id)
            ->get()->toArray());
        $technicalspecs=Technicalspecs::select("*")->where('technicalspecs.series_id',$series_id)
            ->get();
        $filminglocation=Series_Filminglocation::select("*")->where('series_filminglocation.series_id',$series_id)->get();
        $city=City::select("*")->get();    
        $distributors = array_flatten(Series_Distributors::select("distributors")->where('series_distributors.series_id',$series_id)
            ->get()->toArray());
        $productionco = array_flatten(Series_Productionco::select("production_co")->where('series_productionco.series_id',$series_id)
            ->get()->toArray());
        $country = Country::select("*")->orderBy('id','asc')->get();
        return view('portal.series.edit')->with("series",$series)
            ->with("genre",$genre)->with("language",$language)->with("language",$language)->with("creator",$creator)
            ->with("series_to_genre_mapping",$series_genre)->with("series_language",$series_language)->with('series_gallery',$series_gallery)
            ->with("series_awards",$series_awards)->with("technicalspecs",$technicalspecs)->with("filminglocation",$filminglocation)
            ->with("city",$city)->with("distributors",$distributors)->with("productionco",$productionco)->with("series_country",$series_country)
            ->with("country",$country);
    }

    public function update($series_id, Request $request){
        Series::where("series_id",$series_id)->update([
        	"series_name" => $request->series_name,
        	"summary_text" => $request->summary_text,
            "storyline" => $request->storyline,
            "published_date" => $request->published_date,
            "trailer_link" => $request->trailer_link,
            "series_fb"=> $request->series_fb,
            "series_insta" => $request->series_insta,
            "series_twitter" => $request->series_twitter,
            "creator_id"=>$request->creator_id,
        ]);
        $sn=array_flatten(Series::select("series_name")->where("series_id",$series_id)->get()->toArray());
        $series_name=$sn[0];
        $series_name=explode(" ",$series_name);
        $series_name=implode("-",$series_name);
        $series_name=explode("'",$series_name);
        $series_name=implode("-",$series_name);
        $file=$request->file('poster_path');
        $filename='POSTER_'.$series_name.'_'.$series_id.'.jpg';
        if(!empty($file)){
            if(file_exists($filename)){
                Storage::delete($filename);
            }             
            Storage::disk('local')->put($filename,File::get($file));
        }
        $file=$request->file('thumbnail_path');
        $filename='THUMBNAIL_'.$series_name.'_'.$series_id.'.jpg';
        if(!empty($file)){
            if(file_exists($filename)){
                Storage::delete($filename);
            }            
            Storage::disk('local')->put($filename,File::get($file));
        }
        Series_To_Genre_Mapping::where("series_id",$series_id)->delete();
        $genre_id = $request->get('genre_id');
        if ($genre_id){
            foreach($genre_id as $key => $value) {
                $series_genre = new Series_To_Genre_Mapping();
                $series_genre->series_id = $series_id;
                $series_genre->genre_id = $value;
                $series_genre->save();
            }
        }
        Series_Language::where("series_id",$series_id)->delete();
        $language_id = $request->get('language_id');
        if ($language_id){
            foreach($language_id as $key => $value) {
                $series_language = new Series_Language();
                $series_language->series_id = $series_id;
                $series_language->language_id = $value;
                $series_language->save();
            }
        }
        
        $count=Series_Gallery::select("*")->where("series_id",$series_id)->get()->count();
        $files=$request->file('small_image_path');
        $c=count($files);
        if($c!=0){
            if($c>$count){
                $files=$request->file('small_image_path');
                $i=0;
                foreach ($files as $file) {
                    $i++;
                    $filename=$series_name.'_'.$series_id.'_SMALL_'.$i.'.jpg';
                    if(!empty($file)){
                        Storage::disk('local')->put($filename,File::get($file));
                    }              
                }
                $files=$request->file('large_image_path');
                $i=0;
                foreach ($files as $file) {
                    $i++;
                    $filename=$series_name.'_'.$series_id.'_LARGE_'.$i.'.jpg';
                    if(!empty($file)){
                        Storage::disk('local')->put($filename,File::get($file));
                    }        
                }
                for($j=1;$j<=$i;$j++){
                    if($j>$count){
                        $series_gallery=new Series_Gallery;
                        $series_gallery->series_id=$series_id;
                        $series_gallery->small_image_path=$series_name.'_'.$series_id.'_SMALL_'.$j.'.jpg';
                        $series_gallery->large_image_path=$series_name.'_'.$series_id.'_LARGE_'.$j.'.jpg';
                        $series_gallery->save();
                    }
                }   
            }
            else{           
                for($j=1;$j<=$count;$j++){
                    if($j>$c){
                        $filename=$series_name.'_'.$series_id.'_SMALL_'.$j.'.jpg';
                        $filelarge=$series_name.'_'.$series_id.'_LARGE_'.$j.'.jpg';
                        Series_Gallery::where("small_image_path",$filename)->delete();
                    }
                }
                $files=$request->file('small_image_path');
                $c=count($files);
                $i=1;
                for($j=1;$j<=$count;$j++){
                    $n='small'.$j;
                    $f=$request->$n;        
                    if(!empty($f)){
                        $filename=$series_name.'_'.$series_id.'_SMALL_'.$j.'.jpg';
                        $name=$series_name.'_'.$series_id.'_SMALL_'.$i.'.jpg';
                        if(strcmp($name,$filename)!=0){
                            Storage::move($filename,$name);
                        }
                        $i++;
                    }
                    else{
                        $filename=$series_name.'_'.$series_id.'_SMALL_'.$j.'.jpg';
                        Storage::delete($filename);
                    }
                }  
                $i=0;
                foreach ($files as $file) {
                    $i++;
                    $filename=$series_name.'_'.$series_id.'_SMALL_'.$i.'.jpg';
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
                        $filename=$series_name.'_'.$series_id.'_LARGE_'.$j.'.jpg';
                        $name=$series_name.'_'.$series_id.'_LARGE_'.$i.'.jpg';
                        if(strcmp($name,$filename)!=0){
                            Storage::move($filename,$name);
                        }
                        $i++;
                    }
                    else{
                        $filename=$series_name.'_'.$series_id.'_LARGE_'.$j.'.jpg';
                        Storage::delete($filename);
                    }
                }  
                $i=0;
                foreach ($files as $file) {
                    $i++;
                    $filename=$series_name.'_'.$series_id.'_LARGE_'.$i.'.jpg';
                    if(!empty($file)){
                        Storage::delete($filename);
                        Storage::disk('local')->put($filename,File::get($file));
                    }
                }         
            }
        }
        else if($count!=0){
            for($j=1;$j<=$count;$j++){
                    
                        $filename=$series_name.'_'.$series_id.'_SMALL_'.$j.'.jpg';
                        $filelarge=$series_name.'_'.$series_id.'_LARGE_'.$j.'.jpg';
                        Series_Gallery::where("small_image_path",$filename)->delete();
                        if(file_exists($filename)){
                            Storage::delete($filename);
                        }
                    
                }

        }


        Series_Awards::where("series_id",$series_id)->delete();
        $award_name = $request->get('award_name');
        if ($award_name) {
            foreach($award_name as $key => $value) {
                $series_award = new Series_Awards();
                $series_award->series_id = $series_id;
                $series_award->award_name = $value;
                $series_award->save();
            } 
        }
        Series_Country::where("series_id",$series_id)->delete();
        $country = $request->get('country');
        if ($country) {
            foreach($country as $key => $value) {
                $series_country = new Series_Country;
                $series_country->series_id=$series_id;
                $series_country->country_id=$country[$key];
                $series_country->save();
            }
        }
        Technicalspecs::where("series_id",$series_id)->delete();
        $technicalspecs = new Technicalspecs;
        $technicalspecs->series_id=$series_id;
        $technicalspecs->sound_mix_type=$request->sound_mix_type;
        $technicalspecs->color=$request->color;
        $technicalspecs->aspect_ratio=$request->aspect_ratio;
        $technicalspecs->save();
        Series_Filminglocation::where("series_id",$series_id)->delete();
        $city = $request->get('city');
        if($city){
            foreach ($city as $key => $value) {
                $city1 = City::select("country_id")->where('city_id',$city[$key])->get();
                $series_filminglocation= new Series_Filminglocation;
                $series_filminglocation->series_id = $series_id;
                $series_filminglocation->city_id = $city[$key];
                foreach ($city1 as $c) {
                   $series_filminglocation->country_id = $c->country_id;
                }
                $series_filminglocation->save();
            }
        }
        Series_Distributors::where("series_id",$series_id)->delete();
        $distributors = $request->get('distributors');
        if ($distributors) {
            foreach($distributors as $key => $value) {
                $series_distributors= new Series_Distributors;
                $series_distributors->series_id = $series_id;
                $series_distributors->distributors = $distributors[$key];
                $series_distributors->save();
            }
        }
        Series_Productionco::where("series_id",$series_id)->delete();
        $productionco = $request->get('productionco');
        if ($productionco) {
            foreach($productionco as $key => $value) {
                $series_productionco= new Series_Productionco;
                $series_productionco->series_id = $series_id;
                $series_productionco->production_co = $productionco[$key];
                $series_productionco->save();
            }
        }
        Session::flash("success"," Edited");
        return redirect('/series');
    }


    public function delete($series_id){
        $series = new Series;
        $series_name= $series->series_name;
        $sr=Series::select("poster_path","thumbnail_path")->where("series_id",$series_id)->get();
        foreach ($sr as $s) {
            if(file_exists($s->poster_path)){
                Storage::delete($s->poster_path);
            }
            if(file_exists($s->thumbnail_path)){
                Storage::delete($s->thumbnail_path);
            }  
        }
        $sg=Series_Gallery::select("*")->where("series_id",$series_id)->get();
        foreach ($sg as $s) {
            if(file_exists($s->small_image_path)){
                Storage::delete($s->small_image_path);
            }
            if(file_exists($s->large_image_path)){
                Storage::delete($s->large_image_path);
            }   
        }
        $season=Series_To_Season_Mapping::where("series_id",$series_id)->get();
        foreach ($season as $s){
            $episode=Season_To_Episode_Mapping::where("season_id",$s->season_id)->get();
            foreach ($episode as $e) {
                $er=Episode::select("poster_image_path","landscape_image_path","thumbnail_image_path")->where("episode_id",$e->episode_id)->get();
                foreach ($er as $ep) {
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
        }
        Series::where("series_id",$series_id)->delete();
        Session::flash("success","$series_name Deleted");
        return redirect('/series');
    }
}
