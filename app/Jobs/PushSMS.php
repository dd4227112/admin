<?php

namespace App\Jobs;
namespace App\library\karibusms;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use karibusms;
use DB;
class PushSMS implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    private $messages;
    public function __construct($users=null)
    {
        if(request('message') !=null){
            $this->pushToJob($users,request('message'));
        }
        //recreate all_sms view in case schema has been  added
     $this->messages=DB::select('select * from public.all_sms');
    }


    function pushToJob($all_users,$message){

    $sms_record=array();
    $patterns = array('/#name/','/#username/');
    foreach ($all_users as $key => $user) {
        $replacements = array($user->name,$user->username);
        $sms = preg_replace($patterns, $replacements,$message);
        array_push($sms_record, array('body'=>$sms,'users_id' =>$user->id,'type' =>0,'phone_number'=>$user->phone));
    }
        return  DB::table('public.sms')->insertGetId($sms_record);
    }
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
   
    
    if(!empty($this->messages)){
        foreach ($this->messages as $sms) {
        define('API_KEY', $sms->api_key);
        define('API_SECRET', $sms->api_secret);

            $karibusms = new \karibusms();
            $karibusms->set_name(strtoupper($sms->schema_name));
            $karibusms->karibuSMSpro = $sms->type;
            $result = (object) json_decode($karibusms->send_sms($sms->phone_number, $sms->body));
            if ($result->success == 1) {
            DB::update('update ' . $sms->schema_name. '.sms set status=1 WHERE sms_id=' . $sms->sms_id);
            } else {
            DB::update('update ' . $sms->schema_name . '.sms set status=0 WHERE sms_id=' . $sms->sms_id);
            }
         }
    }
    }
}
