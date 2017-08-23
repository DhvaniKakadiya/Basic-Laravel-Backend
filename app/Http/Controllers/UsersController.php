<?php

namespace App\Http\Controllers;
use Session;
use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller{

    public function __construct(){
        $this->middleware('auth');
        $this->middleware('role');
    }
        
    public function index(){
        $user = User::select("name","email","role")->get();
        return view('portal.user.index')
            ->with("user",$user);
    }

    public function edit($email){
        $user = User::select("*")->where('email',$email)->get();
        return view('portal.user.edit') ->with('user' , $user);
    }

    public function update($email, Request $request){
        User::where("email",$email)->update([
            "role" => $request->role,
        ]);
        $user = new User;
        $username = $user->name;
        Session::flash("success","$username Edited");
        return redirect('/users');
    }

    public function delete($email){
       	User::where("email",$email)->delete();
        Session::flash("success","Deleted");
        return redirect('/users');
    }

}
