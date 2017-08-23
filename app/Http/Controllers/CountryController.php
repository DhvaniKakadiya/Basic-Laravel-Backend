<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use App\Country;
use App\City;
use Redirect;
use App\Series_Filminglocation;

class CountryController extends Controller
{    
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        $country = Country::select("*")->orderBy('id','desc')->get();
        return view('portal.country.index')
            ->with("country",$country);
    }

    public function create(){
        return view('portal.country.create');
    }

    public function store(Request $request){
        $country = new Country;
        $country->country_name = $request->country_name;
        $country->save();        
        $country_name= $country->country_name;
        $id= $country->id;
        $c_id = "CN".$country->id;
        Country::where("id",$id)->update([
            "country_id" => $c_id,
        ]);    
        Session::flash("success"," $country_name Added");
        return redirect('/country'); 
    }

    public function delete($country_id){
        $country = new Country;
        Country::where("country_id",$country_id)->delete();
        Session::flash("success","Deleted");
        return redirect('/country');
    }
}
