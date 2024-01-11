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

//Route::middleware(['blockIP'])->group(function () {


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

//try {
//
//    $link = 'demo.';
//    $data = ['content' => 'Testing', 'link' => $link,
//        'photo' => '', 'sitename' => 'makongo',
//        'name' => 'Something Useful'];
//    $message = (object) ['sitename' => 'makongo',
//                'email' => 'swillae1@gmail.com',
//                'subject' => 'Testing Message'
//    ];
//    $return = \Mail::send('email.default', $data, function ($m) use ($message) {
//                $m->from('noreply@shulesoft.africa', $message->sitename);
//                $m->to($message->email)->subject($message->subject);
//            });
//    print_r($return);
//} catch (\Exception $e) {
//    $return = $e->getMessage();
//     print_r($return);
//}
//exit;
$bad_url = ['acme-challenge', 'rss', 'index.php', 'errors', 'phpR', 'apple-touch', 'assetlinks', '.php', 'public', '.tff', '.jpg'];
foreach ($bad_url as $value) {
    if (preg_match('/' . $value . '/', url()->current())) {
        exit;
    }
}

$token = TOKEN_LIVE;
Route::get('/' . $token . '/live/{id}/{year}/{is_customer?}', 'Customer@usageAnalysis');

//list of schools that use particular bank eg NMB, CRDB etc
Route::get('/' . $token . '/live/', 'Customer@schoolBanks');

//list of branches
Route::get('/' . $token . '/live/branches', 'Customer@Banksbranches');

//Integration status
Route::get('/' . $token . '/live/intergration', 'Customer@IntegrationStatus');

//Integration bank status
Route::get('/' . $token . '/live/banks', 'Customer@BankStatus');

//Employees
Route::get('/' . $token . '/live/emp', 'Customer@Emplist');

//List of customers
Route::get('/' . $token . '/custmlist/{month}/{year}', 'Customer@customerslist');
//custom reports
Route::get('/' . $token . '/custrpt/{q}', 'Customer@customSqlReport');

Route::get('/' . $token . '/{q}', 'Customer@implementationReport');

Route::get('/' . $token . '/send', 'Customer@event');
//churn calculations
Route::get('/' . $token . '/{year}', 'Customer@churnReport');

Route::get('/' . $token . '/expense', 'Customer@expenseRecords');

Auth::routes();
//Route::group(['middleware' => ['guest']], function() {
//    Auth::routes();
//});
//All users
Route::get('/' . $token . '/allusers', 'Customer@allusers');
Route::get('/' . $token . '/software/{q}/{z?}', 'Software@tasksSummary');

Route::get('/epayment/i/{id}/{amount?}', 'Background@epayment');
Route::any('/create/epayment/{id}/{amount?}', 'Background@createEpayment');

Route::get('/customer/getschools/null', function () {
    if (strlen(request('term')) > 1) {
        $sql = "SELECT id::text,upper(name)|| ' '||upper(type) as name FROM admin.schools 
			WHERE lower(name) LIKE '%" . str_replace("'", null, strtolower(request('term'))) . "%'
			UNION ALL SELECT id||'c' as id, name||' -(Already Client)' from admin.clients WHERE lower(name) LIKE '%" . str_replace("'", null, strtolower(request('term'))) . "%' LIMIT 10";
        die(json_encode(DB::select($sql)));
    }
});

//dd(createRoute());

// if (createRoute() != NULL) {
//     $route = explode('@', createRoute());
//     $file = app_path() . DIRECTORY_SEPARATOR . 'Http' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . $route[0] . '.php';

//     if (file_exists($file)) {
//         Route::any('/{controller?}/{method?}/{param1?}/{param2?}/{param3?}/{param4?}/{param5?}/{param6?}/{param7?}', createRoute());

//     } else if ($route[0] == 'LoginController') {

//     }
// }

$routeInfo = createRoute();

if ($routeInfo !== null) {
    $file = app_path() . DIRECTORY_SEPARATOR . 'Http' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . $routeInfo['controller'] . '.php';

    if (file_exists($file)) {

        Route::any('/{controller?}/{method?}/{param1?}/{param2?}/{param3?}/{param4?}/{param5?}/{param6?}/{param7?}', $routeInfo['controller'] . '@' . $routeInfo['method']);
    } else {
        return view('errors.404');
    }
} else {
    return view('errors.404');
}


Auth::routes();
Route::get('/', 'Analyse@index')->name('/');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/workshop', 'Workshop@index')->name('workshop');
Route::get('/morepage/{id}', 'Workshop@morepage')->name('morepage');
Route::post('/addregister', 'Workshop@addregister');
Route::get('/register', 'Workshop@register')->name('register');
Route::get('/user-details/{param1?}', 'Workshop@profile')->name('profile');

// 
Route::get('/application', 'Recruitments@index');
Route::post('/addrecruiment', 'Recruitments@register');
Route::get('/nda_form/{id}', 'Recruitments@nda');
Route::post('/sendndaform', 'Recruitments@uploadnda');
Route::get('/migration', 'Software@migration');
Route::get('/fdjjfhnuvhr28y74890ffbwffwfjrrgowhfn', 'Recruitments@report');
// Example route configuration in routes/web.php
Route::post('update_target', 'Report@update_target');
Route::post('Analyse/fetch_school', 'Analyse@fetch_school');


//});
