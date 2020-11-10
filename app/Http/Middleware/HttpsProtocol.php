<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Closure;

class HttpsProtocol {

    public function handle($request, Closure $next) {

        if ($request->secure()) {
//return redirect()->secure($request->getRequestUri());
            return Redirect::to(Request::path(), 302, array(), false);
        }

        return $next($request);
    }

}
