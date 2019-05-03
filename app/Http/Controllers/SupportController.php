<?php

namespace App\Http\Controllers;

use App\Jobs\PushSMS;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use DB;

class SupportController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
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
        return view('support.faq', $this->data);
    }

    function presentation() {
        return view('market.presentation');
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        DB::table('constant.guides')->insert([
            'permission_id' => $request->permission_id,
            'content' => $request->content,
            'created_by' => Auth::user()->id,
            'language' => 'eng'
        ]);
        return redirect('support/guide');
    }

    public function psms($param) {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,$page=null) {
        //

        if (method_exists($this, $id) && is_callable(array($this, $id))) {
            return $this->$id();
        } else {
            die('Page under construction');
        }
    }

    public function getPermission() {
        $group_id = request('group_id');
        $permissions = \DB::table('constant.permission')->where('permission_group_id', $group_id)->get();
        foreach ($permissions as $value) {
            echo '<input type="radio" name="permission_id" value="' . $value->id . '" />' . $value->display_name;
        }
    }

    public function guide() {
        if (request()->segment(3) == 'delete') {
            \App\Model\Guide::find(request()->segment(4))->delete();
            return redirect()->back();
        } else if (request('pg') == 'add') {
            $this->data['guides'] =[];
            $page = 'add_guide';
        } else if (request()->segment(3) == 'edit') {
            $this->data['guide'] = \App\Model\Guide::find(request()->segment(4));
            $page = 'edit_guide';
        } else {
            $page = 'guide';
            $this->data['guides'] = \App\Model\Guide::all();
        }
        return view('support.' . $page, $this->data);
    }

    public function parents() {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $request = request()->all();
        \App\Model\Guide::find(request('guide_id'))->update($request);
        return redirect('support/guide');
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
    public function delete() {
        //
    }

}