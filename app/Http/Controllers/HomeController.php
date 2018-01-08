<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {


        $this->data['users'] = DB::select('select count(*), usertype from all_users group by usertype');

        $this->data['log_graph'] = $this->createBarGraph();
        return view('home', $this->data);
    }

    public function users() {
        
    }

    public function search() {
        $q = request('q');
        $result='';
        if (strlen($q) > 2) { //prevent empty search which load all results
            $users = DB::select('select * from admin.all_users where lower(name) like \'%' . strtolower($q)  . '%\' ');
            foreach ($users as $user) {

                $result.= '<a href="'.url('profile/'.$user->schema_name.'/'.$user->table.'/'.$user->id).'">
                                            <div class="user-img"> <img src="plugins/images/users/pawandeep.jpg" alt="user" class="img-circle"> <span class="profile-status online pull-right"></span> </div>
                                            <div class="mail-contnet">
                                                <h5>'.$user->name.'</h5> <span class="mail-desc">User Type: '.$user->usertype.'</span> <span class="time">School: '.$user->schema_name.'</span> </div>
                                        </a>';
            }
            echo json_encode(array(
                'total'=> count($users),
                'result'=>$result
            ));
        }
    }

}
