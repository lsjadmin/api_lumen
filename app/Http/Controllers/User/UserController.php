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
        $a=$_POST;
        //dd($a);
        $info=[
            'name'=>$a['username'],
            'email'=>$a['useremail'],
            'pass'=>$a['password']
        ];
        $res=DB::table('p_api')->insert($info);
        if($res){
            $arr=[
                'res'=>200,
                'msg'=>'注册成功'
            ];
            return json_encode($arr,JSON_UNESCAPED_UNICODE);
        }else{
            echo "no";
        }
    }
}
?>