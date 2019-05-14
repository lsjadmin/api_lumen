<?php

namespace App\Http\Controllers\User;

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
                $token=$this->postlogintoken($res->api_id);
                $arr=[
                    'res'=>200,
                    'msg'=>'登陆成功',
                    'api_id'=>$res->api_id,
                    'data'=>[
                        'token'=>$token,
                    ]

                ];
                $key="lumen_login_token";
                Redis::set($key,$token);
                Redis::expire($key,604800);
                //dd($token);
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
    //个人中心(获得用户信息)
    public function user(){
        $id=$_GET['api_id'];
        //dd($id);
        $where=[
            'api_id'=>$id
        ];
        $res=DB::table('p_api')->where($where)->first();
       // dd($res);
        if($res){
            $arr=[
                'res'=>200,
                'msg'=>'获得用户信息成功',
                'name'=>$res->name,
                'email'=>$res->email
            ];
            return json_encode($arr,JSON_UNESCAPED_UNICODE);
        }else{
            $arr=[
                'res'=>40000,
                'msg'=>'失败',

            ];
            return json_encode($arr,JSON_UNESCAPED_UNICODE);
        }
    }
    //获得token
    public function postlogintoken($id){
        $str=Str::random(10);
        $token=substr(sha1(time().$id.$str),5,15);
        return $token;
    }
    //测试中间件
    public function aa(){
        echo "bb";
    }
}
?>