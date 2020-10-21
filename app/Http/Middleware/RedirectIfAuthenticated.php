<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use App;
use \App\Model\Tour;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
<<<<<<< HEAD
    public function handle($request, Closure $next, $guard = null) {
        App::setLocale(session('lang'));
        $this->logRequest();
        if (!in_array($this->createRoute(), $this->exceptionUri()) && empty($_POST)) {
            if (empty(session('id'))) {
                return $this->redirectToLogin($request);
=======
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return redirect(RouteServiceProvider::HOME);
>>>>>>> 5c3f8c012f4bd5882b41a39b4beb2e06ceb1f4f1
            }
        }

        return $next($request);
    }
<<<<<<< HEAD

    public function redirectToLogin($request) {
        if ($request->ajax()) {
            echo '<script type="text/javascript"> '
            . 'window.location.href="' . base_url() . '";'
            . '; </script>';
            exit;
        } else {

            return redirect('signin/index');
        }
    }

    public function checkRouteTour() {

        /* --- --- ---If the current route location is not in the database, add it --- --- */
        if (!empty(session('id'))) {
            $tours = Tour::where('location', '=', request()->segment(1) . '/' . $param2 = request()->segment(2))->first();
            if (!empty($tours)) {
                $param1 = request()->segment(1);
                Tour::insert([
                    'location' => $param1 . '/' . $param2,
                    'name' => ucwords($param1 . ' ' . $param2)]);
            }
        }
    }

    public function createRoute() {
        $url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
        $url_param = explode('/', $url);

        $controller = isset($url_param[2]) && !empty($url_param[2]) ? $url_param[2] : 'book';
        $method = isset($url_param[3]) && !empty($url_param[3]) ? $url_param[3] : 'index';
        $view = $method == 'view' ? 'show' : $method;

        return $controller == 'public' ? NULL : $controller . '/' . $view;
    }

    /**
     *
     */
    function exceptionUri() {
        return array(
            "signin/index",
            "signin/mpya",
            "reset/index",
            "reset/addcodes",
            "reset/password",
            "background/index",
            "help/index",
            "help/updates",
            'notice/feedback',
            "help/training_one",
            "payment/api",
            "report/quarter",
            "help",
            "api/init",
            "signin/signout",
            "admission/index",
            "admission/register",
            "admission/getClasses",
            'admission/citycall',
            "admission/payment",
            "admission/status",
            'admission/addPayment',
            "termsandprivacy/index",
            "install/newschool",
            "install/index",
            "install/database",
            "install/site",
            "install/done",
            "background/test",
            "background/pushEmail",
            "background/pushSMS",
            "Controller/changeLanguage",
            "background/sendEmailToBackground",
            'SmsController/store',
            'invoices/receipt'
        );
    }

    function getIsp($ip = null) {
        /*  if (@file_get_contents("http://ipinfo.io/{$ip}") === FALSE) {
          $details = FALSE;
          } else {
          $json = file_get_contents("http://ipinfo.io/{$ip}");
          $details = (object) json_decode($json, true);
          } */
        return FALSE;
    }

    function logRequest() {
        $id = session('id');
        $usertype = session('usertype');
        $ip = $_SERVER['REMOTE_ADDR'] ?: ($_SERVER['HTTP_X_FORWARDED_FOR'] ?: $_SERVER['HTTP_CLIENT_IP']);
        $loc = $this->getIsp($ip);
        $url_param = explode('/', $this->createRoute());
        $controller = isset($url_param[0]) ? $url_param[0] : 'book';
        $method = isset($url_param[1]) ? $url_param[1] : 'index';
        if (!empty($loc) && is_object($loc)) {
            $log = array(
                'url' => isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '',
                'user_agent' => $this->getBrowser(),
                'platform' => $this->getOS(),
                'platform_name' => gethostbyaddr($this->getIsp()->ip),
                'country' => $this->getIsp()->country,
                'city' => $this->getIsp()->city,
                'source' => $this->getIsp()->ip,
                'user' => $usertype,
                'user_id' => $id,
                'region' => $this->getIsp()->region,
                'isp' => $this->getIsp()->org,
                'table' => session('table'),
                'controller' => $controller,
                'method' => $method,
                'request' => strlen(request('password')) > 1 ? json_encode([]) : json_encode(request()->all()),
                'is_ajax' => request()->ajax()
            );
        } else {
            $log = array(
                'url' => isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '',
                'user_agent' => $this->getBrowser(),
                'platform' => $this->getOS(),
                'platform_name' => gethostbyaddr($ip),
                'country' => '',
                'city' => '',
                'source' => $ip,
                'user' => $usertype,
                'user_id' => $id,
                'region' => '',
                'isp' => '',
                'table' => session('table'),
                'controller' => $controller,
                'method' => $method,
                'request' => strlen(request('password')) > 1 ? json_encode([]) : json_encode(request()->all()),
                'is_ajax' => request()->ajax()
            );
        }
        $schema = str_replace('.', NULL, set_schema_name());
        $status = DB::select("SELECT distinct table_schema FROM INFORMATION_SCHEMA.TABLES WHERE lower(table_schema)='" . strtolower($schema) . "'");
        if (!empty($status)) {
            return DB::table('log')->insert($log);
        }
    }

    function getOS() {

        $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'unknown agent';

        $os_platform = "Unknown OS Platform";

        $os_array = array(
            '/windows nt 10/i' => 'Windows 10',
            '/windows nt 6.3/i' => 'Windows 8.1',
            '/windows nt 6.2/i' => 'Windows 8',
            '/windows nt 6.1/i' => 'Windows 7',
            '/windows nt 6.0/i' => 'Windows Vista',
            '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
            '/windows nt 5.1/i' => 'Windows XP',
            '/windows xp/i' => 'Windows XP',
            '/windows nt 5.0/i' => 'Windows 2000',
            '/windows me/i' => 'Windows ME',
            '/win98/i' => 'Windows 98',
            '/win95/i' => 'Windows 95',
            '/win16/i' => 'Windows 3.11',
            '/macintosh|mac os x/i' => 'Mac OS X',
            '/mac_powerpc/i' => 'Mac OS 9',
            '/linux/i' => 'Linux',
            '/ubuntu/i' => 'Ubuntu',
            '/iphone/i' => 'iPhone',
            '/ipod/i' => 'iPod',
            '/ipad/i' => 'iPad',
            '/android/i' => 'Android',
            '/blackberry/i' => 'BlackBerry',
            '/webos/i' => 'Mobile'
        );

        foreach ($os_array as $regex => $value) {

            if (preg_match($regex, $user_agent)) {
                $os_platform = $value;
            }
        }

        return $os_platform;
    }

    function getBrowser() {

        $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'unknown agent';

        $browser = "Unknown Browser";

        $browser_array = array(
            '/msie/i' => 'Internet Explorer',
            '/firefox/i' => 'Firefox',
            '/safari/i' => 'Safari',
            '/chrome/i' => 'Chrome',
            '/edge/i' => 'Edge',
            '/opera/i' => 'Opera',
            '/netscape/i' => 'Netscape',
            '/maxthon/i' => 'Maxthon',
            '/konqueror/i' => 'Konqueror',
            '/mobile/i' => 'Handheld Browser'
        );

        foreach ($browser_array as $regex => $value) {

            if (preg_match($regex, $user_agent)) {
                $browser = $value;
            }
        }

        return $browser;
    }

=======
>>>>>>> 5c3f8c012f4bd5882b41a39b4beb2e06ceb1f4f1
}
