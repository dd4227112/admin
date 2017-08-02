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
Route::get('/sms/push','Controller@sendSms');
Route::get('/que/{type?}','BackgroundController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
//Route::get('/{pg?}/{path?}','WebController@index');
Route::post('/{pg?}/{path?}','WebController@tag');