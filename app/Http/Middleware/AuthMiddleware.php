<?php

namespace App\Http\Middleware;

use Closure;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $header = $request->header('Authorization');

        $token = $request->bearerToken();;

        if ($token == "6922618439" || $header == "6922618439") {
            return $next($request);
        }

        return response('Unauthorized.', 401);
    }
}
