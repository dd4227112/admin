<?php

namespace App\Console\Commands;

// use App\Models\Log;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class SendQuickSms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:quicksms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send quick sms';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return false;
        $schemas = DB::select("select  a.client_id, sum(coalesce( a.quantity, 0)) as balance, b.username as schema_name , b.is_new_version from admin.addons_payments a, admin.clients b  where a.client_id =b.id and a.addon_id =2   group by a.client_id, b.username, b.is_new_version  having sum(coalesce( a.quantity, 0)) >0");
        $total_sms_sent = 0;
        // find all customer subscribed to quick sms with their sms balance.
        
        foreach ($schemas as $schema_) {
            $schema = $schema_->schema_name;
            if ($schema_->is_new_version ==1) {
                $messages = DB::select("select a.phone_number as phone, a.body  as body, a.sms_id as id, a.sent_from from shulesoft.sms a where a.status = 0 and a.type = 1 and a.schema_name ='".$schema."' order by priority DESC limit 10");
            }else {

            $messages = DB::select("select a.phone_number as phone, a.body  as body, a.sms_id as id, a.sent_from from " . $schema . ".sms a where a.status = 0 and a.type = 1 order by priority DESC limit 10");
            }

            $total_sms_sent += !empty($messages) ? count($messages) : 0;

            if (!empty($messages)) {
                foreach ($messages as $message) {

                    $beem = $this->beem_sms($message->phone, $message->body, $schema);
                    $return_code =json_decode($beem);                   
                    if($return_code->success ==1){
                        $sent_sms =$this->countSMS($message->body);

                        DB::select(" update admin.sms_balance set balance =balance - ".$sent_sms." where client_id =". $schema_->client_id);
                        DB::table("shulesoft.sms")->where('sms_id', $message->id)->update([
                            'status' => 1,
                            'return_code' => json_encode($beem),
                            'updated_at' => now()
                        ]);
                    }
                }
            }
        }
        Log::info('Quick SMS sent : Total ' . $total_sms_sent . chr(10));
        return 0;
    }
    function beem_sms($phone_number, $message, $schema) {
        if ($phone_number != '') {
            $secret_key = 'MDI2ZGVlMWExN2NlNzlkYzUyYWE2NTlhOGE0MjgyMDRmMjFlMDFjODkwYjU2NjA4OTY4NzZlY2Y3NGZjY2Y0Yw==';
            $api_key = '5e0b7f1a911dd411';

            // $schema = $schema_ == null ? str_replace('.', null, set_schema_name()) : $schema_;

            if ($schema == 'annagamazo') {
                $sender_name = 'ANNAGAMAZO';
            } elseif ($schema == 'rahma') {
                $sender_name = 'RAHMASCHOOL';
            } elseif ($schema == 'capricorninstitute') {
                $sender_name = 'CAPRICORN';
            } elseif ($schema == 'mgutwasec') {
                $sender_name = 'MGUTWA SECONDARY';
            } else {
                $sender_name = 'SHULESOFT';
            }

            // The data to send to the API
            $posthData = array(
                'source_addr' => $sender_name,
                'encoding' => 0,
                'schedule_time' => '',
                'message' => $message,
                'recipients' => [array('recipient_id' => '1', 'dest_addr' => str_replace('+', null, $phone_number))]
            );

            //.... Api url
            $Url = 'https://apisms.beem.africa/v1/send';
            // Setup cURL
            $ch = curl_init($Url);
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt_array($ch, array(
                CURLOPT_POST => TRUE,
                CURLOPT_RETURNTRANSFER => TRUE,
                CURLOPT_HTTPHEADER => array(
                    'Authorization:Basic ' . base64_encode("$api_key:$secret_key"),
                    'Content-Type: application/json'
                ),
                CURLOPT_POSTFIELDS => json_encode($posthData)
            ));

// Send the request
            $response = curl_exec($ch);
            // response of the POST request
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $responseBody = json_decode($response);
            curl_close($ch);

            if ($httpCode >= 200 && $httpCode < 300) {
                $return = $this->status_code('1701');
            } else {
                $return = $this->status_code(1700);
            }


            // Check for errors
        } else {
            $return = $this->status_code(1700);
        }

        return $return;
    }
    private function status_code($result) {

        switch ($result) {
            case '1701':
                $status = array(
                    'success' => 1,
                    'message' => 'Message sent successful'
                );
                break;
            case '1702':
                $status = array(
                    'success' => 0,
                    'message' => 'Invalid URL Error,one of the parameters was not provided or left blank'
                );
                break;
            case '1703':
                $status = array(
                    'success' => 0,
                    'message' => 'Invalid value'
                );
                break;
            case '1704':
                $status = array(
                    'success' => 0,
                    'message' => 'Invalid value type'
                );
                break;
            case '1705':
                $status = array(
                    'success' => 0,
                    'message' => 'Invalid message'
                );
                break;
            case '1706':
                $status = array(
                    'success' => 0,
                    'message' => 'Invalid destination'
                );
                break;
            case '1707':
                $status = array(
                    'success' => 0,
                    'message' => 'Invalid Source (Sender)'
                );
                break;
            case '1709':
                $status = array(
                    'success' => 0,
                    'message' => 'User validation failed'
                );
                break;
            case '1710':
                $status = array(
                    'success' => 0,
                    'message' => 'Internal error'
                );
                break;
            case '1025':
                $status = array(
                    'success' => 0,
                    'message' => 'Insufficient credit, contact sales@karibusms.com to recharge your account'
                );
                break;
            default :
                $status = array(
                    'success' => 0,
                    'message' => 'No format results specified'
                );
                break;
        }
        $code = array('code' => $result);
        $results = array_merge($status, $code);

        return json_encode($results);
    }
    function countSMS($message):int {
        $charLength = mb_strlen($message);
        if ($charLength >= 0 && $charLength <= 160) {
            return 1;
        } elseif ($charLength > 160 && $charLength <= 306) {
            return 2;
        } elseif ($charLength > 306 && $charLength <= 459) {
            return 3;
        } elseif ($charLength > 459 && $charLength <= 612) {
            return 4;
        } elseif ($charLength >= 612 && $charLength <= 765) {
            return 5;
        } elseif ($charLength > 765 && $charLength <= 918) {
            return 6;
        } elseif ($charLength > 918 && $charLength <= 1071) {
            return 7;
        } elseif ($charLength > 1071 && $charLength <= 1224) {
            return 8;
        } elseif ($charLength > 1224 && $charLength <= 1377) {
            return 9;
        } elseif ($charLength > 1377 && $charLength <= 1530) {
            return 10;
        } else {
            return 0;
        }
    }
}
