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



Route::get('/que/{type?}', 'BackgroundController@index');
Route::group(['middleware' => ['guest']], function() {
    Auth::routes();
});

Route::get('/report', 'HomeController@dailyReport');
Route::any('/database/{pg?}/{path?}', 'DatabaseController@index');
Route::group(['middleware' => ['auth']], function() {
    Route::get('/management', 'UsersController@management');
    Route::get('/management/contact', 'UsersController@contact');
    Route::get('/management/banks/{pg?}/{path?}', 'UsersController@banks');
    Route::post('/searchInvoice', 'HomeController@invoiceSearch');
    Route::post('/user/changePhoto/{pg?}', 'UsersController@changePhoto');
    Route::any('support/guide/add/{?pg}','SupportController@guide');
    
    Route::resource('users', 'UsersController');
    Route::resource('invoice', 'InvoiceController');
    Route::resource('roles', 'RolesController');
    Route::resource('payment', 'PaymentController');
    Route::resource('database', 'DatabaseController');
    Route::resource('home', 'HomeController');
    Route::resource('web', 'WebController');
    Route::resource('exam', 'ExamController');
    Route::resource('support', 'SupportController');
    //Route::resource('market', 'MarketingController');

    Route::get('/', 'HomeController@index');
    Route::any('/database/upgrade', 'DatabaseController@upgrade');
    Route::any('/database/{pg?}/{path?}', 'DatabaseController@index');
    Route::any('/message/createUpdate', 'Message@createUpdate');


    Route::any('/message/create', 'Message@create');
    Route::any('/message/shulesoft', 'Message@shulesoft');
    Route::any('/message/show/{op?}', 'Message@show');
    Route::any('/message/feedback', 'Message@feedback');
    Route::any('/message/reply', 'Message@reply');
    Route::any('/message/showreply', 'Message@showreply');
    Route::any('/message/destroy/{op?}/{ops?}/{schema?}', 'Message@destroy');

    Route::post('/search', 'HomeController@search');
    Route::get('/search', 'HomeController@searchResult');
    Route::any('/market/{op?}', 'MarketingController@index');
    Route::get('/downloadMaterial/{type?}', 'MarketingController@downloadMaterial');
});

Route::get('api/request', 'PaymentController@requests');
Route::any('api/transactions', 'PaymentController@transactions');
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

if (createRoute() != NULL) {

    $route = explode('@', createRoute());

    $file = app_path() . DIRECTORY_SEPARATOR . 'Http' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . $route[0] . '.php';

    if (file_exists($file)) {
        Route::any('/{controller?}/{method?}/{param1?}/{param2?}/{param3?}/{param4?}/{param5?}/{param6?}/{param7?}', createRoute());
    }
}
