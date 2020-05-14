<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use DB;

class LogRequest {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null) {
        $this->storeRequest();
        return $next($request);
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

    function storeRequest() {
        if (Auth::check()) {
            $id = count(Auth::user()) == 0 ? NULL : Auth::user()->id;
            $ip = $_SERVER['REMOTE_ADDR'] ?: ($_SERVER['HTTP_X_FORWARDED_FOR'] ?: $_SERVER['HTTP_CLIENT_IP']);
            $loc = $this->getIsp($ip);
            preg_match('/([a-z]*)@/i', request()->route()->getActionName(), $matches);
            $controllerName = str_replace('Controller', null, isset($matches[1]) ? $matches[1] : null);
            $url = request()->path() . '/' . $controllerName;
            $action=request('action')==null ?  request()->method() : request('action');
            if (count($loc) > 0 && is_object($loc)) {
                $log = array(
                    'url' => $url,
                    'user_agent' => $this->getBrowser(),
                    'platform' => $this->getOS(),
                    'platform_name' => gethostbyaddr($this->getIsp()->ip),
                    'country' => $this->getIsp()->country,
                    'city' => $this->getIsp()->city,
                    'source' => $this->getIsp()->ip,
                    'user_id' => $id,
                    'region' => $this->getIsp()->region,
                    'isp' => $this->getIsp()->org,
                    'action' => $action,
                    'is_ajax'=> request()->ajax(),
                    'content'=>json_encode(request()->all())
                );
            } else {
                $log = array(
                    'url' => $url,
                    'user_agent' => $this->getBrowser(),
                    'platform' => $this->getOS(),
                    'platform_name' => gethostbyaddr($ip),
                    'country' => '',
                    'city' => '',
                    'source' => $ip,
                    'user_id' => $id,
                    'region' => '',
                    'isp' => '',
                    'action' => $action,
                    'is_ajax'=> request()->ajax(),
                    'content'=>json_encode(request()->all())
                );
            }
            return DB::table('logs')->insert($log);
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

}
