<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use DB;
class WebController extends Controller
{
    public  $path='storage'.DIRECTORY_SEPARATOR.'logs'.DIRECTORY_SEPARATOR.'';
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index($pg=null,$sub=null)
    {

        if (Auth::check()){
             $page=$pg==null ? 'home' : $pg;
         }else{
             $page='login';
         }
         $data= ($pg ==null || in_array($page, array('login')))?'':$this->$pg($sub);
       return view(strtolower($page),compact('data','page'));
    }

    public function tag($pg=null,$sub=null){
        return $this->$pg($sub);
    }

   
    public function logs(){
        return scandir($this->path);
    }

    public function readLog($log_path){
        return file_get_contents($this->path.'/'.$log_path);
    }

    public function deleteLog($log_path){
      return  is_file($this->path.'/'.$log_path) ?
         unlink($this->path.'/'.$log_path) : 0;
    }

    public function logsummary(){
     // DB::statement("select admin.join_all('log')");
       return DB::select('select count(*) as total_logs,"schema_name"::text from admin.all_log group by "schema_name"::text');
    }
    
    public function analyse($schema) {
        $this->data['request_by_user']=DB::select('select count(*),"schema_name"::text,"user" from admin.all_log where "schema_name"::text=\''.$schema.'\' group by "schema_name"::text,"user"');
        $this->data['request_group']=DB::select('select count(*),"user_agent" from admin.all_log where "schema_name"::text=\''.$schema.'\' group by "user_agent"');
  
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
