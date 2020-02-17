<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class wechatExpress extends BaseController
{
    //
    //查询快递价格
    public function expressSel(Request $request){
        if($request->isMethod("post")){
            $userid=$request->input('userid');
            //
            $res=$this->rep->RepSelBy('userid',$userid);
            if(count($res)>0){
                return $this->success($res);
            }else{
                return $this->fail(16002);
            }
        }
    }
    //添加快递价格
    public function expressAdd(Request $request){
        if($request->isMethod("post")){
            $data['userid']=$request->input('userid');
            $data['expressprice']=$request->input('expressprice');
            //
            $res=$this->rep->RepAddData($data);
            if($res){
                return $this->success($res);
            }else{
                return $this->fail(16003);
            }
        }
    }
    //添加快递价格
    public function expressUpdate(Request $request){
        if($request->isMethod("post")){
            $userid=$request->input('userid');
            $data['expressprice']=$request->input('expressprice');
            //
            $res=$this->rep->RepUpdateByone('userid',$userid,$data);
            if($res>0){
                return $this->success($res);
            }else{
                return $this->fail(16005);
            }
        }
    }


}
