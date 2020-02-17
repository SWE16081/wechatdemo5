<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\BaseController;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class wechatUsers extends BaseController
{
    //普通用户免注册登录
    public function wechatUserLogin(Request $request){
        if($request->isMethod('post')){
            //请求微信服务器 获取openid session_key
            $code=$request->input('code');
            $res=$this->getOpenid($code);
            $data['name']=$res['openid'];
            $data['password']=Hash::make('123456');
            $data['role']=1;
            $data['openid']=$res['openid'];
            $data['session_key']=$res['session_key'];

            //同一微信号重复注册检验
            //查看user表中是否已有该用户
            $name[0]='openid';
            $name[1]='role';
            $value[0]=$res['openid'];
            $value[1]=$data['role'];
            $res2=$this->rep->RepUserSelByTwo($name,$value);
            if(count($res2)==0){
                $res3=$this->rep->RepUserCreate($data);
                if($res3){
                    return json_encode(['res'=>'success','userid',$res3]);
                }else{
                    return json_encode(['res'=>'error']);
                }
            }else{
                return json_encode(['res'=>'success','userid'=>$res2[0]['id']]);
            }



        }
    }
    //微信商家注册
    public  function wechatRegister(Request $request){
        if($request->isMethod('post')){
            //获取wechat注册数据
            $data['name']=$request->input('name');
            $data['password']=Hash::make($request->input('password'));
            $data['role']=$request->input('role');
            //请求微信服务器 获取openid session_key
            $code=$request->input('code');
            $res=$this->getOpenid($code);
            $data['openid']=$res['openid'];
            $data['session_key']=$res['session_key'];
            //判断同一个微信号是否注册过
            $name[0]='openid';
            $name[1]='role';
            $value[0]=$res['openid'];
            $value[1]=$data['role'];
            $res2=$this->rep->RepUserSelByTwo($name,$value);
            if(count($res2)==0){
                //判断账号s是否已存在
                $res3=$this->rep->RepSelByOne('name',$data['name']);
                //注册的账号未被注册
                  if(count($res3)==0)
                  {
                    $res4=$this->rep->RepUserCreate($data);
                    if($res4){
                        return json_encode(['res'=>'success']);
                    }else{
                        return json_encode(['res'=>'error']);
                    }
                  }else{
                      return json_encode(['res'=>'namerepeat']);
                  }
            }else{
                return json_encode(['res'=>'wechatIDrepeat']);
            }


        }
    }
    //请求微信服务器获取openid
    public function getOpenid($code){
        $AppId=env('AppId');
        $AppSecret=env('AppSecret');
        $client=new Client();
        $res=$client->request('get','https://api.weixin.qq.com/sns/jscode2session',[
            'query'=> [
                'appid' => $AppId,
                'secret' => $AppSecret,
                'js_code' =>$code,
                'grant_type' => 'authorization_code',
            ]
        ]);
        $data=json_decode($res->getBody(),true);
        return $data;
    }
    //微信商家登录
    public function wechatMakerLogin(Request $request){
        if($request->isMethod('post')){
            $data['name']=$request->input('name');
            $data['password']=$request->input('password');
            //查询user表是否存在此商家账户
            $res=$this->rep->RepSelByOneFirst('name',$data['name']);
            if($res){
                //判断用户角色
                $role=$res['role'];
                if($role==2){
                    //按账号查询密码
                    $res3=$this->rep->RepSelByOne('name',$data['name'])[0];
                    if(Hash::check($data['password'],$res3['password'])){//判断密码是否正确
                        return json_encode(['res'=>'success','userid'=>$res3['id']]);
                    }else{
                        return json_encode(['res'=>'error']);
                    }
                }else{
                    return json_encode(['res'=>'you are not maker']);
                }

            }else{
                return json_encode(['res'=>'error']);
            }
        }
    }

    ////查看user表中是否已有该用户
    public function  wechatUserCheck($openid,$role){
        $res=$this->rep->RepUserSelExitByOpenid($openid,$role);
        if(count($res)==0){
            return true;
        }else{
            return false;
        }
    }

    //后台用户登录
    public function AdminLogin(Request $request){
        if($request->isMethod('post')){
            $data['name']=$request->input('username');
            $data['password']=$request->input('password');
            //
            $name[0]='name';
            $name[1]='password';
            $value[0]=$data['name'];
            $value[1]=$data['password'];
            $res=$this->rep->RepUserSelByTwo($name,$value);
            if($res){
                return json_encode(['res'=>'success']);
            }else{
                return json_encode(['res'=>'error']);
            }
        }
    }
}
