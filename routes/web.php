<?php

use Illuminate\Support\Facades\Route;


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


//\URL::forceScheme('https');
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


$bad_url = ['acme-challenge', 'rss', 'index.php', 'errors', 'phpR', 'apple-touch', 'assetlinks', '.php', 'public', '.tff', '.jpg'];
foreach ($bad_url as $value) {
    if (preg_match('/' . $value . '/', url()->current())) {
        exit;
    }
}
Route::get('/898uuhihdsdskj/live/{id}/{year}','Customer@usageAnalysis');

//list of schools that use particular bank eg NMB, CRDB etc
Route::get('/898uuhihdsdskjSB/live/','Customer@schoolBanks');

//list of branches
Route::get('/898uuhihdsdskjSB/live/branches','Customer@Banksbranches');

//Integration status
Route::get('/898uuhihdsdskjSB/live/intergration','Customer@IntegrationStatus');

//Integration bank status
Route::get('/898uuhihdsdskjSB/live/banks','Customer@BankStatus');

//Employees
Route::get('/898uuhihdsdskj/live/emp','Customer@Emplist');

//List of customers
Route::get('/898uuhihdsdskjCL/custmlist/{month}/{year}','Customer@customerslist');
//custom reports
Route::get('/898uuhihdsdskjdde/custrpt/{q}','Customer@customSqlReport');

Route::get('/898uuhihdsdskjddeqe/{q}','Customer@implementationReport');

Route::get('/898uuhihdsdskjdderer/send','Customer@event');

Route::get('/898uuhihdsdskjddereppok/expense','Customer@expenseRecords');

Auth::routes();
//Route::group(['middleware' => ['guest']], function() {
//    Auth::routes();
//});

//All users
Route::get('/898uuhihdsdskjdde/allusers','Customer@allusers');
Route::get('/fhodhkjkhdfhoidf/software/{q}','Software@tasksSummary');


//learning apis
Route::get('/898uuhihdsdskjddereppokusers','controller@userapi');
Route::get('/898uuhihdsdskjdderepposchools','controller@schoolapi');





Route::get('/epayment/i/{id}/{amount?}','Background@epayment');
Route::any('/create/epayment/{id}/{amount?}','Background@createEpayment');

Route::get('/customer/getschools/null', function() {
    if (strlen(request('term')) > 1) {
        $sql = "SELECT id::text,upper(name)|| ' '||upper(type) as name FROM admin.schools 
			WHERE lower(name) LIKE '%" . str_replace("'", null, strtolower(request('term'))) . "%'
			UNION ALL SELECT id||'c' as id, name||' -(Already Client)' from admin.clients WHERE lower(name) LIKE '%" . str_replace("'", null, strtolower(request('term'))) . "%' LIMIT 10";
        die(json_encode(DB::select($sql)));
    }
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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
// Route::get('/workshop', 'Workshop@index')->name('workshop');
// Route::post('/addregister', 'Workshop@addregister');
// Route::get('/register', 'Workshop@register')->name('register');
// Route::get('/user-details/{param1?}', 'Workshop@profile')->name('profile');


// // 
// Route::get('/application', 'Recruitments@index');
// Route::post('/addrecruiment', 'Recruitments@register'); 

// Route::get('/nda_form/{id}', 'Recruitments@nda');
// Route::post('/sendndaform','Recruitments@uploadnda');