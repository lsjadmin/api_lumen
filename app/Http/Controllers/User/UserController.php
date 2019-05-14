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
//        dd($a);
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
            $arr=[
                'res'=>40001,
                'msg'=>'注册失败'
            ];
            return json_encode($arr,JSON_UNESCAPED_UNICODE);
        }
    }
    //接受登陆信息
    public function login(){
        $arr=$_POST;
        //dd($arr);
        $pass=$arr['password'];
        $where=[
            'email'=>$arr['useremail']
        ];
        $res=DB::table('p_api')->where($where)->first();
        if($res){
            if($pass==$res->pass){
                $arr=[
                    'res'=>200,
                    'msg'=>'登陆成功'
                ];
                return json_encode($arr,JSON_UNESCAPED_UNICODE);
            }else{
                $arr=[
                    'res'=>50001,
                    'msg'=>'登陆失败'
                ];
                return json_encode($arr,JSON_UNESCAPED_UNICODE);
            }
        }else{
            $arr=[
                'res'=>50000,
                'msg'=>'没有这个用户'
            ];
            return json_encode($arr,JSON_UNESCAPED_UNICODE);
        }
    }
}
?>