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
        $api_id=$_GET['api_id'];
        echo $api_id;
//        if(empty($token)||empty($api_id)){
//            die('参数不同');
//        }
//        $key="lumen_login_token. $api_id";
//        $redis_token=Redis::get($key);
//        echo $redis_token;
        return $next($request);
    }
}
