<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//引入接口返回数据封装类
//use App\tools\ApiReturnData ;

class wechatCakind extends BaseController
{
    //+查询公章种类 swiper
    public function SelCachetKind(Request $request){
        if($request->isMethod('post')){

            $res=$this->rep->RepSelall();
            $k=0;
            $j=0;
            $arr=array();
            for($i=0;$i<count($res);$i++){
                $arr[$k][$j]=$res[$i];
                $j++;
                if(($i+1)%6==0){
                    $k++;
                }
            }
            if(count($arr)>0){
                return $this->success($arr);
            }else{
                return $this->fail(16002);
            }

        }
    }
    //+公章种类查询
    public function SelCachetKind2(Request $request){
        if($request->isMethod('post')){
            $makerid=$request->input('userid');
            $res=$this->rep->RepSelByOne('makerid',$makerid);
            if(count($res)>0){
               return $this->success($res);//接口返回数据封装在BaseController
            }else{
                return $this->fail(16002);
            }
        }
    }
    //+按cachetKindid查询公章种类信息
    public function SelCachetKindby(Request $request){
        if($request->isMethod('post')){
            $cachetkindid=$request->input('cachetkindid');
            $res=$this->rep->RepSelByOne('cachetKindid',$cachetkindid);
            if(count($res)>0){
                return $this->success($res);
            }else{
                return $this->fail(16002);
            }

        }
    }
    //+公章种类添加
    public function AddCachetKind(Request $request){
        if($request->isMethod('post')){
            $data['makerid']=$request->input('userid');
            $data['cakindname']=$request->input('cachetkindname');
            $data['cachetExplain']=$request->input('cachetexplain');
            $res=$this->rep->RepAddCakind($data);
            if($res){
                return $this->success($res);
            }else{
                return $this->fail(16003);
            }
        }
    }
    //+公章种类更新
    public function UpdateCachetkind(Request $request){
        if($request->isMethod('post')){
            $cachetkindid=$request->input('cachetkindid');
            $data['cakindname']=$request->input('cachetkindname');
            $data['cachetExplain']=$request->input('cachetexplain');
            $res=$this->rep->RepUpdateByone('cachetKindid',$cachetkindid,$data);
//            return $res;
            if($res){
                return $this->success($res);
            }else{
                return $this->fail(16005);
            }
        }
    }
    //+公章种类删除
    public function DelCachetkind(Request $request){
        if($request->isMethod('post')){
            $cachetkindid=$request->input('cachetkindid');

            $res=$this->rep->RepDeleteByOne('cachetKindid',$cachetkindid);
            if($res){
                 return $this->success($res);
            }else{
                return $this->fail(16004);
            }
        }
    }
}
