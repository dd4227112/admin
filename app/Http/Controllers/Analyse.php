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
         $this->data['total_schools']=\collect(DB::select(" select count(distinct \"table_schema\") as aggregate from INFORMATION_SCHEMA.TABLES where \"table_schema\" not in ('admin', 'beta_testing', 'api', 'app', 'constant', 'public','administration')"))->first()->aggregate;
         $this->data['active_schools']=\collect(DB::select(" select count(distinct \"schema_name\") as aggregate from admin.all_log where \"table\"  in ('user', 'teacher') and (created_at >= date_trunc('week', CURRENT_TIMESTAMP - interval '1 week') and
       created_at < date_trunc('week', CURRENT_TIMESTAMP)
      )"))->first()->aggregate;
        // $this->data['log_graph'] = $this->createBarGraph();
        return view('analyse.index', $this->data);
    }
    
    public function summary() {
        
        
    }
}
