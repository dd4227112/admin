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
Route::get('/que/{type?}','BackgroundController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::any('/database/upgrade','DatabaseController@upgrade');
Route::get('/database/{pg?}/{path?}','DatabaseController@index');
Route::any('/message/create','Message@create');
Route::any('/message/show/{op?}','Message@show');


Route::any('/market/{op?}','MarketingController@index');


Route::get('api/request','PaymentController@requests');

Route::get('/{pg?}/{path?}/{option?}','WebController@index');
Route::post('/{pg?}/{path?}/{option?}','WebController@tag');
