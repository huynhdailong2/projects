<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controllers;


class StudViewController extends Controller
{
    public function index()
    {
        return "Controller";
    }
    public function login()
    {
        return view('login');
    }
    public function indexmain()
    {
        return view('index');
    }
    public function act_login(Request $request)
    {
           $name=$request->input('username');
           $pass=$request->input('password');
           $result=DB::table('user')->where('username',$name)-> where('password',$pass)->first();

        if(isset($result->name))
        {
            return " thành công";
            
        }
        else
        return " thất bại ";
    }
    
}
