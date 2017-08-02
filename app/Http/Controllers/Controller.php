<?php
namespace App\Http\Controllers;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function sendSms(){
            $messages=DB::select('select * from public.all_sms');
        if(!empty($messages)){
        foreach ($messages as $sms) {
               // define('API_KEY', $sms->api_key);
               // define('API_SECRET', $sms->api_secret);

                    $karibusms = new \karibusms();
                    $karibusms->API_KEY=$sms->api_key;
                    $karibusms->API_SECRET=$sms->api_secret;
                    
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
