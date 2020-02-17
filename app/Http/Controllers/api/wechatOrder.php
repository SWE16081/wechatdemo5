<?php

namespace App\Http\Controllers\api;
use App\Repositories\ExpressRepository;
use App\Repositories\UsersRepository;
use GuzzleHttp\Client;
use App\Http\Controllers\BaseController;
use App\Repositories\AddressRepository;
use App\Repositories\BaseRepository;
use App\Repositories\CachetRepository;
use App\Repositories\CakindRepository;
use App\Repositories\OrderProvePicRepository;
use App\Repositories\ShopcarRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class wechatOrder extends BaseController
{

    //
    protected $shopcarrep,$addrep,$cachetrep,$cakindrep,$orproverep,$userrep,$expressRep;
    public function __construct(BaseRepository $rep,ShopcarRepository $shopcarrep,
                                AddressRepository $addrep,CachetRepository $cachetrep,
                                CakindRepository $cakindrep,OrderProvePicRepository $orproverep,UsersRepository $userrep,
                                ExpressRepository $expressRep)
    {
        parent::__construct($rep);
        $this->shopcarrep=$shopcarrep;
        $this->addrep=$addrep;
        $this->cachetrep=$cachetrep;
        $this->cakindrep=$cakindrep;
        $this->orproverep=$orproverep;
        $this->userrep=$userrep;
        $this->expressRep=$expressRep;
    }

    public function ScAddOrder(Request $request){
        if($request->isMethod('post')){

        }
    }
    //价格按小数点分离
    public function PriceBypoint($data){
        for($i=0;$i<count($data);$i++){
            $str=(string)$data[$i]['price'];
            $ar=explode('.',$str);
            if(count($ar)==1){
                $ar[1]='00';
            }
            $data[$i]['price']=$ar;
        }
        return $data;
    }
    //确认订单查询
    public function AffirmOrderSel(Request $request){
        if($request->isMethod('post')){
            $arr=$request->input('arr');
            $userid=$request->input('userid');
            //查询购物车里要买的商品信息
            $data=array();
            for($i=0;$i<count($arr);$i++){
                $data[$i]=$this->shopcarrep->RepSelBy('shopcarid',$arr[$i])[0];
                //获取explain
                $data[$i]['explain']=($this->cachetrep->RepSelBy('cachetid',$data[$i]['cachetid'],['cachetExplain']))[0]['cachetExplain'];
            }
          $data=$this->PriceBypoint($data);
            $test['shopcar']=$data;
            //查询收货地址
            $name[0]='userid';
            $name[1]='checked';
            $value[0]=$userid;
            $value[1]=true;
            //查询默认选中的checked
            $res=$this->addrep->RepSelByTwo($name,$value);
            if(count($res)==0){
                $test['address']=['name'=>'请填写收件人','phone'=>'手机号','city'=>'请填写城市','address'=>'及详细地址'];
            }else{
                $test['address']=$res[0];
            }
            if($res){
                return $test;
            }else{
                return json_encode(['res'=>'error']);
            }

        }
    }

    //确认订单查询2
    public function AffirmOrderSel2(Request $request){
        if($request->isMethod('post')){
            $userid=$request->input('userid');
            //查询购物车里要买的商品信息
            $data=array();
            $res=$this->shopcarrep
                ->RepSelBy('buyerid',$userid);
            for($i=0;$i<count($res);$i++){
                $res[$i]['cachetexplain']=$this->cakindrep->RepSelByOne('cachetKindid',$res[$i]['cachetkindid'])[0]['cachetExplain'];
            }
//            $res=$this->PriceBypoint($res);
              $test['express']=$this->expressRep->RepSelAll();
            //查询快递价格
            $test['shopcar']=$res;
            //查询收货地址
            $name[0]='userid';
            $name[1]='checked';
            $value[0]=$userid;
            $value[1]=true;
            //查询默认选中的checked
            $res=$this->addrep->RepSelByTwo($name,$value);
            if(count($res)==0){
                $test['address']=['name'=>'请填写收件人','phone'=>'手机号','city'=>'请填写城市','address'=>'及详细地址'];
            }else{
                $test['address']=$res[0];
            }
            if($res){
                return $test;
            }else{
                return json_encode(['res'=>'error']);
            }

        }
    }
    //立即购买-->确认订单-->信息查询
    public function BuyNowSel(Request $request){
        if($request->isMethod('post')){
            $userid=$request->input('userid');
            $data['cachetid']=$request->input('cachetid');
            $data['cachetsize']=$request->input('cachetsize');
            $data['cachetcolor']=$request->input('cachetcolor');
            $data['number']=$request->input('number');
            $data['price']=$request->input('price');
            $data['picpath']=$request->input('picpath');
            //获取cachettagname,explain
            $data['cachetname']=($this->cachetrep->RepSelBy('cachetid',$data['cachetid'],['cachettagname']))[0]['cachettagname'];
            $data['explain']=($this->cachetrep->RepSelBy('cachetid',$data['cachetid'],['cachetExplain']))[0]['cachetExplain'];
            $arr=array();
            $arr[0]=$data;
            $arr=$this->PriceBypoint($arr);
            //查询收件人信息
            $test['shopcar']=$arr;
            //查询收货地址
            $name[0]='userid';
            $name[1]='checked';
            $value[0]=$userid;
            $value[1]=true;
            //查询默认选中的checked
            $res=$this->addrep->RepSelByTwo($name,$value);
            if(count($res)==0){
                $test['address']=['name'=>'请填写收件人','phone'=>'手机号','city'=>'请填写城市','address'=>'及详细地址'];
            }else{
                $test['address']=$res[0];
            }
            if($res){
                return $test;
            }else{
                return json_encode(['res'=>'dataNull']);//无数据请求，加载无数据页面
            }

        }
    }
    //立即购买 添加订单
    public function BuyNowAddOrder(Request $request){
        if($request->isMethod('post')){
            $data['userid']=$request->input('userid');
            $arr=array();
            $arr['cachetid'][0]=$request->input('cachetid');
            $arr['cachetname'][0]=$request->input('cachetname');
            $arr['cachetsize'][0]=(string)$request->input('cachetsize');
            $arr['cachetcolor'][0]=$request->input('cachetcolor');
            $arr['number'][0]=$request->input('number');
            $arr['price'][0]=(string)$request->input('price');
            $arr['picpath'][0]=$request->input('picpath');

            $data['cachetid']=json_encode($arr['cachetid']);
            $data['cachetname']=json_encode($arr['cachetname']);
            $data['cachetsize']=json_encode($arr['cachetsize']);
            $data['cachetcolor']=json_encode($arr['cachetcolor']);
            $data['number']=json_encode($arr['number']);
            $data['price']=json_encode($arr['price']);
            $data['picpath']=json_encode($arr['picpath']);
            $data['totalprice']=$request->input('totalprice');
            $data['name']=$request->input('name');
            $data['phone']=$request->input('phone');
            $data['deliverway']=$request->input('deliverway');
            $data['address']=$request->input('address');
            $data['state']=$request->input('state');
            $data['explain']=$request->input('explain');
            //获取makerid
            $data['makerid']=($this->cachetrep->RepSelBy('cachetid',$arr['cachetid'][0]))[0]['makerid'];
            $res=$this->rep->RepDataAdd($data);
            if($res){
                return json_encode(['res'=>'success']);
            }else{
                return json_encode(['res'=>'error']);
            }

        }

    }
    //订单查询数据构造
    public function orSelDataMake($res){
        for($i=0;$i<count($res);$i++){
            $arr=array();
            $len=json_decode($res[$i]['cachetid'],true);
            $cachetname=json_decode($res[$i]['cachetname'],true);
            $cachetinfo=json_decode($res[$i]['cachetinfo'],true);
            $cachetid=json_decode($res[$i]['cachetid'],true);
            $cachetsize=json_decode($res[$i]['cachetsize'],true);
            $cachetcolor=json_decode($res[$i]['cachetcolor'],true);
            $number=json_decode($res[$i]['number'],true);
            $price=json_decode($res[$i]['price'],true);
            $picpath=json_decode($res[$i]['picpath'],true);
//
            for($j=0;$j<count($len);$j++){
                $arr[$j]['cachetid']=$cachetid[$j];
                $arr[$j]['cachetname']=$cachetname[$j];
                $arr[$j]['cachetinfo']=$cachetinfo[$j];
                $arr[$j]['cachetsize']=$cachetsize[$j];
                $arr[$j]['cachetcolor']=$cachetcolor[$j];
                $arr[$j]['number']=$number[$j];
                $arr[$j]['price']=$this->PriceBypoint2($price[$j]);
                $arr[$j]['price2']=$price[$j];
                $arr[$j]['picpath']=$picpath[$j];
                //查询公章种类说明
                 //查询cachetKindid
                $cachetKindid=$this->cachetrep->RepSelBy('cachetid',$cachetid[$j])[0]['cachetKindid'];
                $arr[$j]['cachetexplain']=$this->cakindrep->RepSelByOne('cachetKindid',$cachetKindid)[0]['cachetExplain'];
            }
            $res[$i]['order']=$arr;
            unset($res[$i]['cachetid']);
            unset($res[$i]['cachetname']);
            unset($res[$i]['cachetinfo']);
            unset($res[$i]['cachetsize']);
            unset($res[$i]['cachetcolor']);
            unset($res[$i]['number']);
            unset($res[$i]['price']);
            unset($res[$i]['picpath']);
        }
        if(count($res)>0){
            return $res;
        }
    }
    //用户订单查询
    public function OrderSel(Request $request){
        if($request->isMethod('post')){
            $userid=$request->input('userid');
            $state=$request->input('state');
            if($state==0){
                //查询order表和orprovepic的cachetprove
                $data=$this->rep->RepSelBy('userid',$userid);
                if(count($data)>0){
                    $res=$this->orSelDataMake($data);
                    if(count($res)>0){
                        return $this->success($res);
                    }else{
                        return $this->fail(16012);
                    }
                }else{
                    return $this->fail(16002);
                }
            }else{
                $name[0]='userid';
                $name[1]='state';
                $value[0]=$userid;
                $value[1]=$state;
                $data=$this->rep->RepSelByTwo($name,$value);
                if(count($data)>0){
                    //订单查询数据构造
                    $res=$this->orSelDataMake($data);
                    if(count($res)>0){
                        return $this->success($res);
                    }else{
                        return $this->fail(16012);
                    }
                }else{
                    return $this->fail(16002);
                }
            }
        }
    }
    //用户订单分页查询
    public function OrderSelPage(Request $request){
        if($request->isMethod('get')){
            $userid=$request->input('userid');
            $state=$request->input('state');
            if($state==0){
                //查询order表和orprovepic的cachetprove
                $data=$this->rep->RepSelPageBy('userid',$userid);
                if(count($data)>0){
                    $res=$this->orSelDataMake($data);
                    if(count($res)>0){
                        return $this->success($res);
                    }else{
                        return $this->fail(16012);
                    }
                }else{
                    return $this->fail(16002);
                }
            }else{
                $name[0]='userid';
                $name[1]='state';
                $value[0]=$userid;
                $value[1]=$state;
                $data=$this->rep->RepSelPageByTwo($name,$value);
//                return $data;
                if(count($data)>0){
                    //订单查询数据构造
                    $res=$this->orSelDataMake($data);
//                    return $res;
                    if(count($res)>0){
                        return $this->success($res);
                    }else{
                        return $this->fail(16012);
                    }
                }else{
                    return $this->fail(16002);
                }
            }
        }
    }
    public function PriceBypoint2($data){

            $str=(string)$data;
            $ar=explode('.',$str);
            if(count($ar)==1){
                $ar[1]='00';
            }
            $data=$ar;

        return $data;
    }
    //待处理订单类型长度
    public function OrderLenSel(Request $request){
        if($request->isMethod('post')){
            $userid=$request->input('userid');
            $arr=array();
            for($i=1;$i<5;$i++){
                $name[0]='userid';
                $name[1]='state';
                $value[0]=$userid;
                $value[1]=$i;
                $data=$this->rep->RepSelByTwo($name,$value);
                if(count($data)>0)
                $arr[$i]=count($data);
                else
                    $arr[$i]='';
            }
            if(count($arr)>0){
                return $this->success($arr);
            }else{
                return $this->fail(16012);
            }
        }
    }
    //删除订单
    public function OrderDelete(Request $request){
        if($request->isMethod('post')){
            $orderid=$request->input('orderid');
            $res=$this->rep->RepDeleteByOne('orderid',$orderid);
            if($res){
                return json_encode(['res'=>'success']);
            }else{
                return json_encode(['res'=>'error']);
            }
        }
    }
    //确认收货
    public function confirm(Request $request){
        if($request->isMethod('post')){
            $orderid=$request->input('orderid');
            //添加评价功能时要修改这便
            $data['state']=4;
            $res=$this->rep->RepUpdateByone('orderid',$orderid,$data);
            if($res){
                return $this->success();
            }else{
                return $this->fail(16005);
            }
        }
    }
    //提交订单
    public function subOrder(Request $request){
        if($request->isMethod('post')){
            $data['userid']=$request->input('userid');
            $data['name']=$request->input('name');
            $data['phone']=$request->input('phone');
            $data['address']=$request->input('address');
            $data['deliverway']=$request->input('deliverway');
            $data['totalprice']=$request->input('totalprice');
            $data['state']=$request->input('state');
            $data['explain']=$request->input('explain');
            $arr=$request->input('arr');

            //要购买的公章数据
            $shopData=array();
            $temp=array();
            for($i=0;$i<count($arr);$i++){
                //查询购物车公章购买信息
                $shopData[$i]=$this->shopcarrep->RepSelBy('shopcarid',$arr[$i])[0];
                //查询makerid
                $temp[$i]=$this->cachetrep->RepSelBy('cachetid',$shopData[$i]['cachetid'])[0];
                $shopData[$i]['makerid']=$temp[$i]['makerid'];
            }
            $sum=0;
            for($i=0;$i<count($shopData);$i++){
                $data['cachetid'][$i]=$shopData[$i]['cachetid'];
                $data['cachetname'][$i]=$shopData[$i]['cachetname'];
                $data['cachetsize'][$i]=$shopData[$i]['cachetsize'];
                $data['cachetcolor'][$i]=$shopData[$i]['cachetcolor'];
                $data['number'][$i]=$shopData[$i]['number'];
                $data['price'][$i]=$shopData[$i]['price'];
                $data['picpath'][$i]=$shopData[$i]['picpath'];
                $data['cachetinfo'][$i]=$shopData[$i]['cachetinfo'];
                $sum=$sum+$shopData[$i]['number']*$shopData[$i]['price'];
            }
            $data['cachetid']=json_encode($data['cachetid']);
            $data['cachetname']=json_encode($data['cachetname']);
            $data['cachetsize']=json_encode($data['cachetsize']);
            $data['cachetcolor']=json_encode($data['cachetcolor']);
            $data['number']=json_encode($data['number']);
            $data['price']=json_encode($data['price']);
            $data['picpath']=json_encode($data['picpath']);
            $data['cachetinfo']=json_encode($data['cachetinfo']);
            $data['totalprice']=$sum;
            $data['makerid']=$shopData[0]['makerid'];
            //
            $res=$this->rep->RepDataAddReturnId($data);
            if($res){
                //删除购物车数据
                $res2=$this->shopcarrep->RepDeleteByOne('buyerid',$data['userid']);
                if($res2){
                    return json_encode(['res'=>'success','result'=>$res]);
                }
                else{
                    return json_encode(['res'=>'error']);
                }
            }else{
                return json_encode(['res'=>'error']);
            }

        }
    }
    //提交订单上传公章证明
    public function subOrderUploadPic(Request $request){
        if($request->isMethod('post')){
            $orderid=$request->input('orderid');
            $file=$request->file('file');
            $result=json_decode($this->fileStorage($file),true);
            $data['orderid']=$orderid;
            $data['cachetprove']=$result['picpath'];
            //向orprovepic表添加数据
            $res=$this->orproverep->RepDataAdd($data);
            if($res){
                return json_encode(['res'=>'success']);
            }
            else{
                return json_encode(['res'=>'error']);
            }
        }
    }

    //取消订单
    public function OrderCancel(Request $request){
        if($request->isMethod('post')){
            $orderid=$request->input('orderid');
            $res=$this->rep->RepDeleteByOne('orderid',$orderid);
            if($res){
                return $this->success();
            }else{
                return $this->fail(16004);
            }
        }
    }
    //文件存储
    public function fileStorage($file){
        if($file->isValid()) {
            $type = $file->getClientMimeType();
//            if ($type == 'image/png' || $type == 'image/jpeg' || $type == 'image/pjpeg'
//                || $type == 'image/gif' || $type == 'image/bmp' || $type == "image/x-png"
//            ) {
                //原文件名
                $orginalName = $file->getClientOriginalName();
                //扩展名
                $ext = $file->getClientOriginalExtension();
                //临时绝对路径
                $realPath = $file->getRealPath();
                $filename = uniqid() . '.' . $ext;
                //调用disk模块里的uploads，
                $bool = Storage::disk('userProvePicUpload')->put($filename, file_get_contents($realPath));
                //判断是否上传成功
                if ($bool) {
                    return json_encode(['res'=>'success','picpath'=>'uploads/userProvePic/'.date('Ymd').'/'.$filename]);
                } else {
                    return json_encode(['res'=>'error']);
                }
            }
//        }
//        $bool = Storage::disk('cachetPicUpload')->put($filename, file_get_contents($realPath));
//        //判断是否上传成功
//        if ($bool) {
//            return json_encode(['res'=>'success','picpath'=>'uploads/cachetPic/'.date('Ymd').'/'.$filename]);
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
    //订单详情
    public function UserOrderDetail(Request $request){
        if($request->isMethod('post')){
            $orderid=$request->input('orderid');

            $data=$this->rep->RepSelBy('orderid',$orderid);
            if(count($data)>0){
                $res=$this->orSelDataMake($data);
                if(count($res)>0){
                    return $this->success($res[0]);
                }else{
                    return $this->fail(16012);
                }
            }else{
                return $this->fail(16002);
            }
        }
    }
    //商家待处理订单类型长度
    public function MakerOrderLenSel(Request$request){
        if($request->isMethod('post')){
            $makerid=$request->input('userid');
            $arr=array();
            $sum=0;
            for($i=2;$i<5;$i++){
                $name[0]='makerid';
                $name[1]='state';
                $value[0]=$makerid;
                $value[1]=$i;
                $data=$this->rep->RepSelByTwo($name,$value);
                if(count($data)>0){
                    $arr[$sum]=count($data);
                }else{
                    $arr[$sum]='';
                }
                $sum++;
            }
            if(count($arr)>0){
                return $this->success($arr);
            }else{
                return $this->fail(16012);
            }
        }
    }

    //商家订单查询
    public function MakerOrderSel(Request $request){
        if($request->isMethod('post')){
            $makerid=$request->input('userid');
            $state=$request->input('state');
            if($state==0){
                //查询order表和orprovepic的cachetprove
                $data=$this->rep->RepSelBy('makerid',$makerid);
                if(count($data)>0){
                    $res=$this->orSelDataMake($data);
                    if(count($res)>0){
                        return $this->success($res);
                    }else{
                        return $this->fail(16012);
                    }
                }else{
                    return $this->fail(16002);
                }
            }else{
                $name[0]='makerid';
                $name[1]='state';
                $value[0]=$makerid;
                $value[1]=$state;
                $data=$this->rep->RepSelByTwo($name,$value);
                if(count($data)>0){
                    $res=$this->orSelDataMake($data);
                    if(count($res)>0){
                        return $this->success($res);
                    }else{
                        return $this->fail(16012);
                    }
                }else{
                    return $this->fail(16002);
                }
            }
        }
    }

    //商家分页订单查询
    public function MakerOrderSelPage(Request $request){
        if($request->isMethod('get')){
            $makerid=$request->input('userid');
            $state=$request->input('state');
            if($state==0){
                //查询order表和orprovepic的cachetprove
                $data=$this->rep->RepSelPageByNot('makerid',$makerid);
                    if(count($data)>0){
                    $res=$this->orSelDataMake($data);
                    if(count($res)>0){
                        return $this->success($res);
                    }else{
                        return $this->fail(16012);
                    }
                }else{
                    return $this->fail(16002);
                }
            }else{
                $name[0]='makerid';
                $name[1]='state';
                $value[0]=$makerid;
                $value[1]=$state;
                $data=$this->rep->RepSelPageByTwo($name,$value);
                if(count($data)>0){
                    $res=$this->orSelDataMake($data);
                    if(count($res)>0){
                        return $this->success($res);
                    }else{
                        return $this->fail(16012);
                    }
                }else{
                    return $this->fail(16002);
                }
            }
        }
    }
    //商家确认发货
    public function MakerAffirmSend(Request $request){
        if($request->isMethod('post')){
            $orderid=$request->input('orderid');
            $data['state']='3';
            $res=$this->rep->RepUpdateByone('orderid',$orderid,$data);
            if($res){
                return $this->success();
            }else{
                return $this->fail(16005);
            }
        }
    }
    //从提交订单页面支付
    public function WechatPayByOrder(Request $request){
        if($request->isMethod('post')){
            $userid=$request->input('userid');
//            $orderid=$request->input('orderid');
            $data=$this->userrep->RepSelByOne('id',$userid)[0];
            $openid=$data['openid'];
            $sessionid=$data['session_key'];
            //获取统一下单参数
            //小程序ID
            $appid=env('AppId');
            //商户号
            $mch_id=env('mch_id');
            //构造随机字符串
            $nonce_str=$this->nonce_strMake();
            //商品描述
            $body='swe16081购买中心';
            //商品订单号
            $out_trade_no=$this->orderidMake();
            //金额
            $total_fee=$request->input('totalprice');
            //服务器ip
            $spbill_create_ip=env('ip');
            //通知地址
            $notify_url='http://www.weixin.qq.com/wxpay/pay.php';
            //交易类型
            $trade_type='JSAPI';

            //api密钥
            $apisecret=env('ApiSecret');
            //构造签名
            $arr=array();
            $arr['appid']=$appid;
            $arr['body']=$body;
            $arr['mch_id']=$mch_id;
            $arr['nonce_str']=$nonce_str;
            $arr['notify_url']=$notify_url;
            $arr['openid']=$openid;
            $arr['out_trade_no']=$out_trade_no;
            $arr['spbill_create_ip']=$spbill_create_ip;
            $arr['total_fee']=$total_fee;
            $arr['trade_type']=$trade_type;

            $sign=$this->signMake($arr);
            $post_xml = '<xml>
           <appid>'.$appid.'</appid>
           <body>'.$body.'</body>
           <mch_id>'.$mch_id.'</mch_id>
           <nonce_str>'.$nonce_str.'</nonce_str>
           <notify_url>'.$notify_url.'</notify_url>
           <openid>'.$openid.'</openid>
           <out_trade_no>'.$out_trade_no.'</out_trade_no>
           <spbill_create_ip>'.$spbill_create_ip.'</spbill_create_ip>
           <total_fee>'.$total_fee.'</total_fee>
           <trade_type>'.$trade_type.'</trade_type>
           <sign>'.$sign.'</sign>
          
        </xml> ';

            //向微信服务器发送统一下单强求
            $client=new Client();
            $url='https://api.mch.weixin.qq.com/pay/unifiedorder';
//            $re=$this->http_request($url,$post_xml);
            $res=$client->request('post','https://api.mch.weixin.qq.com/pay/unifiedorder',[
                'body'=>$post_xml,
                'headers' => [
                    'Accept' => 'application/xml'
                ]
            ]);
            //字符串转为变量
            $objectxml = simplexml_load_string($res->getBody(), 'SimpleXMLElement',LIBXML_NOCDATA);//将文件转换成 对象
            $xmljson= json_encode($objectxml);//将对象转换个JSON
            $xmlarray=json_decode($xmljson,true);//将json转换成数组
            $xmlarray['apisecret']=$apisecret;
            if($xmlarray){
                return $this->success($xmlarray);
            }else{
                return $this->fail(16013);
            }

        }
    }

    //从提交订单页面支付成功修改订单状态

    //从订单支付支付成功修改状态
    public function PayByOrderChangeStatus(Request $request){
        if($request->isMethod('post')){
            $orderid=$request->input('orderid');
            $data['state']=2;
            $res=$this->rep->RepUpdateByone('orderid',$orderid,$data);
            if($res){
                return $this->success();
            }else{
                return $this->fail(16004);
            }
        }
    }


    //构造随机字符串
    public function nonce_strMake(){
        $str="0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $res='';
        for($i=0;$i<32;$i++){
            $res[$i]=$str[rand(0,58)];
        }
        return $res;
    }
    //
    //构造订单号
    public function orderidMake(){
      return md5(date('Ymd',time()).time());
    }
    //构造签名
    public function signMake($data){
        $res='';
        $sum=0;
        foreach($data as $key=>$value){
            if($value!=''){
                if($sum==0){
                    $res=$key.'='.$value;
                }else{
                    $res=$res.'&'.$key.'='.$value;
                }
               $sum++;
            }
        }
        $stringSignTemp=$res.'&key='.env('ApiSecret');
        $sign=strtoupper(md5($stringSignTemp));

        return $sign;
    }
}
