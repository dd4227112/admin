<?php

namespace App\Http\Controllers;

use App\Jobs\PushSMS;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

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
            '||name||', '||username||'
        );
        $sms = preg_replace($patterns, $replacements, $message);
        foreach (explode(',', $list_schema) as $value) {
        echo    $sql = "insert into $value.sms (body,users_id,type,phone_number) select '{$sms}',id,'0',phone from admin.all_users WHERE schema_name::text IN ($value) AND usertype !='Student' {$in_array} AND phone is not NULL "; exit;
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
        //
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
                if ($schema->table_schema != 'public') {
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
        }
        $usertypes = DB::select('select distinct usertype from admin.all_users');
        return view('message.updates', compact('usertypes', 'message_success'));
    }

    public function feedback() {
        $feedbacks = DB::table('constant.feedback')->orderBy('id', 'desc')->paginate();
        return view('message.feedback', compact('feedbacks'));
    }

}
