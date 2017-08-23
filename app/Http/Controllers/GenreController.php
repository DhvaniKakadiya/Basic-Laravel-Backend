<?php

namespace App\Http\Controllers;
use Session;
use App\Genre;
use App\Series_To_Genre_Mapping;
use Redirect;

use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
        
    public function index(){
        $genre = Genre::select("*")->orderBy('id','desc')->get();
        return view('portal.genre.index')
            ->with("genre",$genre);
    }

    public function create(){
        return view('portal.genre.create');
    }

    public function store(Request $request){
        $genre = new Genre;
        $genre->genre_name = $request->genre_name;
        $genre->save();        
        $genre_name= $genre->genre_name;
        $id= $genre->id;
        $g_id = "GG".$genre->id;
        Genre::where("id",$id)->update([
            "genre_id" => $g_id,
        ]);    
        Session::flash("success"," $genre_name Added");
        return redirect('/genre'); 
    }

    public function delete($genre_id){
        $genre = new Genre;
        $genre_name= $genre->genre_name;
        Genre::where("genre_id",$genre_id)->delete();
        Session::flash("success","$genre_name Deleted");
        return redirect('/genre');
    }
}
