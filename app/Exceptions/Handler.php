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
            'created_by' => session('id'),
            'created_by_table' => session('table')
        ];
        if (!preg_match('/ValidatesRequests.php/i', @$e->getTrace()[0]['file']) || !preg_match('/Router.php/i', @$e->getTrace()[0]['file'])) {
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

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, \Throwable $exception) {
        if ($exception instanceof \Illuminate\Session\TokenMismatchException) {
            return redirect()->back()->with('info', 'Your session expired, please login below to continue');
        }
        // if ($exception->getStatusCode() === 500){
        //     return redirect()->guest(route('login'));
        // }
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
        
//        $karibusms = new \karibusms();
//        $karibusms->API_KEY = '25336025463';
//        $karibusms->API_SECRET = '1cb066306b7c36d3e665228a50ceca939609864d';
//        $karibusms->set_name(strtoupper('SHULESOFT'));
//        $karibusms->karibuSMSpro = 1;
//        $message = 'Database System is down and needs your immediate attention. Thanks';
//        (object) json_decode($karibusms->send_sms('255714825469', $message, 'SHULESOFT_recovery' . time()));
//
//        $data = ['content' => $message, 'link' => 'demo.',
//            'photo' => 'shulesoft.png', 'sitename' => 'ShuleSoft', 'name' => ''];
//        $mes = [];
//        $emails = ['email' => 'ephraim@shulesoft.com', 'email' => 'swillae1@gmail.com'];
//        foreach ($emails as $mail) {
//            \Mail::send('email.default', $data, function ($m) use ($mail) {
//                $m->from('noreply@shulesoft.com', 'ShuleSoft');
//                $m->to($mail['email'])->subject('Database System is down and needs your immediate attention');
//            });
//        }
//        $whatsapp_numbers = ['255714825469', '255744158016', '255684033878', '255652160360'];
//        foreach ($whatsapp_numbers as $number) {
//            $chat_id = $number.'@c.us';
//            $this->sendMessage($chat_id, $message);
//        }
        
        
    }

    public function sendMessage($chatId, $text) {
        $data = array('chatId' => $chatId, 'body' => $text);
        $this->sendRequest('message', $data);
    }

    public function sendRequest($method, $data) {
        $APIurl = 'https://eu4.chat-api.com/instance210904/';
        $token = 'h67ddfj89j8pm4o8';
        $url = $APIurl . $method . '?token=' . $token;
        if (is_array($data)) {
            $data = json_encode($data);
        }
        $options = stream_context_create(['http' => [
                'method' => 'POST',
                'header' => 'Content-type: application/json',
                'content' => $data]]);
        $response = file_get_contents($url, false, $options);
    }

}
