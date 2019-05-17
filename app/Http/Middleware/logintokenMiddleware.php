<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;
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
        if(empty($_GET['token'])||empty($_GET['api_id'])){
            die('参数不同');
        }
        $token=$_GET['token'];
        //echo $token;
        $api_id=$_GET['api_id'];
        //echo $api_id;

        $key="lumen_login_token.$api_id";
        $redis_token=Redis::get($key);
        //echo $redis_token;
           if($redis_token){
               if($redis_token!==$token){
                   $arr=[
                       'res'=>50001,
                       'msg'=>'token不一致 登陆不成功'
                   ];
                   die(json_encode($arr,JSON_UNESCAPED_UNICODE));
               }
           }else{
               $arr=[
                   'res'=>50002,
                   'msg'=>'token不对请重新登陆'
               ];
              die(json_encode($arr,JSON_UNESCAPED_UNICODE));
           }
        return $next($request);
    }
}
