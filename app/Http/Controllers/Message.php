<?php

namespace App\Http\Controllers;
use App\Jobs\PushSMS;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class Message extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    if(request('message') !=''){
        $script=$this->pushSMS();
    }else{
        $script='';
    }
    return view('message.create',compact('script'));
    }


    public function pushSMS($slave_schema=null){
    $skip=request('skip');
    $database=new DatabaseController();
    $skip_schema= preg_match('/,/', $skip)? explode(',', $skip): array($skip);
    $db_schema =$database->loadSchema();
    $schemas = $slave_schema == null ?  $db_schema : array($slave_schema);
    $q='';
    $sch='';
    foreach ($schemas as $key => $value) {
       $sch="'".$value->table_schema."',";
    }
    $list_schema=rtrim($sch,',');
    $message=request('message');
    $all_users=DB::statement("insert into public.sms (body,users_id,type,phone_number) select '{$message}',id,'0',phone from public.all_users WHERE schema_name IN ($list_schema) AND usertype !='Student' AND phone is not NULL ");
    return redirect('message/create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
