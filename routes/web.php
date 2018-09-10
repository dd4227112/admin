<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */
//Route::get('/sms/push','Controller@sendSms');
Route::get('/testing', function() {
  
    $return = array(
        'message' => 'testing conents',
        'link' => 'www.karibusms.com/',
        'status' => 'success',
        'phone_number' => '255714825469'
    );
      $new_fields = array(
        'to' => 'e9AUSqAvdYE:APA91bGWpS-Otd6z2YumepO-VS37LROsLBIfgIOKA9WQAzGXF4BtCE5No5h_AIqukKZ4_6d2fZgk4rAzG7rrONnD0ilIKvkuyPumaB5RwxdHndTAkxN9-r9DqG7Jyk1Zpt3NbrirvDv36pUmOtaPeZTOUP22JJw2mw',
        'collapse_key' => 'type_a',
        'data' => array("Notice" => $return)
    );
   // dd($new_fields);

    $ch = curl_init();
    // Set the url, number of POST vars, POST data
    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Authorization: key=AAAAq5tzDr4:APA91bEj4PuLTBSFN8oyMq3mNaxbMc7jqvh361e20Ki9ZKfe8VJPC-24fZP13Utp7-TMP_U3v-6jNGvc3TDDrPZVt7y7VX7ock_Dt5gZnLhTB-lPZaE8oKTj6wzhi79C0tjwr8lY_5CtZ3AtUieL3qCB-l5OsMcWIA',
        'Content-Type: application/json'
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Disabling SSL Certificate support temporarly
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($new_fields));

    // Execute post
    $result = curl_exec($ch);

    curl_close($ch);
    dd($result);
});
Route::get('/que/{type?}', 'BackgroundController@index');
Route::group(['middleware' => ['guest']], function() {
    Auth::routes();
});

Route::get('/report', 'HomeController@dailyReport');
Route::any('/database/{pg?}/{path?}', 'DatabaseController@index');
Route::group(['middleware' => ['auth']], function() {
    Route::get('/management', 'UsersController@management');
     Route::get('/management/contact', 'UsersController@contact');
    Route::post('/searchInvoice', 'HomeController@invoiceSearch');

    Route::resource('users', 'UsersController');
    Route::resource('invoice', 'InvoiceController');
    Route::resource('roles', 'RolesController');
    Route::resource('payment', 'PaymentController');
    Route::resource('database', 'DatabaseController');
    Route::resource('home', 'HomeController');
    Route::resource('web', 'WebController');

    Route::get('/', 'HomeController@index');
    Route::any('/database/upgrade', 'DatabaseController@upgrade');
    Route::any('/database/{pg?}/{path?}', 'DatabaseController@index');
    Route::any('/message/createUpdate', 'Message@createUpdate');


    Route::any('/message/create', 'Message@create');
    Route::any('/message/shulesoft', 'Message@shulesoft');
    Route::any('/message/show/{op?}', 'Message@show');
    Route::any('/message/feedback', 'Message@feedback');
    Route::any('/message/reply', 'Message@reply');
    Route::any('/message/destroy/{op?}/{ops?}/{schema?}', 'Message@destroy');

    Route::post('/search', 'HomeController@search');
    Route::get('/search', 'HomeController@searchResult');
    Route::any('/market/{op?}', 'MarketingController@index');
    Route::get('/downloadMaterial/{type?}', 'MarketingController@downloadMaterial');
});

Route::get('api/request', 'PaymentController@requests');
Route::any('api/invoices/create', 'PaymentController@createInvoice');
Route::get('api/invoices/cancel', 'PaymentController@cancelInvoice');
Route::get('api/invoices/{option?}/{option2?}', 'PaymentController@invoices');
Route::get('api/payment/{option?}', 'PaymentController@payment');

Route::get('profile/update/{table?}/{user_id?}', 'ProfileController@updateProfile');
Route::get('profile/resend/{table?}/{user_id?}', 'ProfileController@resendMessage');
Route::get('profile/reset/{table?}/{user_id?}', 'ProfileController@resetPassword');
Route::get('profile/{schema?}/{table?}/{user_id?}', 'ProfileController@show');

Route::get('readLog/{path?}/{option?}', 'WebController@readLog');

//Route::get('/{pg?}/{path?}/{option?}/{option2?}/{option3?}/{option4?}/{option5?}', 'WebController@index');
//Route::post('/{pg?}/{path?}/{option?}', 'WebController@tag');

