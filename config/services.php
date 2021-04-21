<?php

return [
    /*
      |--------------------------------------------------------------------------
      | Third Party Services
      |--------------------------------------------------------------------------
      |
      | This file is for storing the credentials for third party services such
      | as Mailgun, Postmark, AWS and more. This file provides the de facto
      | location for this type of information, allowing packages to have
      | a conventional file to locate the various service credentials.
      |
     */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],
     'ses' => [
        'key' => 'AKIAIALYMWHQGU3OTFQQ',
        'secret' => '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',
        'region' => 'us-west-2',
    ],
    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],
    'mandrill'=>['secret'=>'a53zTYM-xCEq1kIE7LATYQ'],
    'google'=>[
       'Client ID'=> '645217235571-uoega8r3kssjrfedrsvltm061186hped.apps.googleusercontent.com',
        'Mtk6XCDNoIEMvoXGziTAn0cG'
    ]
    
];
