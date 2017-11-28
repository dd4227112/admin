<?php

namespace App\Http\Controllers;

use App\Jobs\PushSMS;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class MarketingController extends Controller {

    
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

    function downloadMaterial($type){

       if($type=='shulesoft_brochure'){
            $headers = array(
                'Content-Type: image/jpg',
            );
            $extension = 'jpg';
        }else{
            $headers = array(
                'Content-Type: application/pdf',
            );
            $extension = 'pdf';
        }
        return response()->download("resources/materials/$type.$extension","$type.$extension", $headers);


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
            $this->data['schools'] = DB::select("select * from admin.schools where region='". request('region')."'");
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
    public function destroy($id) {
        //
    }

}
