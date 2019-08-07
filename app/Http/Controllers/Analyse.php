<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class Analyse extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
         $this->middleware('auth');
    }
    public function logRequest() {
        $sql="select count(*),created_at::date from admin.all_log where created_at::date <= '2018-02-03' and created_at::date>= '2018-01-03' group by created_at::date order by created_at desc";
    }
    
    public function index() {
         $this->data['users'] = [];
        // $this->data['log_graph'] = $this->createBarGraph();
        return view('analyse.index', $this->data);
    }
}
