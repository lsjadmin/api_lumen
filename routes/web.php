<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});


 $router->post('/test','Test\TestController@encrypt'); //对称加密
 $router->post('/openssl','Test\TestController@openssl'); //非对称加密
 $router->post('/sgin','Test\TestController@sgin'); //验证签名

 $router->post('/loginadd','Test\TestController@loginadd'); //接受注册信息

 $router->post('/logina','Test\TestController@logina'); //登录执行

 $router->get('/redis','Test\TestController@redis');  //测试redis
 $router->get('/script','Test\TestController@script');  //测试script 路径解决跨域

//hbui
$router->post('/reg','User\UserController@reg');  //接受注册信息
$router->post('/login','User\UserController@login');  //接受登陆信息
$router->get('/user','User\UserController@user');  //个人中心

$router->get('/aa','User\UserController@aa');  //测试中间件

