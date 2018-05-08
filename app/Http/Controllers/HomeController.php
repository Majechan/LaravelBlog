<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB; //sql method getting data form database

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth',['except' => ['index']]);
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$userid=auth()->user()->id;
        $posts = DB::select('SELECT a.*,b.name FROM bloglists a  inner join users b on a.createdby = b.id where a.deleted<>"Y"order by a.created_at desc');

        return view('pages.home')->with('posts',$posts);
    }
}
