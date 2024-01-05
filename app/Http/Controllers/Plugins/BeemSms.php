<?php

namespace App\Http\Controllers\Plugins;

use App\Http\Controllers\Controller;

class BeemSms extends Controller {

    private $secret_key = 'MDI2ZGVlMWExN2NlNzlkYzUyYWE2NTlhOGE0MjgyMDRmMjFlMDFjODkwYjU2NjA4OTY4NzZlY2Y3NGZjY2Y0Yw==';
    private $api_key = '5e0b7f1a911dd411';
    public $sender_name;
    

    function __construct($phone_number, $message, $schema_) {
        if ($phone_number != '') {
         $schema= strtolower(trim($schema_));
            if ($schema == 'annagamazo') {
                $sender_name = 'ANNAGAMAZO';
            } elseif ($schema == 'rahma') {
                $sender_name = 'RAHMASCHOOL';
            } elseif ($schema == 'capricorninstitute') {
                $sender_name = 'CAPRICORN';
            } elseif ($schema == 'mgutwasec') {
                $sender_name = 'MGUTWA SECONDARY';
            } elseif ($schema == 'victoria') {
                $sender_name = 'VICTORIA';
            } else {
                $sender_name = 'SHULESOFT';
            }
            // The data to send to the API
            $posthData = array(
                'source_addr' => $sender_name,
                'encoding' => 0,
                'schedule_time' => '',
                'message' => $message,
                'recipients' => [array('recipient_id' => '1',
                'dest_addr' => str_replace('+', null, $phone_number))]
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
                    'Authorization:Basic ' . base64_encode("$this->api_key:$this->secret_key"),
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

    function countSMS($message): int {
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
