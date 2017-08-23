<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Session;
use App\Creator;
use Redirect;

class CreatorController extends Controller
{    
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        $creator = Creator::select("*")->orderBy('id','desc')->get();
        return view('portal.creator.index')
            ->with("creator",$creator);
    }

    public function create(){
        return view('portal.creator.create');
    }

    public function store(Request $request)
    {
        $creator = new Creator;
        $creator->creator_name = $request->creator_name;
        $creator->fb_link = $request->fb_link;
        $creator->insta_link = $request->insta_link;
        $creator->twitter_link = $request->twitter_link;
        $creator->website_link = $request->website_link;
        $creator->short_description = $request->short_description;
        $creator->full_bio=$request->full_bio;
        $creator->established_date = $request->established_date;
        $creator->save();        
        $creator_name= $creator->creator_name;
        $creator_name=explode(" ",$creator_name);
        $creator_name=implode("-",$creator_name);
        $creator_name=explode("'",$creator_name);
        $creator_name=implode("-",$creator_name);
        $id= $creator->id;
        $c_id = "CR".$creator->id;
        Creator::where("id",$id)->update([
            "creator_id" => $c_id,
            "poster_image_path"=>'POSTER_'.$creator_name.'_'.$c_id.'.jpg',
            "landscape_image_path"=>'LANDSCAPE_'.$creator_name.'_'.$c_id.'.jpg',
            "thumbnail_image_path"=>'THUMBNAIL_'.$creator_name.'_'.$c_id.'.jpg',
        ]);  
        $file=$request->file('poster_image_path');
        $filename='POSTER_'.$creator_name.'_'.$c_id.'.jpg';
        if($file){
            Storage::disk('local')->put($filename,File::get($file));
        }
        $file=$request->file('landscape_image_path');
        $filename='LANDSCAPE_'.$creator_name.'_'.$c_id.'.jpg';
        if($file){
            Storage::disk('local')->put($filename,File::get($file));
        }
        $file=$request->file('thumbnail_image_path');
        $filename='THUMBNAIL_'.$creator_name.'_'.$c_id.'.jpg';
        if($file){
            Storage::disk('local')->put($filename,File::get($file));
        }
        Session::flash("success"," $creator_name Added");
        return redirect('/creator'); 
    }

    public function edit($creator_id){
        $creator = Creator::select("*")->where('creator_id',$creator_id)->get();                
        return view('portal.creator.edit')
            ->with("creator",$creator);
    }

    public function update($creator_id, Request $request){
        Creator::where("creator_id",$creator_id)->update([
			"creator_name" => $request->creator_name,
			"fb_link" => $request->fb_link,
			"insta_link" => $request->insta_link,
			"twitter_link" => $request->twitter_link,
			"website_link" => $request->website_link,
			"short_description" => $request->short_description,
            "full_bio"=>$request->full_bio,
			"established_date" => $request->established_date,
        ]);
        $cn=array_flatten(Creator::select("creator_name")->where("creator_id",$creator_id)->get()->toArray());
        $creator_name=$cn[0];
        $creator_name=explode(" ",$creator_name);
        $creator_name=implode("-",$creator_name);
        $creator_name=explode("'",$creator_name);
        $creator_name=implode("-",$creator_name);
        $file=$request->file('poster_image_path');
        $filename='POSTER_'.$creator_name.'_'.$creator_id.'.jpg';
        if(!empty($file)){
            if(file_exists($filename)){
                Storage::delete($filename);
            }             
            Storage::disk('local')->put($filename,File::get($file));
        }
        $file=$request->file('landscape_image_path');
        $filename='LANDSCAPE_'.$creator_name.'_'.$creator_id.'.jpg';
        if(!empty($file)){
            if(file_exists($filename)){
                Storage::delete($filename);
            }             
            Storage::disk('local')->put($filename,File::get($file));
        }
        $file=$request->file('thumbnail_image_path');
        $filename='THUMBNAIL_'.$creator_name.'_'.$creator_id.'.jpg';
        if(!empty($file)){
            if(file_exists($filename)){
                Storage::delete($filename);
            }             
            Storage::disk('local')->put($filename,File::get($file));
        }
        $creator = new Creator;
        $creator_name = $creator->creator_name;
        Session::flash("success","$creator_name Edited");
        return redirect('/creator');   
    }

    public function delete($creator_id){
        $creator = new creator;
        $creator_name= $creator->creator_name;
        $er=Creator::select("poster_image_path","landscape_image_path","thumbnail_image_path")->where("creator_id",$creator_id)->get();
        foreach ($er as $e) {
            if(file_exists($e->poster_image_path)){
                Storage::delete($e->poster_image_path);
            }
            if(file_exists($e->landscape_image_path)){
                Storage::delete($e->landscape_image_path);
            }
            if(file_exists($e->thumbnail_image_path)){
                Storage::delete($e->thumbnail_image_path);
            }    
        }
        Creator::where("creator_id",$creator_id)->delete();
        Session::flash("success","$creator_name Deleted");
        return redirect('/creator');
    }
}
