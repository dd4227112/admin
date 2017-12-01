<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $this->data['users']=DB::select('select count(*), usertype from all_users group by usertype');
        
        $this->data['log_graph']= $this->createBarGraph();
        return view('home', $this->data);
    }
    public function users(){

    }
}
