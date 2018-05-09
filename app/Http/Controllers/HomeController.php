<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller {

    public $emails;
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

    static function sendEmail() {
        $emails = DB::select('select * from public.all_email limit 8');
        if (!empty($emails)) {
            foreach ($emails as $message) {
                if (filter_var($message->email, FILTER_VALIDATE_EMAIL) && !preg_match('/shulesoft/', $message->email)) {
                    try {
                        $data = ['content' => $message->body, 'link' => $message->schema_name, 'photo' => $message->photo, 'sitename' => $message->sitename, 'name' => ''];
                        Mail::send('email.default', $data, function ($m) use ($message) {
                            $m->from('no-reply@shulesoft.com', $message->sitename);
                            $m->to($message->email)->subject($message->subject);
                        });
                        if (count(Mail::failures()) > 0) {
                            DB::update('update ' . $message->schema_name . '.email set status=0 WHERE email_id=' . $message->email_id);
                        } else {
                            if ($message->email == 'inetscompany@gmail.com') {
                                DB::table($message->schema_name . '.email')->where('email_id', $message->email_id)->delete();
                            } else {
                                DB::update('update ' . $message->schema_name . '.email set status=1 WHERE email_id=' . $message->email_id);
                            }
                        }
                    } catch (\Exception $e) {
                        // error occur
                        //DB::table('public.sms')->insert(['body'=>'email error'.$e->getMessage(),'status'=>0,'phone_number'=>'0655406004','type'=>0]);
                        echo 'something is not write' . $e->getMessage();
                    }
                } else {
//skip all emails with ShuleSoft title
//skip all invalid emails
                    DB::update('update ' . $message->schema_name . '.email set status=1 WHERE email_id=' . $message->email_id);
                }
//$this->updateEmailConfig();
            }
        }
    }

}
