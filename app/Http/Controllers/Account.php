<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class Account extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
         $this->middleware('auth');
    }
    public function index() {
         $this->data['users'] = [];
        // $this->data['log_graph'] = $this->createBarGraph();
        return view('analyse.index', $this->data);
    }
    
    public function projection() {
        $this->data['budget']=[];
        return view('account.projection', $this->data);
    }
}
