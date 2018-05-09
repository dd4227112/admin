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
        $result = '';
        if (strlen($q) > 2) { //prevent empty search which load all results
            $users = DB::select('select * from admin.all_users where lower(name) like \'%' . strtolower($q) . '%\' or lower(phone) like \'%' . strtolower($q) . '%\' ');
            foreach ($users as $user) {

                $result .= '<li><a href="' . url('profile/' . $user->schema_name . '/' . $user->table . '/' . $user->id) . '">                <div class="user-img"> <img src="public/plugins/images/users/varun.jpg" alt="user" class="img-circle"> <span class="profile-status online pull-right"></span> </div>
                                            <div class="mail-contnet">
                                                <h5>' . $user->name . '</h5> <span class="mail-desc">User Type: ' . $user->usertype . '</span> <span class="time">School: ' . $user->schema_name . '</span> </div>
                                        </a></li>';
            }
            return json_encode(array(
                'total' => count($users),
                'result' => $result
            ));
        }
    }

    public function searchResult() {
        $this->data['result'] = json_decode($this->search());
        return view('profile.search_results', $this->data);
    }

    function testing() {
        $data = ['content' => 'testing sending email', 'link' => 'link', 'photo' => 'testing', 'sitename' => 'demo', 'name' => ''];
        $message = 'none';
        Mail::send('email.default', $data, function ($m) use ($message) {
            $m->from('noreply@shulesoft.com', 'testing');
            $m->to('swillae1@gmail.com')->subject('tsti message');
        });
        dd(Mail::failures());
    }

}
