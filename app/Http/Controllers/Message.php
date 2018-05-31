<?php

namespace App\Http\Controllers;

use App\Jobs\PushSMS;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;

class Message extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
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

        $usr = request('usertype');
        $usr_type = '';
        if (count($usr) > 0) {
            foreach ($usr as $val) {
                $usr_type .= "'" . $val . "',";
            }
            $type = rtrim($usr_type, ',');
            $in_array = " AND usertype IN (" . $type . ")";
        } else {
            $in_array = '';
        }
        $patterns = array(
            '/#name/i', '/#username/i'
        );
        $replacements = array(
            "'||name||'", "'||username||'"
        );
        $sms = preg_replace($patterns, $replacements, $message);
        foreach (explode(',', $list_schema) as $schema) {
            $value = str_replace("'", null, $schema);
            $sql = "insert into $value.sms (body,user_id,type,phone_number) select '{$sms}',id,'0',phone from admin.all_users WHERE schema_name::text IN ($schema) AND usertype !='Student' {$in_array} AND  phone is not NULL  AND \"table\" !='setting' ";
            DB::statement($sql);
        }

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
    
    public function createUpdate() {
         if ($_POST) {
            $this->validate(request(), [
                'for' => 'required',
                'message' => 'required',
                'release_date' => 'date'
            ]);
            DB::table('admin.updates')->insert(array_merge(request()->except(['_token', '_wysihtml5_mode', 'for']), ['for' => implode(',', request('for'))]));
            $message_success = 'Update recorded successfully';
            $schemas = (new \App\Http\Controllers\DatabaseController())->loadSchema();
            foreach ($schemas as $schema) {
                if (!in_array($schema->table_schema, ['public','constant','admin','dodoso','app'])) {
                    $users = DB::table($schema->table_schema . '.users')->whereIn('usertype', request('for'))->get();
                    foreach ($users as $user) {
                        if (filter_var($user->email, FILTER_VALIDATE_EMAIL) && !preg_match('/shulesoft/', $user->email)) {
                            DB::table($schema->table_schema . '.email')->insert(array(
                                'email' => $user->email,
                                'body' => request('message'),
                                'subject' => 'ShuleSoft Latest Updates: ' . request('release_date'),
                                'user_id' => $user->id,
                                'table' => $user->table
                            ));
                        }
                    }
                }
            }
            return redirect('message/shulesoft');
        }
        $this->data['usertypes'] = DB::select('select distinct usertype from admin.all_users');
        return view('message.add_updates', $this->data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
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
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($type, $id = null, $schema = null) {
        if ($type == 'email' && (int) $id > 0 && strlen($schema) > 3) {
            DB::statement('delete  from ' . $schema . '.' . $type . ' where email_id=' . $id);
            return redirect(url('message/show/email'));
        }
    }

    public function shulesoft() {
        $message_success = '';
       
        $usertypes = DB::select('select distinct usertype from admin.all_users');
        return view('message.updates', compact('usertypes', 'message_success'));
    }

    public function feedback() {
        $feedbacks = \App\Model\Feedback::orderBy('id', 'desc')->paginate();
        return view('message.feedback', compact('feedbacks'));
    }

    public function reply() {
        $message = request('message');
        $message_id = request('message_id');
        \App\Model\Feedback_reply::create(['feedback_id' => $message_id, 'message' => $message, 'user_id' => Auth::user()->id]);
        $feedback = \App\Model\Feedback::find($message_id);
    
        $user = DB::table('admin.all_users')->where('id', $feedback->user_id)->where('table', $feedback->table)->where('schema_name', str_replace('.', NULL,$feedback->schema))->first();
        if(count($user)==1){
        DB::table('public.sms')->insert(['body' => $message, 'phone_number' => $user->phone, 'type' => 0]);
        
        $reply_message = '<div>'
                . '<p><b>Your Message: </b> ' . $feedback->message . '</p><br/><br/>' . $message . '</div>';
        DB::table('public.email')->insert(['body' => $reply_message, 'user_id' => $feedback->user_id,'subject'=> 'ShuleSoft Feedback Reply', 'email' => $user->email]);
        echo 'Message and Email sent';
        }else{
            echo 'user not found';
        }
    }

}
