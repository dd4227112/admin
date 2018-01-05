<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ProfileController extends Controller {

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
        //
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($schema, $table, $user_id) {
        $this->data['schema'] = $schema;
        $this->data['table'] = $table;
        $this->data['user_id'] = $user_id;
        $this->data['user'] = \collect(DB::select('select * from ' . $schema . '.' . $table . ' where "' . $table . 'ID"=' . $user_id))->first();
        $this->data['logs'] = DB::select('select * from ' . $schema . '.log where "user_id"=' . $user_id . " and \"user\"='" . $this->data['user']->usertype . "'");
        $this->data['messages'] = \DB::select('select sms_id,body, user_id, created_at, phone_number,1 as is_sent  from ' . $schema . '.sms where user_id=' . $user_id . ' and "table"=\'' . $table . '\'  UNION ALL (select id as sms_id,message as body, device_id::integer as user_id, created_at,  "from" as phone_number,2 as is_sent from ' . $schema . '.reply_sms where user_id=' . $user_id . ' and "table"=\'' . $table . '\')');
        if ($table == 'parent') {
            $this->data['students'] = DB::select('select * from ' . $schema . '.student where "studentID" IN (SELECT student_id FROM ' . $schema . '.student_parents where parent_id=' . $user_id . ') and status=1');
        }

        return view('profile.show', $this->data);
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
    public function destroy($id) {
        //
    }

    public function resetPassword() {
        $schema = request('schema');
        $table = request('table');
        $user_id = request('user_id');
        $user = \collect(DB::select('select * from ' . $schema . '.' . $table . ' where "' . $table . 'ID"=' . $user_id))->first();
        $patterns = array(
            '/#name/', '/#username/', '/#default_password/'
        );
        $content = "Habari #name, Ili uweze kuingia kwenye system ya ShuleSoft, fungua hii link (https://" . $schema . ".shulesoft.com) , nenotumizi lako ni: #username na nenosiri la kuanzia ni : #default_password . Tafadhali kumbuka kubadili neno siri ukisha ingia kwenye system. Asante";

        if (preg_match('/default_password/', $content)) {
            //reset password to default to this user
            $pass = rand(1, 999) . substr(str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZ'), 0, 3) . rand(1, 999);
            $password = bcrypt($pass);
            DB::table($schema . '.' . $table)->where($table . 'ID', $user_id)->update(['password' => $password, 'default_password' => $pass]);
        } else {
            $pass = NULL;
        }
        $replacements = array(
            $user->name, $user->username, $pass
        );
        $sms = preg_replace($patterns, $replacements, $content);
        return DB::table($schema . '.sms')->insertGetId(array('phone_number' => $user->phone, 'body' => $sms, 'user_id' => $user_id, 'table' => $table, 'type' => 1), 'sms_id');
    }

    public function resendMessage() {
        $message_id = request('message_id');
        $schema = request('schema');
        DB::table($schema . '.sms')->where('sms_id', $message_id)->update(['status' => 0]);
        echo 'Message has been resent successfully';
    }

    public function updateProfile() {
        $schema = request('schema');
        $tag = request('tag');
        $table = request('table');
        $user_id = request('user_id');
        $value = request('val');
        DB::table($schema . '.'.$table)->where($table.'ID', $user_id)->update([$tag =>$value]);
        echo 'Records updated successfully ';
    }

}