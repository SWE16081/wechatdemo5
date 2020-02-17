<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\BaseController;
use App\Repositories\BaseRepository;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class wechatRemindinfo extends BaseController
{
    protected $orderrRep;
    public function __construct(BaseRepository $rep,OrderRepository $orderrRep)
    {
        parent::__construct($rep);
        $this->orderrRep=$orderrRep;
    }

    //买家提醒发货
    public function addReinfoToMaker(Request $request){
        if($request->isMethod('post')){
            $value[0]=$request->input('orderid');
            //查询订单表中商家id
            $value[1]=$this->orderrRep->RepSelBy('orderid',$value[0],'makerid')[0]['makerid'];
//            return $value[1];
            $name[0]='orderid';
            $name[1]='userid';
            //按orderid查询是否提醒过发货--提醒过过一段时间才可提醒
            $flage=$this->rep->RepSelByTwo($name,$value);
            $data['orderid']=$value[0];
            $data['userid']=$value[1];
            if(count($flage)>0){
                //根据提醒发货时间判断是否可以再次提醒
                $time=$flage[0]['created_at'];
                $nowtime=time();
                $interval=($nowtime-strtotime($time))/3600;
                $backinfo=$flage[0]['backinfo'];
                //商家回复信息为null
                if($interval>1){//提醒发货间隔超过1小时
                    if($backinfo==null){
                        $data['info']='买家提醒发货';
                        $res=$this->rep->RepAdddData($data);
                        if($res){
                            return $this->success($res);
                        }else{
                            return $this->fail(16003);
                        }
                    }else{
                        return $this->success($backinfo,16015);
                    }

                }
                else{
                    return $this->fail(16014);
                }
            }else{
                $data['info']='买家提醒发货';
                $res=$this->rep->RepAdddData($data);
                if($res){
                    return $this->success($res);
                }else{
                    return $this->fail(16003);
                }
            }

        }
    }

    //提醒发货信息查询
    public function selReinfo(Request $request){
        if($request->isMethod('post')){
            $value[0]=$request->input('userid');
            $value[1]=null;
            $name[0]='userid';
            $name[1]="backinfo";
            //查询
            $res=$this->rep->RepSelByTwo($name,$value);
            if(count($res)>0){
                return $this->success($res);
            }else{
                return $this->fail(16002);
            }

        }
    }

    //提醒发货信息分页查询
    public function selReinfoPage(Request $request){
        if($request->isMethod('get')){
            $value[0]=$request->input('userid');
            $value[1]=null;
            $name[0]='userid';
            $name[1]="backinfo";
            //查询
            $res=$this->rep->RepSelPageByTwo($name,$value);
            if(count($res)>0){
                return $this->success($res);
            }else{
                return $this->fail(16002);
            }

        }
    }
    //提醒发货信息查询
    public function selReinfolen(Request $request){
        if($request->isMethod('post')){
            $value[0]=$request->input('userid');
            $value[1]=null;
            $name[0]='userid';
            $name[1]="backinfo";
            //查询
            $res=$this->rep->RepSelByTwo($name,$value);
            if(count($res)>0){
                return $this->success(count($res));
            }else{
                return $this->fail(16002);
            }

        }
    }

    //商家回复信息
    public function addReinfoToUser(request $request){
        if($request->isMethod('post')){
            $value[0]=$request->input('orderid');
            $value[1]=$request->input('userid');
            $name[0]='orderid';
            $name[1]='userid';
            $data['backinfo']=$request->input('backinfo');
            $res=$this->rep->RepUpdateByTwo($name,$value,$data);
            if($res){
                return $this->success();
            }else{
                return $this->fail(16005);
            }
        }
    }
}
