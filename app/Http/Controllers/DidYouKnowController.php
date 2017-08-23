<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Episode;
use App\Series;
use App\Travia;
use App\Quotes;
use App\CrazyCredits;
use App\Goofs;
use Session;

class DidYouKnowController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //isspoiler
        $travia = Travia::select("*")->get();
        $episodes = Series::all();
        $e_t = Travia::select("series_id")->get()->toArray();
        $quotes = Quotes::select("*")->get();
        $q_t = Quotes::select("series_id")->get()->toArray();
        $goofs = Goofs::select("*")->get();
        $g_t = Goofs::select("series_id")->get()->toArray();
        $cc = CrazyCredits::select("*")->get();
        $cc_t = CrazyCredits::select("series_id")->get()->toArray();

        $tmp1 = array_merge($e_t,$q_t,$cc_t,$g_t);
        $allEpisode=array_map('unserialize', array_unique(array_map('serialize', $tmp1)));

        return view('portal.didyouknow.index')
            ->with("dyk_episode", $episodes)
            ->with("travia", $travia)
            ->with("quotes", $quotes)
            ->with("goofs", $goofs)
            ->with("crazy", $cc);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
        $episode = Series::select("series_id","series_name")->get();
        return view('portal.didyouknow.create')
            ->with("episode",$episode);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        
        $episode_id = $request ->episode ;
        $travia_data = $request-> get('travia');
        $quotes_data= $request-> get('quotes');
        $crazycredits_data = $request-> get('crazy_credits');
        $goofs_data = $request-> get('goofs');

        //get Spoiler
        $travia_sp = $request-> get('travia-chk-box');
        $quotes_sp = $request->get('quotes-chk-box');
        $crazycredits_sp = $request->get('crazy_credits-chk-box');
        $goofs_sp = $request->get('goofs-chk-box');

        for($i=0 ; $i< count($travia_data) ; $i++ ){
            if($travia_data){
                $travia = new Travia ;
                $travia->series_id=  $episode_id ;
                $travia->travia_details=$travia_data[$i];
                if( !empty($travia_sp[$i]) && $travia_sp[$i] == "true" )  {
                    $travia->isspoiler = 1 ;
                }else{
                    $travia->isspoiler = 0 ;
                }
                $travia->save();     
            }
        }

        for($i=0 ; $i< count($quotes_data) ; $i++ ){
            if($quotes_data){
                $quotes = new Quotes ;
                $quotes->series_id =  $episode_id ;
                $quotes->quotes_details=$quotes_data[$i];
                if( !empty($quotes_sp[$i]) && $quotes_sp[$i] == "true" )  {
                    $quotes->isspoiler = 1 ;
                }else{
                    $quotes->isspoiler = 0 ;
                }
                $quotes->save();     
            }
        }

        for($i=0 ; $i< count($crazycredits_data) ; $i++ ){
            if($crazycredits_data){
                $crazycredits = new CrazyCredits ;
                $crazycredits->series_id=  $episode_id ;
                $crazycredits->crazy_credits_details=$crazycredits_data[$i];
                if( !empty($crazycredits_sp[$i]) && $crazycredits_sp[$i] == "true" )  {
                    $crazycredits->isspoiler = 1 ;
                }else{
                    $crazycredits->isspoiler = 0 ;
                }
                $crazycredits->save();     
            }
        }

        for($i=0 ; $i< count($goofs_data) ; $i++ ){
            if($goofs_data){
                $goofs = new Goofs ;
                $goofs->series_id=  $episode_id ;
                $goofs->goofs_details=$goofs_data[$i];
                if( !empty($goofs_sp[$i]) && $goofs_sp[$i] == "true" )  {
                    $goofs->isspoiler = 1 ;
                }else{
                    $goofs->isspoiler = 0 ;
                }
                $goofs->save();     
            }
        }
        Session::flash("success"," $episode_id Added");
        return redirect('/DidYouKnow'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($episode_id)
    {
        $ep_id = $episode_id ;
        $id=$episode_id;
        $travia = Travia::select("*")->where("series_id",$id)->get();
        $quotes = Quotes::select("*")->where("series_id",$id)->get();
        $goofs = Goofs::select("*")->where("series_id",$id)->get();
        $cc = CrazyCredits::select("*")->where("series_id",$id)->get();
        $episode = Series::select("series_id","series_name")->get();
        return view('portal.didyouknow.edit')
            ->with("episode", $episode)
            ->with("travia", $travia)
            ->with("quotes", $quotes)
            ->with("goofs", $goofs)
            ->with("crazy", $cc)
            ->with("ep_id", $ep_id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $episode_id)
    {
        $episode_id = $request ->episode ;
        $travia_data = $request-> get('travia');
        $quotes_data= $request-> get('quotes');
        $crazycredits_data = $request-> get('crazy_credits');
        $goofs_data = $request-> get('goofs');

        //get Spoiler
        $travia_sp = $request-> get('travia-chk-box');
        $quotes_sp = $request->get('quotes-chk-box');
        $crazycredits_sp = $request->get('crazy_credits-chk-box');
        $goofs_sp = $request->get('goofs-chk-box');
        Travia::where("series_id",$episode_id)->delete();
        for($i=0 ; $i< count($travia_data) ; $i++ ){
            if($travia_data){
                $travia = new Travia ;
                $travia->series_id=  $episode_id ;
                $travia->travia_details=$travia_data[$i];
                if( !empty($travia_sp[$i]) && $travia_sp[$i] == "true" )  {
                    $travia->isspoiler = 1 ;
                }else{
                    $travia->isspoiler = 0 ;
                }
                $travia->save();     
            }
        }
        Quotes::where("series_id",$episode_id)->delete();
        for($i=0 ; $i< count($quotes_data) ; $i++ ){
            if($quotes_data){
                $quotes = new Quotes ;
                $quotes->series_id=  $episode_id ;
                $quotes->quotes_details=$quotes_data[$i];
                if( !empty($quotes_sp[$i]) && $quotes_sp[$i] == "true" )  {
                    $quotes->isspoiler = 1 ;
                }else{
                    $quotes->isspoiler = 0 ;
                }
                $quotes->save();     
            }
        }
        CrazyCredits::where("series_id",$episode_id)->delete();
        for($i=0 ; $i< count($crazycredits_data) ; $i++ ){
            if($crazycredits_data){
                $crazycredits = new CrazyCredits ;
                $crazycredits->series_id=  $episode_id ;
                $crazycredits->crazy_credits_details=$crazycredits_data[$i];
                if( !empty($crazycredits_sp[$i]) && $crazycredits_sp[$i] == "true" )  {
                    $crazycredits->isspoiler = 1 ;
                }else{
                    $crazycredits->isspoiler = 0 ;
                }
                $crazycredits->save();     
            }
        }
        Goofs::where("series_id",$episode_id)->delete();
        for($i=0 ; $i< count($goofs_data) ; $i++ ){
            if($goofs_data){
                $goofs = new Goofs ;
                $goofs->series_id =  $episode_id ;
                $goofs->goofs_details=$goofs_data[$i];
                if( !empty($goofs_sp[$i]) && $goofs_sp[$i] == "true" )  {
                    $goofs->isspoiler = 1 ;
                }else{
                    $goofs->isspoiler = 0 ;
                }
                $goofs->save();     
            }
        }
        return redirect('/DidYouKnow');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function delete($id)
    {
       Travia::where("series_id",$id)->delete();
       Quotes::where("series_id",$id)->delete();
       CrazyCredits::where("series_id",$id)->delete();
       Goofs::where("series_id",$id)->delete();
       Session::flash("success","$id Deleted");
       return redirect('/DidYouKnow'); 
    }
}
