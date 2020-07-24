<?php

namespace App\Http\Controllers;

use App\Jobs\PushSMS;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;

class Marketing extends Controller {

     public function __construct() {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($pg = null) {
        //
        if (method_exists($this, $pg) && is_callable(array($this, $pg))) {
            return $this->$pg();
        } else {
            die('Page under construction');
        }
    }

    function faq() {
        if ((int) request('id') > 0 && request('action') == 'delete') {
            DB::table('faq')->where('id', request('id'))->delete();
        }
        $this->data['faqs'] = DB::table('faq')->get();
        return view('market.faq', $this->data);
    }

    function presentation() {
        return view('market.presentation');
    }

    function downloadMaterial($type) {

        if ($type == 'shulesoft_brochure') {
            $headers = array(
                'Content-Type: image/jpg',
            );
            $extension = 'jpg';
        } else {
            $headers = array(
                'Content-Type: application/pdf',
            );
            $extension = 'pdf';
        }
        return response()->download("resources/materials/$type.$extension", "$type.$extension", $headers);
    }

    function material() {
        return view('market.material');
    }

    function legal() {
        return view('market.legal');
    }

    function brand() {
        return view('market.brand');
    }

    public function allocation() {
        $this->data['school_types'] = DB::select('select type, COUNT(*) as count, 
SUM(COUNT(*)) over() as total_schools, 
(COUNT(*) * 1.0) / SUM(COUNT(*)) over() as percent
FROM admin.schools
group by type');
        $this->data['ownerships'] = DB::select('select ownership, COUNT(*) as count, 
SUM(COUNT(*)) over() as total_schools, 
(COUNT(*) * 1.0) / SUM(COUNT(*)) over() as percent
FROM admin.schools
group by ownership');
        // $this->data['schools']=DB::table('schools')->get();
        $this->data['regions'] = DB::select('select distinct region from admin.schools');
        if (request('region')) {
            $this->data['schools'] = DB::select("select * from admin.schools where region='" . request('region') . "'");
        } else {
            $this->data['schools'] = array();
        }
        return view('market.allocation', $this->data);
    }

    function getSchools() {
        return response()->json(DB::table('schools')->get());
    }

    function objective() {
        return view('market.objective');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        if (request('message') != '') {
            $script = $this->pushSMS();
            $message_success = 'Message sent ';
        } else {
            $script = '';
            $message_success = '';
        }
        $usertypes = DB::select('select distinct usertype from admin.all_users');
        return view('message.create', compact('script', 'usertypes', 'message_success'));
    }

    public function pushSMS($slave_schema = null) {
        $skip = request('skip');
        $database = new DatabaseController();
        $skip_schema = preg_match('/,/', $skip) ? explode(',', $skip) : array($skip);
        $db_schema = $database->loadSchema();
        $schemas = $slave_schema == null ? $db_schema : array($slave_schema);
        $q = '';
        $sch = '';

        foreach ($schemas as $key => $value) {
            $sch .= in_array($value->table_schema, $skip_schema) ? '' : "'" . $value->table_schema . "',";
        }
        $list_schema = rtrim($sch, ',');
        $message = request('message');
        if (request('usertype') == '' && strlen(request('userype')) < 3) {
            $in_array = '';
        } else {
            $usr = explode(',', request('usertype'));
            $usr_type = '';
            foreach ($usr as $value) {
                $usr_type .= "'" . $value . "',";
            }
            $type = rtrim($usr_type, ',');
            $in_array = " AND usertype IN (" . $type . ")";
        }
        $sql = "insert into public.sms (body,users_id,type,phone_number) select '{$message}',id,'0',phone from admin.all_users WHERE schema_name::text IN ($list_schema) AND usertype !='Student' {$in_array} AND phone is not NULL ";
        DB::statement($sql);
        return redirect('message/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    public function psms($param) {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
        return $id;
        $this->data['type'] = $id;
        $table = $id == 'sms' ? 'all_sms' : 'all_email';
        $this->data['messages'] = DB::select('select * from public.' . $table);
        return view('message.show', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function socialMedia() {
        $tab = request()->segment(3);
        $id = request()->segment(4);
        if ($tab == 'add') {
            if ($_POST) {
                $data = 
                    [
                        'user_id' => Auth::user()->id,
                        'type' => request('type'),
                        'category' => request('category'),
                        'note' => request('note'),
                        'title' => request('title')
                    ];
                //    dd($data);
                $post = \App\Models\MediaPost::create($data);
                      /*  $user = \App\Models\User::find($user_id);
                        $message = 'Hello ' . $user->firstname . '<br/>'
                                . 'A task has been allocated to you'
                                . '<ul>'
                                . '<li>Task: ' . $post->activity . '</li>'
                                . '<li>Type: ' . $post->taskType->name . '</li>'
                                . '<li>Deadline: ' . $post->date . '</li>'
                                . '</ul>';
                        $this->send_email($user->email, 'ShuleSoft Task Allocation', $message);
                        */                        
                        
                        
                if (count($post->id) > 0 && request('socialmedia_id')) {
                    $modules = request('socialmedia_id');
                    foreach ($modules as $key => $value) {
                        if (request('socialmedia_id')[$key] != '') {
                            $array = ['socialmedia_id' => request('socialmedia_id')[$key], 'post_id' => $post->id];
                            $check_unique = \App\Models\SocialMediaPost::where($array);
                            if (count($check_unique->first()) == 0) {
                                \App\Models\SocialMediaPost::create($array);
                            }
                        }
                    }
                }
                return redirect('Marketing/socialMedia')->with('success', 'success');
            }
            $this->data['socialmedia'] = \App\Models\SocialMedia::all();
            return view('market/addpost', $this->data);
        } elseif ($tab == 'show' && $id > 0) {
            $status = request()->segment(5);
            $this->data['published'] = $status;
            $this->data['post'] = \App\Models\MediaPost::find($id);
            return view('market/view_media', $this->data);
        } else {

            $this->data['posts'] = \App\Models\MediaPost::orderBy('id', 'DESC')->get();
            return view('market/medias', $this->data);
        }
    }

    public function socialMediaUpdate() {
            $media = request("socialmedia_id");
            $post = request("post_id");
            $type = request("type_id");
            $number = request("inputs");
            $now = date('Y=m-d H:i:s');
            if ((float) request("inputs") >= 0 && request("post_id") !='' && request("socialmedia_id") !='') {
                    \App\Models\SocialMediaPost::where('post_id', $post)->where('socialmedia_id', $media)->update([$type => $number, 'updated_at' => $now]);
                    echo "success";
                } else {
                    echo "Class can not be empty";
                }
        }

    public function addMinute() {

        if ($_POST) {

            $filename = '';
            if (!empty(request('attached'))) {
                $file = request()->file('attached');
                $filename = time() . rand(11, 8894) . '.' . $file->guessExtension();
                $filePath = base_path() . '/storage/uploads/images/';
                $file->move($filePath, $filename);
            }

            $array = [
                'title' => request('title'),
                'note' => request('note'),
                'date' => request('date'),
                'start_time' => request('start_time'),
                'end_time' => request('end_time'),
                'department_id' => request('department_id'),
                'attached' => $filename
            ];
            $minute = \App\Models\Minutes::create($array);
            if(count($minute->id) > 0 && request('user_id')){
                $modules = request('user_id');
               foreach($modules as $key => $value) {
                   if(request('user_id')[$key] != ''){
                $array = ['user_id' => request('user_id')[$key], 'minute_id' => $minute->id];
                $check_unique = \App\Models\MinuteUser::where($array);
                if (count($check_unique->first()) == 0) {
                    \App\Models\MinuteUser::create($array);
                }
            }
        }
    }
            return redirect('users/minutes')->with('success', request('title') . ' updated successfully');
        }
        $this->data['users'] = \App\Models\User::all();
        return view('users.minutes.addminute', $this->data);
    }

    public function showMinute() {
        $id = request()->segment(3);
        $this->data['minute'] = \App\Models\Minutes::where('id', $id)->first();
        return view('users.minutes.view_minute', $this->data);
    }

    public function deleteMinute() {
        $id = request()->segment(3);
        \App\Models\Minutes::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Minute Deleted');
    }
    public function tasks() {
        $this->data['users'] = 1;
        return view('users.tasks', $this->data);
    }

}
