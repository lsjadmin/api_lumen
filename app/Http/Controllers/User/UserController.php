<?php

namespace App\Http\Controllers\User;
header('Access-Control-Allow-Methods:OPTIONS,GET,PSOT');
header('Access-Control-Allow-Headers:x-requested-with');
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
class UserController extends Controller
{
    //接受注册信息
    public function reg(Request $request){
        $a=$request->input();
        //echo $a;die;
        $info=[
            'name'=>$a['username'],
            'email'=>$a['useremail'],
            'pass'=>$a['password']
        ];
       // $url="http://passport.1809a.com/user/reg";
        $url="http://passport.lianshijiea.com/user/reg";
        //初始化curl
        $ch=curl_init();
        //通过 curl_setopt() 设置需要的全部选项
        curl_setopt($ch, CURLOPT_URL,$url);
        //禁止浏览器输出 ，使用变量接收
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST,1);
        //把数据传输过去
        curl_setopt($ch,CURLOPT_POSTFIELDS,$info);
        //执行会话
        $res=curl_exec($ch);
        //结束一个会话
        curl_close($ch);
        echo $res;

    }
    //接受登陆信息
    public function login(Request $request){
        $arr=$request->input();
        //dd($arr);
       // $url="http://passport.1809a.com/user/login";
        $url="http://passport.lianshijiea.com/user/login";
        $res=$this->postcurl($url,$arr);
       echo $res;

    }
    //个人中心(获得用户信息)
    public function user(){
        $id=$_GET['api_id'];

        //$url="http://passport.1809a.com/user/user?id=$id";
        $url="http://passport.lianshijiea.com/user/user?id=$id";
        $ch=curl_init();
        //通过 curl_setopt() 设置需要的全部选项
        curl_setopt($ch, CURLOPT_URL,$url);
        //禁止浏览器输出 ，使用变量接收
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //执行会话
        $res=curl_exec($ch);

        echo $res;

        //dd($id);

    }
    //原生的jq
    public function jq(){
        echo "bb";
    }
    //curl方法
    function postcurl($url,$info){
        //初始化curl
        $ch=curl_init();
        //通过 curl_setopt() 设置需要的全部选项
        curl_setopt($ch, CURLOPT_URL,$url);
        //禁止浏览器输出 ，使用变量接收
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST,1);
        //把数据传输过去
        curl_setopt($ch,CURLOPT_POSTFIELDS,$info);
        //执行会话
        $res=curl_exec($ch);
        //结束一个会话
        curl_close($ch);
        return $res;
    }
    //curl get 方法
    function getcurl($url){
        $ch=curl_init();
        //通过 curl_setopt() 设置需要的全部选项
        curl_setopt($ch, CURLOPT_URL,$url);
        //禁止浏览器输出 ，使用变量接收
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //执行会话
        $res=curl_exec($ch);

        return $res;
    }
    //商品展示
    public function car(){
        $res=DB::table('goods')->get();
       // dd($arr);
       echo  json_encode($res,JSON_UNESCAPED_UNICODE);
    }
    //商品详情
    public function goodslist(){
        $g_id=$_GET['g_id'];
        //echo $g_id;
        $url='http://'.env('APP_AA')."/user/goodslist?id=$g_id";
        $res=$this->getcurl($url);
        echo $res;
    }
    //加入购物车
    public function cara(){
        $g_id=$_GET['g_id'];
        $api_id=$_GET['api_id'];
        $url='http://'.env('APP_AA')."/user/cara?id=$g_id&api_id=$api_id";
        $res=$this->getcurl($url);
        echo $res;
    }
    //购物车展示
    public function carlist(){
        $u_id=$_GET['u_id'];
       // echo $u_id;die;
        $url='http://'.env('APP_AA')."/user/carlist?u_id=$u_id";
        //echo $url;die;
        $res=$this->getcurl($url);
        echo $res;
    }
    //生成订单
    public function order(){
        $u_id=$_GET['u_id'];
        $price=$_GET['price'];
        $g_id=$_GET['g_id'];
        //echo $u_id;
        $url='http://'.env('APP_AA')."/user/order?u_id=$u_id&price=$price&g_id=$g_id";
        $res=$this->getcurl($url);
        echo $res;
    }
    //订单展示
    public function orderlist(){
        $u_id=$_GET['u_id'];
        //echo $u_id;die;
        $url='http://'.env('APP_AA')."/user/orderlist?u_id=$u_id";
        //echo $url;die;
        $res=$this->getcurl($url);
        echo $res;
    }


}
?>