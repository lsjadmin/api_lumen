<?php

namespace App\Http\Controllers\User;
header("Access-Control-Allow-Origin: *");
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
class UserController extends Controller
{
    //接受注册信息
    public function reg(){
        $data=$_POST;
        dd($data);
    }
}
?>