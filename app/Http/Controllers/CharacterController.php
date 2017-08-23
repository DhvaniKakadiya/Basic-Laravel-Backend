<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Image;
use Illuminate\Http\Request;
use Session;
use App\Characte;
use App\Character_Gallery;
use Redirect;

class CharacterController extends Controller{

    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
	    $characte = Characte::select("*")->orderBy('id','desc')->get();
        $character_gallery = Character_Gallery::orderBy('characte.characte_id','desc')
            ->leftJoin('characte','character_gallery.characte_id','=','characte.characte_id')
            ->get();
        return view('portal.character.index')->with("characte",$characte)->with("character_gallery",$character_gallery);
    }

    public function create(){
        return view('portal.character.create');
    }
    
    public function store(Request $request){
        //stored in character table
        $characte = new Characte;
        $characte->characte_name = $request->characte_name;
        $characte->biography = $request->biography;
        $characte->save();
        $characte_name= $characte->characte_name;
        $characte_name=explode(" ",$characte_name);
        $characte_name=implode("-",$characte_name);
        $characte_name=explode("'",$characte_name);
        $characte_name=implode("-",$characte_name);
        $id= $characte->id;
        $c_id = "CH".$characte->id;
        Characte::where("id",$id)->update([
            "characte_id" => $c_id,
            "poster_path" => 'POSTER_'.$characte_name.'_'.$c_id.'.jpg',
        ]);
        //for poster path
        $file=$request->file('poster_path');
        $filename='POSTER_'.$characte_name.'_'.$c_id.'.jpg';
        if($file){
            Storage::disk('local')->put($filename,File::get($file));
        }
        //for gallery image upload
        $files=$request->file('small_image_path');
        if(count($files)!=0){
            $i=0;
            foreach ($files as $file){
                $i++;
                $filename=$characte_name.'_'.$c_id.'_SMALL_'.$i.'.jpg';
                if($file){
                    Storage::disk('local')->put($filename,File::get($file));
                }
            }
            $files=$request->file('large_image_path');
            $j=0;
            foreach ($files as $file){
                $j++;
                $filename=$characte_name.'_'.$c_id.'_LARGE_'.$j.'.jpg';
                if($file){
                    Storage::disk('local')->put($filename,File::get($file));
                }
            }
            //stored in character gallery
            for($i=1;$i<=$j;$i++){
                $character_gallery=new Character_Gallery;
                $character_gallery->characte_id=$c_id;
                $character_gallery->small_image_path=$characte_name.'_'.$c_id.'_SMALL_'.$i.'.jpg';
                $character_gallery->large_image_path=$characte_name.'_'.$c_id.'_LARGE_'.$i.'.jpg';
                $character_gallery->save();
                $id= $character_gallery->id;
                $cg_id = "CG".$character_gallery->id;
                Character_Gallery::where("id",$id)->update([
                        "character_gallery_id" => $cg_id,
                ]);
            } 
        }
        Session::flash("success",'$characte_name Added');
        return redirect('/character');
    }

    public function edit($characte_id){
        $characte = Characte::select("*")->where('characte_id',$characte_id)->get();
        $character_gallery =Character_Gallery::select("*")->orderBy('character_gallery.id','asc')
            ->where('character_gallery.characte_id',$characte_id)
            ->get();
        return view('portal.character.edit')->with('characte' , $characte)->with('character_gallery',$character_gallery);
    }

    public function update($characte_id, Request $request){
        Characte::where("characte_id",$characte_id)->update([
            "characte_name" => $request->characte_name,
        	"biography" =>$request->biography,
        ]);
        $cn=array_flatten(Characte::select("characte_name")->where("characte_id",$characte_id)->get()->toArray());
        $characte_name=$cn[0];
        $characte_name=explode(" ",$characte_name);
        $characte_name=implode("-",$characte_name);
        $characte_name=explode("'",$characte_name);
        $characte_name=implode("-",$characte_name);
        $file=$request->file('poster_path');
        $filename='POSTER_'.$characte_name.'_'.$characte_id.'.jpg';
        if(!empty($file)){
            if(file_exists($filename)){
                Storage::delete($filename);
            }            
            Storage::disk('local')->put($filename,File::get($file));
        }
        
        $count=Character_Gallery::select("*")->where("characte_id",$characte_id)->get()->count();
        $files=$request->file('small_image_path');
        $c=count($files);
        if($c!=0){
            if($c>$count){
                $files=$request->file('small_image_path');
                $i=0;
                foreach ($files as $file) {
                    $i++;
                    $filename=$characte_name.'_'.$characte_id.'_SMALL_'.$i.'.jpg';
                    if(!empty($file)){
                        Storage::disk('local')->put($filename,File::get($file));
                    }              
                }
                $files=$request->file('large_image_path');
                $i=0;
                foreach ($files as $file) {
                    $i++;
                    $filename=$characte_name.'_'.$characte_id.'_LARGE_'.$i.'.jpg';
                    if(!empty($file)){
                        Storage::disk('local')->put($filename,File::get($file));
                    }        
                }
                for($j=1;$j<=$i;$j++){
                    if($j>$count){
                        $character_gallery=new Character_Gallery;
                        $character_gallery->characte_id=$characte_id;
                        $character_gallery->small_image_path=$characte_name.'_'.$characte_id.'_SMALL_'.$j.'.jpg';
                        $character_gallery->large_image_path=$characte_name.'_'.$characte_id.'_LARGE_'.$j.'.jpg';
                        $character_gallery->save();
                        $id= $character_gallery->id;
                        $cg_id = "CG".$character_gallery->id;
                        Character_Gallery::where("id",$id)->update([
                                "character_gallery_id" => $cg_id,
                        ]);
                    }
                }   
            }
            else{           
                for($j=1;$j<=$count;$j++){
                    if($j>$c){
                        $filename=$characte_name.'_'.$characte_id.'_SMALL_'.$j.'.jpg';
                        $filelarge=$characte_name.'_'.$characte_id.'_LARGE_'.$j.'.jpg';
                        Character_Gallery::where("small_image_path",$filename)->delete();
                    }
                }
                $files=$request->file('small_image_path');
                $c=count($files);
                $i=1;
                for($j=1;$j<=$count;$j++){
                    $n='small'.$j;
                    $f=$request->$n;        
                    if(!empty($f)){
                        $filename=$characte_name.'_'.$characte_id.'_SMALL_'.$j.'.jpg';
                        $name=$characte_name.'_'.$characte_id.'_SMALL_'.$i.'.jpg';
                        if(strcmp($name,$filename)!=0){
                            Storage::move($filename,$name);
                        }
                        $i++;
                    }
                    else{
                        $filename=$characte_name.'_'.$characte_id.'_SMALL_'.$j.'.jpg';
                        Storage::delete($filename);
                    }
                }  
                $i=0;
                foreach ($files as $file) {
                    $i++;
                    $filename=$characte_name.'_'.$characte_id.'_SMALL_'.$i.'.jpg';
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
                        $filename=$characte_name.'_'.$characte_id.'_LARGE_'.$j.'.jpg';
                        $name=$characte_name.'_'.$characte_id.'_LARGE_'.$i.'.jpg';
                        if(strcmp($name,$filename)!=0){
                            Storage::move($filename,$name);
                        }
                        $i++;
                    }
                    else{
                        $filename=$characte_name.'_'.$characte_id.'_LARGE_'.$j.'.jpg';
                        Storage::delete($filename);
                    }
                }  
                $i=0;
                foreach ($files as $file) {
                    $i++;
                    $filename=$characte_name.'_'.$characte_id.'_LARGE_'.$i.'.jpg';
                    if(!empty($file)){
                        Storage::delete($filename);
                        Storage::disk('local')->put($filename,File::get($file));
                    }
                }         
            }
        }
        else if($count!=0){
            for($j=1;$j<=$count;$j++){
                    
                        $filename=$characte_name.'_'.$characte_id.'_SMALL_'.$j.'.jpg';
                        $filelarge=$characte_name.'_'.$characte_id.'_LARGE_'.$j.'.jpg';
                        Character_Gallery::where("small_image_path",$filename)->delete();
                        if(file_exists($filename)){
                            Storage::delete($filename);
                        }
                    
                }

        }
        $characte = new Characte;
        $characte_name = $characte->characte_name;
        Session::flash("success","$characte_name Edited");
        return redirect('/character');
    
    }

    public function delete($characte_id){
        $characte = new Characte;
        $cr=Characte::select("poster_path")->where("characte_id",$characte_id)->get();
        $characte_name= $characte->characte_name;
        foreach ($cr as $c) {
            if(file_exists($c->poster_path)){
                Storage::delete($c->poster_path);
            }
            
        }
        $cg=Character_Gallery::select("*")->where("characte_id",$characte_id)->get();
        foreach ($cg as $c) {
            if(file_exists($c->small_image_path)){
                Storage::delete($c->small_image_path);
            }
            if(file_exists($c->large_image_path)){
                Storage::delete($c->large_image_path);
            }   
        }
        Characte::where("characte_id",$characte_id)->delete();
        Session::flash("success","$characte_name Deleted");
        return redirect('/character');
    }
    
}
