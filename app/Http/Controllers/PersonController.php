<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Session;
use App\Person;
use App\Person_Awards;
use App\Episode_Details;
use App\Country;
use App\City;
use App\Country_City;
use App\Image_Gallery;
use App\Person_Gallery;
use Redirect;

class PersonController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
	    $person = Person::select("*")->orderBy('id','desc')->get();
        $person_awards = Person_Awards::orderBy('person.person_id','desc')
            ->leftJoin('person','person_awards.person_id','=','person.person_id')
            ->get();
        $person_gallery = Person_Gallery::orderBy('person.person_id','desc')
            ->leftJoin('person','person_gallery.person_id','=','person.person_id')
            ->get();
        return view('portal.person.index')->with("person",$person)->with("person_awards",$person_awards)
            ->with("person_gallery",$person_gallery);
    }

    public function create(){
        $person_awards = Person_Awards::select("*")->orderBy('person_id','asc')->get();
        return view('portal.person.create')->with("person_awards",$person_awards);
    }

    public function getCityList($country_id){
        $city = City::select("city_name","city_id")
            ->where("country_id",$country_id)->get();
        return response()->json($city);
    }

    public function store(Request $request){
        $person = new Person;
        $person->person_name = $request->person_name;
        $person->birth_date = $request->birth_date;
        $person->birth_place = $request->birth_place;
        $person->death_date = $request->death_date;
        $person->death_place = $request->death_place;
        $person->short_description = $request->short_description;
        $person->full_biography = $request->full_biography;
        $person->save();
        $person_name= $person->person_name;
        $person_name=explode(" ",$person_name);
        $person_name=implode("-",$person_name);
        $person_name=explode("'",$person_name);
        $person_name=implode("-",$person_name);
        $id= $person->id;
        $p_id = "PR".$person->id;
        $award_name = $request->get('award_name');
        Person::where("id",$id)->update([
            "person_id" => $p_id,
            "square_image"=>'SQUARE_'.$person_name.'_'.$p_id.'.jpg',
            "poster_image"=>'POSTER_ '.$person_name.'_'.$p_id.'.jpg',
        ]);
        $file=$request->file('square_image');
        $filename='SQUARE_'.$person_name.'_'.$p_id.'.jpg';
        if($file){
            Storage::disk('local')->put($filename,File::get($file));
        }
        $file=$request->file('poster_image');
        $filename='POSTER_ '.$person_name.'_'.$p_id.'.jpg';
        if($file){
            Storage::disk('local')->put($filename,File::get($file));
        }
        $award_name = $request->get('award_name');
        if ($award_name){
            foreach($award_name as $key => $value) {
                $person_awards= new Person_Awards;
                $person_awards->person_id = $p_id;
                $person_awards->award_name = $award_name[$key];
                $person_awards->save();
            }
        }
        $files=$request->file('small_image_path');
        if(count($files)!=0){
            $i=0;
            foreach ($files as $file){
                $i++;
                $filename=$person_name.'_'.$p_id.'_SMALL_'.$i.'.jpg';
                if($file){
                    Storage::disk('local')->put($filename,File::get($file));
                }
            }
            $files=$request->file('large_image_path');
            $j=0;
            foreach ($files as $file){
                $j++;
                $filename=$person_name.'_'.$p_id.'_LARGE_'.$j.'.jpg';
                if($file){
                    Storage::disk('local')->put($filename,File::get($file));
                }
            }
            for($i=1;$i<=$j;$i++){
                $person_gallery=new Person_Gallery;
                $person_gallery->person_id=$p_id;
                $person_gallery->small_image_path=$person_name.'_'.$p_id.'_SMALL_'.$i.'.jpg';
                $person_gallery->large_image_path=$person_name.'_'.$p_id.'_LARGE_'.$i.'.jpg';
                $person_gallery->save();
            }
        }
        Session::flash("success"," $person_name Added");
        return redirect('/person');
    }

    public function edit($person_id){
        $person = Person::select("*")->where('person_id',$person_id)->get();
		$person_awards = array_flatten(Person_Awards::select("award_name")->where('person_awards.person_id',$person_id)
                ->get()->toArray());
        $person_gallery =Person_Gallery::select("*")->orderBy('person_gallery.person_id','asc')->where('person_gallery.person_id',$person_id)
                ->get();
        return view('portal.person.edit') ->with('person' , $person)->with('person_awards',$person_awards)
            ->with('person_gallery',$person_gallery);
    }

    public function update($person_id, Request $request){
        Person::where("person_id",$person_id)->update([
            "person_name" => $request->person_name,
            "birth_date" => $request->birth_date,
        	"birth_place" => $request->birth_place,
            "death_date" => $request->death_date,
            "death_place" => $request->death_place,
        	"short_description" =>$request->short_description,
        	"full_biography" => $request->full_biography,
            
        ]);
        Person_Awards::where("person_id",$person_id)->delete();
        $award_name = $request->get('award_name');
        if ($award_name){
            foreach($award_name as $key => $value){
                $person_award = new Person_Awards();
                $person_award->person_id = $person_id;
                $person_award->award_name = $value;
                $person_award->save();
            }
        }
        $pn=array_flatten(Person::select("person_name")->where("person_id",$person_id)->get()->toArray());
        $person_name=$pn[0];
        $person_name=explode(" ",$person_name);
        $person_name=implode("-",$person_name);
        $person_name=explode("'",$person_name);
        $person_name=implode("-",$person_name);
        Person::where("person_id",$person_id)->update([
            "square_image" => 'SQUARE_'.$person_name.'_'.$person_id .'.jpg',
            "poster_image" => 'POSTER_'.$person_name.'_'.$person_id .'.jpg',
        ]);
        $file=$request->file('square_image');
        $filename='SQUARE_'.$person_name.'_'.$person_id .'.jpg';
        if(!empty($file)){
            if(file_exists($filename)){
                Storage::delete($filename);
            }             
            Storage::disk('local')->put($filename,File::get($file));
        }
        $file=$request->file('poster_image');
        $filename='POSTER_'.$person_name.'_'.$person_id .'.jpg';
        if(!empty($file)){
            if(file_exists($filename)){
                Storage::delete($filename);
            }             
            Storage::disk('local')->put($filename,File::get($file));
        }
        $count=Person_Gallery::select("*")->where("person_id",$person_id)->get()->count();
        $files=$request->file('small_image_path');
        $c=count($files);
        if($c!=0){
            if($c>$count){
                $files=$request->file('small_image_path');
                $i=0;
                foreach ($files as $file) {
                    $i++;
                    $filename=$person_name.'_'.$person_id.'_SMALL_'.$i.'.jpg';
                    if(!empty($file)){
                        Storage::disk('local')->put($filename,File::get($file));
                    }              
                }
                $files=$request->file('large_image_path');
                $i=0;
                foreach ($files as $file) {
                    $i++;
                    $filename=$person_name.'_'.$person_id.'_LARGE_'.$i.'.jpg';
                    if(!empty($file)){
                        Storage::disk('local')->put($filename,File::get($file));
                    }        
                }
                for($j=1;$j<=$i;$j++){
                    if($j>$count){
                        $person_gallery=new Person_Gallery;
                        $person_gallery->person_id=$person_id;
                        $person_gallery->small_image_path=$person_name.'_'.$person_id.'_SMALL_'.$j.'.jpg';
                        $person_gallery->large_image_path=$person_name.'_'.$person_id.'_LARGE_'.$j.'.jpg';
                        $person_gallery->save();
                    }
                }   
            }
            else{         
                for($j=1;$j<=$count;$j++){
                    if($j>$c){
                        $filename=$person_name.'_'.$person_id.'_SMALL_'.$j.'.jpg';
                        $filelarge=$person_name.'_'.$person_id.'_LARGE_'.$j.'.jpg';
                        Person_Gallery::where("small_image_path",$filename)->delete();
                    }
                }
                $files=$request->file('small_image_path');
                $c=count($files);
                $i=1;
                for($j=1;$j<=$count;$j++){
                    $n='small'.$j;
                    $f=$request->$n;        
                    if(!empty($f)){
                        $filename=$person_name.'_'.$person_id.'_SMALL_'.$j.'.jpg';
                        $name=$person_name.'_'.$person_id.'_SMALL_'.$i.'.jpg';
                        if(strcmp($name,$filename)!=0){
                            Storage::move($filename,$name);
                        }
                        $i++;
                    }
                    else{
                        $filename=$person_name.'_'.$person_id.'_SMALL_'.$j.'.jpg';
                        if(file_exists($filename)){
                            Storage::delete($filename);
                        }
                    }
                }  
                $i=0;
                foreach ($files as $file) {
                    $i++;
                    $filename=$person_name.'_'.$person_id.'_SMALL_'.$i.'.jpg';
                    if(!empty($file)){
                        if(file_exists($filename)){
                            Storage::delete($filename);
                        }
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
                        $filename=$person_name.'_'.$person_id.'_LARGE_'.$j.'.jpg';
                        $name=$person_name.'_'.$person_id.'_LARGE_'.$i.'.jpg';
                        if(strcmp($name,$filename)!=0){
                            if(file_exists($filename)){
                            Storage::delete($filename);
                        }
                        }
                        $i++;
                    }
                    else{
                        $filename=$person_name.'_'.$person_id.'_LARGE_'.$j.'.jpg';
                        if(file_exists($filename)){
                            Storage::delete($filename);
                        }
                    }
                }  
                $i=0;
                foreach ($files as $file) {
                    $i++;
                    $filename=$person_name.'_'.$person_id.'_LARGE_'.$i.'.jpg';
                    if(!empty($file)){
                        if(file_exists($filename)){
                            Storage::delete($filename);
                        }
                        Storage::disk('local')->put($filename,File::get($file));
                    }
                }         
            }
        }
        else if($count!=0){
            for($j=1;$j<=$count;$j++){
                        $filename=$person_name.'_'.$person_id.'_SMALL_'.$j.'.jpg';
                        $filelarge=$person_name.'_'.$person_id.'_LARGE_'.$j.'.jpg';
                        Person_Gallery::where("small_image_path",$filename)->delete();
                        if(file_exists($filename)){
                            Storage::delete($filename);
                        }
                    
                }

        }


        $person = new Person;
        $person_name = $person->person_name;
        Session::flash("success","$person_name Edited");
        return redirect('/person');
    }

    public function delete($person_id){
        $person = new Person;
        $person_name= $person->person_name;
        $pr=Person::select("square_image","poster_image")->where("person_id",$person_id)->get();
        foreach ($pr as $p) {
            if(file_exists($p->square_image)){
                Storage::delete($p->square_image);
            }
            if(file_exists($p->poster_image)){
                Storage::delete($p->poster_image);
            }  
        }
        $pg=Person_Gallery::select("*")->where("person_id",$person_id)->get();
        foreach ($pg as $p){
            if(file_exists($p->small_image_path)){
                Storage::delete($p->small_image_path);
            }
            if(file_exists($p->large_image_path)){
                Storage::delete($p->large_image_path);
            }
        }
        Person::where("person_id",$person_id)->delete();
        Session::flash("success","$person_name Deleted");
        return redirect('/person');
    }
}
