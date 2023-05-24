<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;


class SendNormalSms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:normal-sms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send normal sms';

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
        $phone='255743414770';
        $api_key='788455074ffb68f3';
        $secret_key ='ZWUzM2M5YjVlMTljYmJjNTAxZmRjMjUxYzIyOGI2NGE3MTg4MjdkZjUxNzQxNGEwMzBmYzgwMTRiYTRmMDQ4NA==';
        $postData = array(
            'source_addr' => 'INFO',
            'encoding'=>0,
            'schedule_time' => '',
            'message' =>'This is the test sms',
            'recipients' => [array('recipient_id' => 1,'dest_addr'=>$phone)]
        );
        
        $Url ='https://apisms.beem.africa/v1/send';
        
        $ch = curl_init($Url);
        error_reporting(E_ALL);
        ini_set('display_errors', 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt_array($ch, array(
            CURLOPT_POST => TRUE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HTTPHEADER => array(
                'Authorization:Basic ' . base64_encode("$api_key:$secret_key"),
                'Content-Type: application/json'
            ),
            CURLOPT_POSTFIELDS => json_encode($postData)
        ));     
        $response = curl_exec($ch);
        $res=json_decode($response);
        Log::info($response);
        return 0;
    }
}
