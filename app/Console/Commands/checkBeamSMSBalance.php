<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class checkBeamSMSBalance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'beem:sms_balance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        if(date('H:i') =='03:00'){
            $response =  $this->checkBalance();
            $response =json_decode($response, true);
            if ($response['data']['credit_balance'] <= 500) {
                $secret_key = 'MDI2ZGVlMWExN2NlNzlkYzUyYWE2NTlhOGE0MjgyMDRmMjFlMDFjODkwYjU2NjA4OTY4NzZlY2Y3NGZjY2Y0Yw==';
                $api_key = '5e0b7f1a911dd411';
                $sender_name = 'SHULESOFT';
                $phone ='255714825469';


                // The data to send to the API
                $posthData = array(
                    'source_addr' => $sender_name,
                    'encoding' => 0,
                    'schedule_time' => '',
                    'message' => "Salio la kifurushi chako cha Quick sms ni meseji ".$response['data']['credit_balance'].". Unakumbushwa kununua salio kabla ya meseji kuisha ili kuhakikisha huduma ya kutuma meseji inafanya kazi muda wote",
                    'recipients' => [array('recipient_id' => '1', 'dest_addr' =>$phone)]
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
                $response = curl_exec($ch);
            }
        }
        return 0;
    }
    public function checkBalance(){
        $username='5e0b7f1a911dd411';
        $password = 'MDI2ZGVlMWExN2NlNzlkYzUyYWE2NTlhOGE0MjgyMDRmMjFlMDFjODkwYjU2NjA4OTY4NzZlY2Y3NGZjY2Y0Yw==';
        
        $Url ='https://apisms.beem.africa/public/v1/vendors/balance';
        
        $ch = curl_init($Url);
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt_array($ch, array(
            CURLOPT_HTTPGET => TRUE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HTTPHEADER => array(
                'Authorization:Basic ' . base64_encode("$username:$password"),
                'Content-Type: application/json'
            ),
        ));
        // Send the request
        $response = curl_exec($ch);
        return $response;
    }
}
