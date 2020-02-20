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


$bad_url = ['acme-challenge', 'rss', 'index.php', 'errors', 'phpR', 'apple-touch', 'assetlinks', '.php','public','.tff','.jpg'];
foreach ($bad_url as $value) {
    if (preg_match('/' . $value . '/', url()->current())) {
        exit;
    }
}

Route::group(['middleware' => ['guest']], function() {
    Auth::routes();
});

//dd(createRoute());
if (createRoute() != NULL) {

    $route = explode('@', createRoute());

    $file = app_path() . DIRECTORY_SEPARATOR . 'Http' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . $route[0] . '.php';

    if (file_exists($file)) {
        Route::any('/{controller?}/{method?}/{param1?}/{param2?}/{param3?}/{param4?}/{param5?}/{param6?}/{param7?}', createRoute());
    } else if ($route[0] == 'LoginController') {
        
    }
}
