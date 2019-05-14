<?php

namespace App\Http\Controllers\Test;
//header("Access-Control-Allow-Origin: http://client.1809a.com");
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
class TestController extends Controller
{
    //对称加密
    public function encrypt(){
        // echo "a";
        $a=file_get_contents("php://input");
        // echo($a);
        $data=base64_decode($a);
        $method = 'AES-256-CBC';//加密方法
        $key = '123';//加密密钥
        $options = OPENSSL_RAW_DATA;//数据格式选项（可选）
        $iv='aassddffgghhjjkl';
        $result = openssl_decrypt($data, $method, $key, $options,$iv);
        dd($result);
    }
    //非对称加密
    public function openssl(){
        $op=file_get_contents("php://input");
        $data=base64_decode($op);
        $ka=openssl_pkey_get_public('file://'.storage_path('app/keys/public.pem')); //获取公钥(storage/app/keys/public.pem)
        openssl_public_decrypt($data,$dec_date,$ka);  //把解出来密码放到 $dec_date
        dd($dec_date);
    }
    //验证签名
    public function sgin(){
        $str=file_get_contents("php://input");
       // echo $str;die;
        $sign=base64_decode($_GET['sign']);
        //echo $sign;die;
        $ka=openssl_pkey_get_public('file://'.storage_path('app/keys/public.pem')); //获取公钥(storage/app/keys/public.pem)
        $rs=openssl_verify($str,$sign,$ka);
        dd($rs);
       
    }

    //接受注册信息
    public function loginadd(){
        $op=file_get_contents("php://input");
        $data=base64_decode($op);
        $ka=openssl_pkey_get_public('file://'.storage_path('app/keys/public.pem')); //获取公钥(storage/app/keys/public.pem)
        openssl_public_decrypt($data,$dec_date,$ka);  //把解出来密码放到 $dec_date
        //dd($dec_date);
       $info=json_decode($dec_date,true);
       //dd($info);
       $email=$info['email'];
        $where=[
            'email'=>$email
        ];
        $arr=DB::table('p_api')->where($where)->first();
        if($arr){
            $response=[
                'errno'=>'50003',
                'msg'=>'此邮箱已经存在'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
        $res=DB::table('p_api')->insert($info);
        if($res){
            $response=[
                'errno'=>'50001',
                'msg'=>'注册成功'
            ];
            echo json_encode($response,JSON_UNESCAPED_UNICODE);
            //header("Refresh:2;url=http://client.1809a.com/login/add");
        }else{
            $response=[
                'errno'=>'50002',
                'msg'=>'注册失败'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
    }

   
    //登录执行
    public function logina(){
        $op=file_get_contents("php://input");
        $data=base64_decode($op);
        $ka=openssl_pkey_get_public('file://'.storage_path('app/keys/public.pem')); //获取公钥(storage/app/keys/public.pem)
        openssl_public_decrypt($data,$dec_date,$ka);  //把解出来密码放到 $dec_date
        //dd($dec_date);
       $info=json_decode($dec_date,true);
       //dd($info);
       $email=$info['email'];
       $pass=$info['pass'];
       
        $where=[
            'email'=>$email
        ];
        $arr=DB::table('p_api')->where($where)->first();
        //dd($arr);
        if($pass==$arr->pass){
            echo "ok";    //登录成功后生成token,返回客户端，token有效期为一周

            $key="api_login_token.$arr->api_id";
            $token=$this->postlogintoken($arr->api_id);
            // echo $token;die;
             //Cache::put($key,$token,604800);
             Redis::set($key,$token);
             Redis::expire($key,604800);

            $response=[
                'errno'=>'0',
                'msg'=>'ok',
                'token'=>[
                    'token'=>$token,
                ]
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }else{
                $response=[
                    'errno'=>'50004',
                    'msg'=>'注册失败'
                ];
                die(json_encode($response,JSON_UNESCAPED_UNICODE));

        }

    }
    //获得token
    function postlogintoken($id){
        $range=Str::random(10);
        $token=substr(sha1(time().$id.$range),5,15); //sha1 计算字符串散值 （加密差不多）
        return $token;
    }

    //测试ajax请求接口
    public function ajax(){
      echo time();
       
       
    }

   
  
}
