<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\library\karibusms;
use DB;
class PushSMS implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //recreate all_sms view in case schema has been  added
      //  DB::select("SELECT public.join_all_sms()");
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
   
    $messages=DB::select('select * from public.all_sms');
    if(!empty($messages)){
        foreach ($messages as $sms) {
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
