<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use DB;

class Handler extends ExceptionHandler {

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];
    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */

    function createLog($e) {
        $line = @$e->getTrace()[0]['line'];
        $object = [
            'error_message' => $e->getMessage() . ' on line ' . $line . ' of file ' . @$e->getTrace()[0]['file'],
            'file' => @$e->getTrace()[0]['file'],
            'route' => createRoute(),
            "url" => url()->current(),
            'error_instance' => get_class($e),
            'request' => json_encode(request()->all()),
            "schema_name" => 'admin',
            'created_by' => session('id')
        ];
        if (!preg_match('/ValidatesRequests.php/i', @$e->getTrace()[0]['file']) || !preg_match('/Router.php/i', @$e->getTrace()[0]['file']) || !preg_match('/Pipeline.php/i', @$e->getTrace()[0]['file']) || !preg_match('/RouteCollection.php/i', @$e->getTrace()[0]['file']) ) {
             DB::table('admin.error_logs')->insert($object);
        }

        if (preg_match('/the database system is in recovery mode/i', $e->getMessage())) {
            $this->automateDatabaseRecovery();
        }
        $line = @$e->getTrace()[0]['line'];
        $err = "<br/><hr/><ul>\n";
        $err .= "\t<li>date time " . date('Y-M-d H:m', time()) . "</li>\n";
        $err .= "\t<li>Made By: " . session('id') . "</li>\n";
        $err .= "\t<li>usertype " . session('usertype') . "</li>\n";
        $err .= "\t<li>error msg: [" . $e->getCode() . '] ' . $e->getMessage() . ' on line ' . $line . ' of file ' . @$e->getTrace()[0]['file'] . "</li>\n";
        $err .= "\t<li>url: " . url()->current() . "</li>\n";
        $err .= "\t<li>Controller route: " . createRoute() . "</li>\n";
        $err .= "\t<li>Error from which host: " . gethostname() . "</li>\n";
        $err .= "\t<li>Error from username: " . session('username') . "</li>\n";
        $err .= "</ul>\n\n";

        $filename = 'admin_' . str_replace('-', '_', date('Y-M-d')) . '.html';

        error_log($err, 3, dirname(__FILE__) . "/../../storage/logs/" . $filename);

    //    $controller = new \App\Http\Controllers\Controller();
    //    $number ='255655007457'; 
    //    $chatId = $number . '@c.us';
    //    $controller->send_whatsapp_sms($chatId, $err);
    
    }

    public function sendLog($err) {
//        return DB::table("public.email")->insert(array(
//                    'body' => $err,
//                    'subject' => 'Error Occurred at Admin Panel ',
//                    'email' => 'inetscompany@gmail.com')
//        );
    }

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Throwable $exception) {
        $this->createLog($exception);
        parent::report($exception);
    }

  
    public function render($request, \Throwable $exception) {
        if ($exception instanceof \Illuminate\Session\TokenMismatchException) {
            return redirect()->back()->with('info', 'Your session expired, please login below to continue');
        }
     
        $this->createLog($exception);
        return parent::render($request, $exception);
    
    }

   

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception) {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
        return redirect()->guest(route('login'));
    }

    public function automateDatabaseRecovery() {
        // First Notify key people
        //try to see if we can restart our db here
        system("service postgresql-12 stop");
        system("service postgresql-12 start"); 
    }

}
