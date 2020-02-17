<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\BaseController;
use App\Repositories\BaseRepository;
use App\Repositories\CachetRepository;
use App\Repositories\CakindRepository;
use App\Repositories\OrderRepository;
use App\Repositories\SckindRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use phpDocumentor\Reflection\Types\Boolean;

class wechatShopcar extends BaseController
{
    protected $cakindrep,$sckindrep,$orderrep,$cachetrep;
    public function __construct(BaseRepository $rep,CakindRepository $cakindrep,
                                SckindRepository $sckindrep,OrderRepository $orderrep,CachetRepository $cachetrep)
    {
        parent::__construct($rep);
        $this->cakindrep=$cakindrep;
        $this->sckindrep=$sckindrep;
        $this->orderrep=$orderrep;
        $this->cachetrep=$cachetrep;
    }
//buyerid: userid,
//cachetid: cachetid,
//cachetname: cachetname,
//cachetsize: cachetsize,
//cachetcolor: cachetcolor,
//number: number,
//cachetinfo: cachetinfo,
//cachetkindid: cachetkindid,
//price: price,
//picpath: picpath
    //购物车添加
    public function UserAddtoShopcar(Request $request){
        if($request->isMethod('post')){
            $data['buyerid']=$request->input('buyerid');
            $data['cachetid']=$request->input('cachetid');
            $data['cachetkindid']=$request->input('cachetkindid');
            $data['cachetname']=$request->input('cachetname');
            $data['cachetcolor']=$request->input('cachetcolor');
            $data['cachetsize']=$request->input('cachetsize');

            $data['cachetinfo']=$request->input('cachetinfo');
            $data['picpath']=$request->input('picpath');
            $data['number']=$request->input('number');
            $data['price']=$request->input('price');
            //查询购物车中是否有该商品
            $name[0]='cachetid';
            $name[1]='cachetsize';
            $name[2]='cachetcolor';
            $name[3]='buyerid';
            $value[0]=$data['cachetid'];
            $value[1]=$data['cachetsize'];
            $value[2]=$data['cachetcolor'];
            $value[3]=$data['buyerid'];
            $res=$this->rep->RepSelByFour($name,$value);
          if(count($res)>0){//该商品存在，数量增加
              $number['number']=$res[0]['number']+$data['number'];
              //按userid cachetid和cachetsize修改数量和总金额????bug
              $na[0]='cachetid';
              $na[1]='cachetsize';
              $na[2]='buyerid';
              $va[0]=$data['cachetid'];
              $va[1]=$data['cachetsize'];
              $va[2]=$data['buyerid'];
              $res3=$this->rep->RepUpdateByThere($na,$va,$number);
                 if($res3)
                 {
                    return $this->success();
                 }else{
                     return $this->fail(16005);
                 }
          }else {//购物车中不存在添加的商品
              //添加该商品
              $res2=$this->rep->RepUserAddShopcar($data);
              if($res2){
                  return $this->success();
              }else{
                  return $this->fail(16003);
              }
          }
        }
    }
    //第一次进入购物车页面清空checkbox状态
    public function checkboxFlase(Request $request){
        if($request->isMethod('post') ){
            $userid = $request->input('userid');
            $da['checkboxchoose'] = false;
            $da2['kindchoosed'] = false;
            $re2 = $this->rep->RepUpdateByone('buyerid',$userid,$da);
            $re3 = $this->sckindrep->RepUpdateByone('userid', $userid, $da2);
            if($re3&&$re2){
                return json_encode(['res'=>'success']);
            }else{
                return json_encode(['res'=>'error']);
            }
        }
    }
    //购物车处查询--按种类查询
    public function  UserSelShopcar(Request $request){
        if($request->isMethod('post')){
            $userid=$request->input('userid');
            //按userid查询用户购物车
//            $res=$this->rep->RepSelBy('buyerid',$userid);
            //按useid查询购物车已有种类
            $kind=$this->sckindrep->RepSelByOne('userid',$userid);
            $data=array();
            $k=0;
            for($i=0;$i<count($kind);$i++){
                //按cachetKindid查询
                $res2=$this->rep->RepSelBy('cachetkindid',$kind[$i]['cachetKindid']);
                if(count($res2)!=0){
                    $data[$k]['cachetKindid']=$kind[$i]['cachetKindid'];
                    //查询cakindr的名称与解释
                     $res3=$this->cakindrep->RepSelByOne('cachetKindid',$kind[$i]['cachetKindid']);
                    $data[$k]['cakindname']=$res3[0]['cakindname'];
                    $data[$k]['cachetExplain']=$res3[0]['cachetExplain'];
                    $data[$k]['cachet']=$res2;
                    $data[$k]['kindchoosed']=$kind[$i]['kindchoosed'];
//                    $data[$k]['allchoose']=$kind[$i]['allchoose'];
                    $k++;
                }
            }
            return $data;
        }
    }
    //购物车查询2
    public function  UserSelShopcar2(Request $request){
        if($request->isMethod('post')){
            $userid=$request->input('userid');
            //查询shopcar信息和 cakind表的cachetExplain
            $res=$this->rep->RepJoinSelect('buyerid',$userid);
            return $res;
//            //按userid查询用户购物车
//            $res=$this->rep->RepSelBy('buyerid',$userid);
//            return $res;
//            for($i=0;$i<count($res);$i++){
//                $res[$i]['cachetexplain']=$this->cakindrep->RepSelByOne('cachetKindid',$res[$i]['cachetkindid'])[0]['cachetExplain'];
//            }
//           return $res;

        }
    }
    //购物车数量改变
    public function UserChangeNumber(Request $request){
        if($request->isMethod('post')){
            $way=$request->input('way');
            $shopcarid=$request->input('shopcarid');
            $number=$request->input('number');
            //默认数量每次加1 预留一次加很多
            if($way=="add"){
               //获取单价
                $res=$this->rep->RepSelBy('shopcarid',$shopcarid)[0];
                $data['number']=$res['number']+$number;
                //按照shopcarid更新数据
                $res=$this->rep->RepUpdateByone('shopcarid',$shopcarid,$data);//更新更改返回1 否则返回0
                if($res){
                    return json_encode(['res'=>'success']);
                }else{
                    return json_encode(['res'=>'error']);
                }
            }else if($way=="minus"){
                //获取单价
                $res=$this->rep->RepSelBy('shopcarid',$shopcarid)[0];
                $data['number']=$res['number']-$number;
                if($data['number']==0){//数量为0删除数据
                    $res=$this->rep->RepDeleteByOne('shopcarid',$shopcarid);
                    if($res){
                        return json_encode(['res'=>'success']);
                    }else{
                        return json_encode(['res'=>'error']);
                    }
                }else{
                    //按照shopcarid更新数据
                    $res=$this->rep->RepUpdateByone('shopcarid',$shopcarid,$data);//更新更改返回1 否则返回0
                    if($res){
                        return json_encode(['res'=>'success']);
                    }else{
                        return json_encode(['res'=>'error']);
                    }
                }
            }
        }
    }
    //购物车 公章种类checkbox状态修改
    public function ScKindchoosedChange(Request $request){
        if($request->isMethod('post')){
            $cachetKindid=$request->input('cachetKindid');
            $userid=$request->input('userid');
            $kindchoosed=$request->input('kindchoosed');
            //更改sckind checkbox选中状态
            $name[0]='cachetKindid';
            $name[1]='userid';
            $value[0]=$cachetKindid;
            $value[1]=$userid;
            $data['kindchoosed']=$kindchoosed;
            //更新公章种类checkbox状态
            $res=$this->sckindrep->RepUpdateByTwo($name,$value,$data);
            if($res){
                $n[0]='cachetKindid';
                $n[1]='buyerid';
                $v[0]=$cachetKindid;
                $v[1]=$userid;
                if($kindchoosed){
                        $data2['checkboxchoose']=true;
                    //更改shopcar checkbox状态
                        $res3=$this->rep->RepUpdateByTwo($n,$v,$data2);
                    if($res3){
                        return json_encode(['res'=>'success']);
                    }else{
                        return json_encode(['res'=>'error']);
                    }
                }else{
                    $data2['checkboxchoose']=false;
                    //更改shopcar checkbox状态
                    $res3=$this->rep->RepUpdateByTwo($n,$v,$data2);
                    if($res3){
                        return json_encode(['res'=>'success']);
                    }else{
                        return json_encode(['res'=>'error']);
                    }
                }

            }else{
                return json_encode(['res'=>'error']);
            }
        }

    }
    //购物车单个checkbox状态修改
    public function SccheckboxchooseChange(Request $request){
        if($request->isMethod('post')){
            $shopcarid=$request->input('shopcarid');
            $checkboxchoose=$request->input('checkboxchoose');
            $userid=$request->input('userid');
            $cachetKindid=$request->input('cachetKindid');
            //修改单个checkbox状态
            $test['checkboxchoose']=$checkboxchoose;
            $res=$this->rep->RepUpdateByone('shopcarid',$shopcarid,$test);
            if($res){
                if($checkboxchoose){//checkbox为真 判断所有checkbox是否为真修改kindchoose
                    $name[0]='buyerid';
                    $name[1]='cachetkindid';
                    $value[0]=$userid;
                    $value[1]=$cachetKindid;
                    $res2=$this->rep->RepSelByTwo($name,$value);
                    if(count($res2)>0){
                        $k=0;
                        for($i=0;$i<count($res2);$i++){
                            if($res2[$i]['checkboxchoose']){
                                $k++;
                            }
                        }
                        //所有checkbox被选中 设置种类checkbox为true
                        if($k==count($res2)){
                            $name2[0]='userid';
                            $name2[1]='cachetKindid';
                            $value2[0]=$userid;
                            $value2[1]=$cachetKindid;
                            $test2['kindchoosed']=true;
                            $res3=$this->sckindrep->RepUpdateByTwo($name2,$value2,$test2);
                            if($res3){
                                return json_encode(['res'=>'success']);
                            }else{
                                return json_encode(['res'=>'error']);
                            }
                        }else{
                            return json_encode(['res'=>'success']);
                        }
                    }else{
                        return json_encode(['res'=>'error']);
                    }
                }
                else{//checkbox为假
                    $name[0]='userid';
                    $name[1]='cachetKindid';
                    $value[0]=$userid;
                    $value[1]=$cachetKindid;
                    $test2['kindchoosed']=false;
//                    修改kindchoose
                    $res2=$this->sckindrep->RepUpdateByTwo($name,$value,$test2);
                    if($res2){
                        return json_encode(['res'=>'success']);
                    }else{
                        return json_encode(['res'=>'error']);
                    }
                }
            }else{
                return json_encode(['res'=>'error']);
            }
        }



    }
    //全选
    public function ScAllchoose(Request $request){
        if($request->isMethod('post')){
            $buyerid=$request->input('buyerid');
            $allchoose=$request->input('allchoose');
            //按buyerid查询
            $res=$this->rep->RepSelBy('buyerid',$buyerid);
            if(count($res)>0){
                if($allchoose){//全选
                    //更新kindchoose checkboxchoose状态
                    $data['checkboxchoose']=true;
                    $data2['kindchoosed']=true;
//                    $data2['allchoose']=true;
                    $res2=$this->rep->RepUpdateByone('buyerid',$buyerid,$data);
                    $res3=$this->sckindrep->RepUpdateByone('userid',$buyerid,$data2);
                    if($res2&&$res3){
                        return json_encode(['res'=>'success']);
                    }else{
                        return json_encode(['res'=>'error']);
                    }
                }else{//取消全选
                    $data['checkboxchoose']=false;
                    $data2['kindchoosed']=false;
//                    $data2['allchoose']=false;
                    $res2=$this->rep->RepUpdateByone('buyerid',$buyerid,$data);
                    $res3=$this->sckindrep->RepUpdateByone('userid',$buyerid,$data2);
                    if($res2&&$res3){
                        return json_encode(['res'=>'success']);
                    }else{
                        return json_encode(['res'=>'error']);
                    }
                }
            }else{
                return json_encode(['res'=>'error']);
            }
        }
    }
    //购物车单项删除
    public function UserDelShopcar(Request $request){
        if($request->isMethod('post')){
            $shopcarid=$request->input('shopcarid');
            $userid=$request->input('userid');
            //获取删除公章的cachetkindid
            $res2=$this->rep->RepSelBy('shopcarid',$shopcarid);
            $res=$this->rep->RepDeleteByOne('shopcarid',$shopcarid);
            //查询shopcar 表中是否有与删除商品相同的商品
            $res3=$this->rep->RepSelBy('cachetkindid',$res2[0]['cachetkindid']);
            if($res){
                if(count($res3)==0)
                {
                    $f[0]='userid';
                    $f[1]='cachetKindid';
                    $s[0]=$userid;
                    $s[1]=$res2[0]['cachetkindid'];
                    $res4=$this->sckindrep->RepDeleteByTwo($f,$s);
                    if($res4){
                        return json_encode(['res'=>'success']);
                    }else{
                        return json_encode(['res'=>'error']);
                    }
                }else{
                    return json_encode(['res'=>'success']);
                }
            }else{
                return json_encode(['res'=>'error']);
            }
        }
    }
    //全部删除
    public function ScAllDel(Request $request){
        if($request->isMethod('post')){
             $arr=$request->input('arr');
            $buyerid=$request->input('buyerid');
            $k=0;
            //按 传递的shopcarid删除
            for($i=0;$i<count($arr);$i++){
                //获取删除公章的cachetkindid
                $res2=$this->rep->RepSelBy('shopcarid',$arr[$i]);
                $res=$this->rep->RepDeleteByOne('shopcarid',$arr[$i]);
                if($res){//删除成功
                    //查询shopcar 表中是否有与删除商品相同的商品
                    $res3=$this->rep->RepSelBy('cachetkindid',$res2[0]['cachetkindid']);
                    //shopcar中不存在与删除的shopcarid同种类的公章===》删除sckind中公章种类数据
                    if(count($res3)==0)
                    {
                        $f[0]='userid';
                        $f[1]='cachetKindid';
                        $s[0]=$buyerid;
                        $s[1]=$res2[0]['cachetkindid'];
                        $res4=$this->sckindrep->RepDeleteByTwo($f,$s);
                        if($res4){
                            $k++;
                        }else{
                            return json_encode(['res'=>'error']);
                        }
                    }else{
                        $k++;
                    }
                }else{
                    return json_encode(['res'=>'error']);
                }

            }
            if($k==count($arr)){
                return json_encode(['res'=>'success']);
            }else{
                return json_encode(['res'=>'error']);
            }
        }
    }
    //
    //全部删除2
    public function ScAllDel2(Request $request){
        if($request->isMethod('post')){
            $buyerid=$request->input('buyerid');
                $res=$this->rep->RepDeleteByOne('buyerid',$buyerid);
                if($res){//删除成功

                return json_encode(['res'=>'success']);
            }else{
                return json_encode(['res'=>'error']);
            }
        }
    }

    //结算---跳转结算页面后提交订单---添加订单
    public function CountMoney(Request $request){
        if($request->isMethod('post')){
            $arr=$request->input('arr');
            $data['userid']=$request->input('userid');
            $data['totalprice']=$request->input('totalprice');
            $data['name']=$request->input('name');
            $data['phone']=$request->input('phone');
            $data['deliverway']=$request->input('deliverway');
            $data['address']=$request->input('address');
            $data['state']=$request->input('state');
            $data['explain']=$request->input('explain');
            //将makerid放入shopcar数据表中
            $makerid=array();
            $shopcar=array();
            for($i=0;$i<count($arr);$i++) {
                $shopcar[$i]=($this->rep->RepSelBy('shopcarid',$arr[$i]))[0];//获取shopcar具体信息
              $makerid[$i]=($this->cachetrep->RepSelBy('cachetid',$shopcar[$i]['cachetid']))[0];
              $shopcar[$i]['makerid']=$makerid[$i]['makerid'];
            }
            //判断所选购物车商品是否是同一个makerid
            $n=0;$m=0;//$n表示订单数 $m表示一个订单下的商品数
            $t=array();
            for($i=0;$i<count($shopcar);$i++){
                //判断前面是否有相同元素
                $flage=true;
                for($k=0;$k<$i;$k++){
                    if($shopcar[$k]['makerid']==$shopcar[$i]['makerid']){
                        $flage=false;
                    }
                }
                if($flage){//没有相同元素
                    $t[$n]['userid']=$data['userid'];
                    $t[$n]['makerid']=$shopcar[$i]['makerid'];
                    $t[$n]['cachetid'][$m]=$shopcar[$i]['cachetid'];
                    $t[$n]['cachetname'][$m]=$shopcar[$i]['cachetname'];
                    $t[$n]['cachetsize'][$m]=(string)$shopcar[$i]['cachetsize'];
                    $t[$n]['cachetcolor'][$m]=$shopcar[$i]['cachetcolor'];
                    $t[$n]['number'][$m]=$shopcar[$i]['number'];
                    $t[$n]['price'][$m]=(string)$shopcar[$i]['price'];
                    $t[$n]['picpath'][$m]=$shopcar[$i]['picpath'];
                    $t[$n]['cachetinfo'][$m]=$shopcar[$i]['cachetinfo'];
                    $t[$n]['totalprice']=$data['totalprice'];
                    $t[$n]['name']=$data['name'];
                    $t[$n]['phone']=$data['phone'];
                    $t[$n]['deliverway']=$data['deliverway'];
                    $t[$n]['address']=$data['address'];
                    $t[$n]['state']=$data['state'];
                    $t[$n]['explain']=$data['explain'];
                    for($j=$i+1;$j<count($shopcar);$j++)
                    {
                        if($shopcar[$i]['makerid']==$shopcar[$j]['makerid']){
                            $m++;
                            $t[$n]['cachetid'][$m]=$shopcar[$j]['cachetid'];
                            $t[$n]['cachetname'][$m]=$shopcar[$j]['cachetname'];
                            $t[$n]['cachetsize'][$m]=(string)$shopcar[$j]['cachetsize'];
                            $t[$n]['cachetcolor'][$m]=$shopcar[$j]['cachetcolor'];
                            $t[$n]['number'][$m]=$shopcar[$j]['number'];
                            $t[$n]['price'][$m]=(string)$shopcar[$j]['price'];
                            $t[$n]['picpath'][$m]=(string)$shopcar[$j]['picpath'];
                            $t[$n]['cachetinfo'][$m]=(string)$shopcar[$j]['cachetinfo'];
                        }
                    }
                    $t[$n]['cachetid']=json_encode($t[$n]['cachetid']);
                    $t[$n]['cachetname']=json_encode($t[$n]['cachetname']);
                    $t[$n]['cachetsize']=json_encode($t[$n]['cachetsize']);
                    $t[$n]['cachetcolor']=json_encode($t[$n]['cachetcolor']);
                    $t[$n]['number']=json_encode($t[$n]['number']);
                    $t[$n]['price']=json_encode($t[$n]['price']);
                    $t[$n]['picpath']=json_encode($t[$n]['picpath']);
                    $t[$n]['cachetinfo']=json_encode($t[$n]['cachetinfo']);
                    $n++;
                }
            }
            $cnt=0;
           for($i=0;$i<count($t);$i++){
                $result=$this->orderrep->RepDataAdd($t[$i]);
                if($result){
                    $cnt++;
                }
           }
           if($cnt==count($t)){//添加订单成功--删除购物车
               //购买的公章从购物车删除
               $k=0;
               //按 传递的shopcarid删除
               for($i=0;$i<count($arr);$i++){
                   //获取删除公章的cachetkindid
                   $res2=$this->rep->RepSelBy('shopcarid',$arr[$i]);
                   $res=$this->rep->RepDeleteByOne('shopcarid',$arr[$i]);
                   if($res){//删除成功
                       //查询shopcar 表中是否有与删除商品相同的商品
                       $res3=$this->rep->RepSelBy('cachetkindid',$res2[0]['cachetkindid']);
                       //shopcar中不存在与删除的shopcarid同种类的公章===》删除sckind中公章种类数据
                       if(count($res3)==0)
                       {
                           $f[0]='userid';
                           $f[1]='cachetKindid';
                           $s[0]=$data['userid'];
                           $s[1]=$res2[0]['cachetkindid'];
                           $res4=$this->sckindrep->RepDeleteByTwo($f,$s);
                           if($res4){
                               $k++;
                           }else{
                               return json_encode(['res'=>'error']);
                           }
                       }else{
                           $k++;
                       }
                   }else{
                       return json_encode(['res'=>'error']);
                   }
               }
               if($k==count($arr)){
                   return json_encode(['res'=>'success']);
               }else{
                   return json_encode(['res'=>'error']);
               }
           }else{
               return json_encode(['res'=>'error']);
           }



        }
    }

}
