<?php

namespace App\Http\Middleware;

use Closure;

class CorsMiddleware
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
         header('Access-Control-Allow-Origin: *');
         header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
         header('Access-Control-Allow-Headers: Content-Type, Accept, Authorization, X-Requested-With, X-XSRF-TOKEN, Application');
         return $next($request);
     }
}
