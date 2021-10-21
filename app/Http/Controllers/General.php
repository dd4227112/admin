<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

/**
 * used to perform all CRUD for general database tables
 */
class General extends Controller {

    public $table;

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

        ;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id = null) {
        $this->data['breadcrumb'] = array('title' => 'Whatsapp integrations','subtitle'=>'sms','head'=>'operations');
        $this->table = request()->segment(3);
        $this->data['headers'] = DB::table($this->table)->first();
        if ($_POST) {
 
            if($this->table=='whatsapp_integration'){
                
            }
            if ((int) request('edit') == 1) {
                DB::table($this->table)->where('id', request('id'))->update(request()->except('_token', 'edit', 'id'));
            } else {
                DB::table($this->table)->insert(request()->except('_token', 'edit'));
            }
        }
        $this->data['contents'] = DB::table($this->table)->get();
        return view('general.show', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit() {
        
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

}
