<?php

namespace App\Http\Middleware;

use Closure;

class logintokenMiddleware
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
        $token=$_GET['token'];
        echo $token;
        return $next($request);
    }
}
