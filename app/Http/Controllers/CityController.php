<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use App\Country;
use App\City;
use App\Series_Filminglocation;
use Redirect;

class CityController extends Controller{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        $city = City::select("*")->orderBy('city.id','desc')
            ->leftJoin('country','city.country_id','=','country.country_id')
            ->get();
        return view('portal.city.index')
            ->with("city",$city);
    }

    public function create(){
        $country = Country::select("*")->orderBy('id','desc')->get();
        return view('portal.city.create')->with("country",$country);;
    }

    public function store(Request $request)
    {
        $city_name = $request->get('city_name');
        if ($city_name) {
            foreach($city_name as $key => $value) {
                $city = new City;
                $city->city_name = $city_name[$key];
                $city->country_id = $request->country_id;
                $city->save();        
                $id= $city->id;
                $c_id = "CT".$city->id;
                City::where("id",$id)->update([
                    "city_id" => $c_id,
                ]);    
            }
        }
        Session::flash("success","Added");
        return redirect('/city'); 
    }

    public function delete($city_id){
        $city = new City;
        City::where("city_id",$city_id)->delete();
        Series_Filminglocation::where("city_id",$city_id)->delete();
        Session::flash("success","Deleted");
        return redirect('/city');
    }
}
