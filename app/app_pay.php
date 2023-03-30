<?php

//composer require zepson/zepsonpay-php

require "../vendor/autoload.php";
use Zepson\ZepsonpaySDK\ZepsonPay;

    $api_key = "YOUR_ZEPSONPAY_API_KEY";
    $api_secret = "YOUR_ZEPSONPAY_API_SECRET";
    $environment = "android"; //sandbox, produciton, zepsonpay and android. currently support android (v1.0)
    
    //creating instance of zepsonpay class.
    $zp = new Zepson\ZepsonpaySDK\ZepsonPay($api_key, $api_secret, $environment);

  //  Make payment - To complete payment , the parameters in the example are required. Make payment can sometimes be reffered to us Collection.

    $data = [
        'amount' => 100,
        'purpose' => 'For testing purposes',
        'ext_trxn_reff' => '1JF61RJWOK', //for android transaction this is equal to operators transaction id received after payment
        'phone' => '0688950846', //customer phone
        'operator' => 'vodacom', //operator to charge from
        'device' => '00000000-0000-0000-6da8-08a4x40d4b97' // only for android transactions obtained after registering device in gateway.zepsonsms.co.tz
    ];

    //make payment
    $response = $zp->makePayment($data);

    //Transaction enquiry(Check transaction status)
    $data = [
        'ext_trxn_reff' => '1JF61RJWOK', //for android transaction this is equal to operators transaction id received after payment
    ];
    $response = $zp->paymentStatus($data);

    //check if payment is successfull
        $zp->isPaymentSuccess();
    //get full transaction response as array
        $zp->getFullResponseArray();
    //get full transaction response as Json
        $zp->getFullResponseJson();
    //get transaction ID
        $zp->getTransactionId();
    //get external transaction ID
        $zp->getExternalTransactionId();
    //get Response message
        $zp->getMessage();
    //get response transaction message
        $zp->getTransactionMessage();
    //get errors
        $zp->getErrors();


$data = [
    'amount' => 100,
    'purpose' => 'purpose',
    'ext_trxn_reff' => '9JF681RJWOK',
    'phone' => '0688950846',
    'operator' => 'vodacom',
    'device' => '00000000-0000-0000-6da8-08a4c30f4b97'

];
// $payment = $zp->makePayment($data);
// $status = $payment->getTransactionId();

$response = $zp->paymentStatus($data);
$status  = $response->getMessage();
 
print_r($status);

//Example request: Collect payment

    function collection(){
        $client = new \GuzzleHttp\Client();
        $response = $client->post(
            'https://zepsonpay.com/api/v1/collection',
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
                'json' => [
                    'amount' => '500',
                    'purpose' => 'Test payment',
                    'operator' => 'vodacom',
                    'phone' => '07********',
                    'ext_trxn_reff' => 'dasihusdfwefdhfd',
                    'api_key' => '10c*7ea9-7062-****-a493-29785198b7b3',
                    'api_secret' => '91abdb2f-****-4e6c-****-dec888335f74',
                    'environment' => 'sandbox,zepsonpay or production',
                ],
            ]
        );
        $body = $response->getBody();
        print_r(json_decode((string) $body));
// Example response (200):
  /*      {
            "success": true,
            "message": "transaction is being processed",
            "code" => "ZPPENDING",
            "data": {
            "transaction_id": "da7f4d8-c5fd-442d-b27d-0a6c086840ca",
            "ext_trxn_reff": "EXTERNAL-REF-1234",
            "amount": "500",
            "message": "transaction is being processed",
            },
        */

    }

 function collectionStatus(){
    // Example request: Collection status by ext_trxn_reff

    $client = new \GuzzleHttp\Client();

    $response = $client->get(
        'https://zepsonpay.com/api/v1/collection/status',
        [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Accept:' => 'application/json',
                'Content-Type:' => 'application/json',
            ],
            'json' => [
                'ext_trxn_reff' => '12b47a5b-1d1a-4d72-bbf1-ea75fd69af19',
                'environment' => 'production',
                'api_key' => '10c87ea9-7062-4dbf-a493-29785198b7b3',
                'api_secret' => '91abdb2f-fcfe-4e6c-a8b8-dec888335f74',
            ],
        ]
    );
    $body = $response->getBody();
    print_r(json_decode((string) $body));
    /* Response
    {
        "success": true,
        "message": "Transaction status",
        "code"   : "ZPSUCCESS",
        "data": {
            "transaction_id": "98bad667-5bb2-48ff-a2f8-193fb94c5680",
            "ext_trxn_reff": "7fd3ee63fe8d47f699a4864f99cf7835",
        },
        "errors": []
    }

    */
    }

    function desbursement(){

    $client = new \GuzzleHttp\Client();

    //Example request:    Customer to Business

    $client = new \GuzzleHttp\Client();
    $response = $client->post(
        'https://zepsonpay.com/api/v1/desbursement',
        [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            'json' => [
                'amount' => '500',
                'operator' => 'vodacom, airtel, tigo or halotel',
                'phone' => '0752771650',
                'ext_trxn_reff' => '10c87ea9-7062-4dbf-a493-29785198b7b3',
                'api_key' => '10c87ea9-7062-4dbf-a493-29785198b7b3',
                'api_secret' => '91abdb2f-fcfe-4e6c-a8b8-dec888335f74',
                'environment' => 'production, sandbox or zepsonpay',
            ],
        ]
    );
    $body = $response->getBody();
    print_r(json_decode((string) $body));
   /*
        Example response (200):
        
        
        {
        "success": true,
        "message": "The balance in account {2} of account type {1} of identity {0} is insufficient for the transaction.",
        "code": "ZPFAILED"
        "data": {
        "transaction_id": 1663580139,
        "ext_trxn_reff": "asdfweSDfedsfasdfaewfsdfdsaD",
        "message": "Transaction Failed"
        },
        "errors": []
        }
    */
    }



  //  Example request:    Disbursement Status
function desbursementStatus(){
$client = new \GuzzleHttp\Client();
$response = $client->get(
    'https://zepsonpay.com/api/v1/desbursement/status',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Accept:' => 'application/json',
            'Content-Type:' => 'application/json',
        ],
        'json' => [
            'ext_trxn_reff' => '12b47a5b-1d1a-4d72-bbf1-ea75fd69af19',
            'environment' => 'production',
            'api_key' => '10c87ea9-7062-4dbf-a493-29785198b7b3',
            'api_secret' => '91abdb2f-fcfe-4e6c-a8b8-dec888335f74',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));

    /*
        Example response (200):
        {
            "success": true,
            "message": "Desbursement status message",
            "code"   : "ZPSUCCESS",
            "data": {
                    "transaction_id": 1663580139,
                    "ext_trxn_reff": "asdfweSDfedsfasdfaewfsdfdsaD",
                    "message": "transaction is being processed"

                }
            },
            "errors": []
        }
    */
}

function refund(){
    // Example request: Refund/Reversal Transaction

        $client = new \GuzzleHttp\Client();
        $response = $client->post(
            'https://zepsonpay.com/api/v1/refund',
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'Accept:' => 'application/json',
                    'Content-Type:' => 'application/json',
                ],
                'json' => [
                    'trxn_id' => '12b47a5b-1d1a-4d72-bbf1-ea75fd69af19',
                    'reason' => 'Refund for wrong payment',
                    'environment' => 'production',
                    'api_key' => '10c87ea9-7062-4dbf-a493-29785198b7b3',
                    'api_secret' => '91abdb2f-fcfe-4e6c-a8b8-dec888335f74',
                    'ext_trxn_reff' => '7fd3ee63fe8d47f699a4864f99cf7835',
                ],
            ]
        );
        $body = $response->getBody();
        print_r(json_decode((string) $body));

/*
Example response (200):
    {
    "success": true,
    "message": "Transaction Reversed Successfully",
    "code"   : "ZPSUCCESS",
    "data": {
            "transaction_id": "98bad667-5bb2-48ff-a2f8-193fb94c5680",
            "ext_trxn_reff": "7fd3ee63fe8d47f699a4864f99cf7835",
        },
*/

}