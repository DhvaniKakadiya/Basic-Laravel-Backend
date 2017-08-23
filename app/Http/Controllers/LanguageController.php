<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use App\Language;
use App\Series_Language;
use Redirect;

class LanguageController extends Controller{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        $language = Language::select("*")->orderBy('id','desc')->get();
        return view('portal.language.index')
            ->with("language",$language);
    }

    public function create(){
        return view('portal.language.create');
    }

    public function store(Request $request){
        $language = new Language;
        $language->language_name = $request->language_name;
        $language->save();        
        $language_name= $language->language_name;
        $id= $language->id;
        $l_id = "LL".$language->id;
        Language::where("id",$id)->update([
            "language_id" => $l_id,
        ]);    
        Session::flash("success"," $language_name Added");
        return redirect('/language'); 
    }

    public function delete($language_id){
        $language = new Language;
        $language_name= $language->language_name;
        Language::where("language_id",$language_id)->delete();
        Session::flash("success","$language_name Deleted");
        return redirect('/language');
    }
}
