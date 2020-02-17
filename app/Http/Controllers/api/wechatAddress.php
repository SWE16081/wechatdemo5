<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class wechatAddress extends BaseController
{
    //添加收货地址
    public function addAddress(Request $request){
        if($request->isMethod('post')){
            $data['userid']=$request->input('userid');
            $data['name']=$request->input('nameinput');
            $data['phone']=$request->input('phoneinput');
            $data['city']=$request->input('cityinput');
            $data['address']=$request->input('addressinput');
            $data['checked']=$request->input('checked');
            //判断插入地址是否存在
            $name[0]='userid';
            $name[1]='name';
            $name[2]='phone';
            $name[3]='city';
            $name[4]='address';
            $value[0]=$data['userid'];
            $value[1]=$data['name'];
            $value[2]=$data['phone'];
            $value[3]=$data['city'];
            $value[4]=$data['address'];
            //查询此用户所有地址数量
            $cnt=$this->rep->RepSelBy('userid',$data['userid']);
            if(count($cnt)>0){
                //判断插入地址是否存在
                $res=$this->rep->RepSelByFive($name,$value);
                if(count($res)>0){
                    return json_encode(['res'=>'repeat']);
                }else{
                    //判断插入的checked是否为true
                    if($data['checked']){//修改其他的checked为false
                        $test['checked']=false;
                        $res2=$this->rep->RepUpdateByone('userid',$data['userid'],$test);
                        if($res2){//更新成功
                            $res3=$this->rep->RepAddAddress($data);
                            if($res3){
                                return $this->success();
                            }else{
                                return $this->fail(16003);
                            }
                        }else{
                            return $this->fail(16005);
                        }
                    }else{
                        $res3=$this->rep->RepAddAddress($data);
                        if($res3){
                            return $this->success();
                        }else{
                            return $this->fail(16003);
                        }
                    }
                }
            }else{
                $res3=$this->rep->RepAddAddress($data);
                if($res3){
                    return $this->success();
                }else{
                    return $this->fail(16003);
                }
            }

        }
    }
    //查询收货地址
    public function  SelAddress(Request $request)
    {
        if($request->isMethod('post')){
            $userid=$request->input('userid');
            $res=$this->rep->RepSelBy('userid',$userid);
            if(count($res)>0){//
                //将默认地址数据调到前面
                $temp=0;
                for($i=0;$i<count($res);$i++){
                    if($res[$i]['checked']){
                        $temp=$i;
                    }
                }
                $tem=$res[$temp];
                $res[$temp]=$res[0];
                $res[0]=$tem;
                    return $this->success($res);
            }
            else{//暂无数据
                return $this->fail(16002);
            }
        }
    }
    //按addressid查询
    public  function SelAddByid(Request $request){
        if($request->isMethod('post')){
            $addressid=$request->input('addressid');
            $res=$this->rep->RepSelBy('addressid',$addressid);
            if(count($res)>0){
                return $res[0];
            }else{
                return json_encode(['res'=>'error']);
            }
        }


    }

    //按addressid修改
    public function UpdataAddByid(Request $request){
        if($request->isMethod('post')){
            $userid=$request->input('userid');
            $addressid=$request->input('addressid');
            $data['name']=$request->input('nameinput');
            $data['phone']=$request->input('phoneinput');
            $data['city']=$request->input('cityinput');
            $data['address']=$request->input('addressinput');
            $data['checked']=$request->input('checked');
            if($data['checked']){//修改的checked为true将其他的checked设为false
                $test['checked']=false;
                $res2=$this->rep->RepUpdateByone('userid',$userid,$test);
                if($res2){//更新成功
                    $res3=$this->rep->RepUpdateByone('addressid',$addressid,$data);
                    if($res3){
                        return json_encode(['res'=>'success']);
                    }else{
                        return json_encode(['res'=>'error']);
                    }
                }else{
                    return json_encode(['res'=>'error']);
                }
            }
            else{
                $res3=$this->rep->RepUpdateByone('addressid',$addressid,$data);
                if($res3){
                    return json_encode(['res'=>'success']);
                }else{
                    return json_encode(['res'=>'error']);
                }
            }


        }
    }
    //按addressid删除
    public function DeleteAddByid(Request $request){
        if($request->isMethod('post')){
            $addressid=$request->input('addressid');
            $res=$this->rep->RepDeleteByOne('addressid',$addressid);
            if($res){
                return json_encode(['res'=>'success']);
            }else{
                return json_encode(['res'=>'error']);
            }
        }
    }
}
