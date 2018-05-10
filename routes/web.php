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

Route::get('/que/{type?}', 'BackgroundController@index');
Route::group(['middleware' => ['guest']], function() {
    Auth::routes();
});
Route::get('/testing', 'HomeController@testing');
Route::get('/test', function() {
    $data = ['content' => 'testing sending email to users', 'link' => 'link', 'photo' => 'testing', 'sitename' =>'ugali', 'name' => ''];
    $message='none';
    Mail::send('email.default', $data, function ($m) use ($message) {
        $m->from('noreply@shulesoft.com', 'testing');
        $m->to('swillae1@gmail.com')->subject('tsti message');
    });
    dd(Mail::failures());
});


Route::group(['middleware' => ['auth']], function() {
    Route::get('/management', 'UsersController@management');
    Route::resource('users', 'UsersController');
    Route::resource('invoice', 'InvoiceController');
    Route::resource('roles', 'RolesController');
    Route::get('/home', 'HomeController@index')->name('home');
    Route::any('/database/upgrade', 'DatabaseController@upgrade');
    Route::get('/database/{pg?}/{path?}', 'DatabaseController@index');
    Route::any('/message/create', 'Message@create');
    Route::any('/message/shulesoft', 'Message@shulesoft');
    Route::any('/message/show/{op?}', 'Message@show');
    Route::any('/message/feedback', 'Message@feedback');
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


Route::get('/{pg?}/{path?}/{option?}/{option2?}/{option3?}/{option4?}/{option5?}', 'WebController@index');
Route::post('/{pg?}/{path?}/{option?}', 'WebController@tag');

