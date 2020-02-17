<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\BaseController;
use App\Models\cakind;
use App\Repositories\BaseRepository;
use App\Repositories\CachetPicRepository;
use App\Repositories\CakindRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class wechatCachet extends BaseController
{
    protected $kindrep;
    public function __construct(BaseRepository $rep,CakindRepository $kindrep)
    {
        parent::__construct($rep);
        $this->kindrep=$kindrep;
    }
     //+商家按makerid公章查询
    public function MakerSelCachet(Request $request){
        if($request->isMethod('post')){
            $userid=$request->input('userid');
            $res=$this->rep->RepSelBy('makerid',$userid);
            if(count($res)>0){
                $res=$this->jsonToArray($res);//把cachet的数据变为数组类型
                return $this->success($res) ;
            }else{
                return $this->fail(16002);
            }
        }
    }
    //+商家按按makerid cachetkindid查询
    public function MakerSelCachetByKind(Request $request){
        if($request->isMethod('post')){
            $userid=$request->input('userid');
            $cachetkindid=$request->input('cachetkindid');
            $name[0]='makerid';
            $name[1]='cachetKindid';
            $value[0]=$userid;
            $value[1]=$cachetkindid;
            $res=$this->rep->RepSelByTwo($name,$value);
            if(count($res)>0){
                $res=$this->jsonToArray($res);
                return $this->success($res) ;
            }else{
                return $this->fail(16002);
            }
        }
    }


    //+商家添加公章--公章名称查重
    public function MakerAddSelReapet(Request $request){
        if($request->isMethod('post')){
            $makerid=$request->input('userid');
            $cachetname=$request->input('cachetname');
            $name[0]='makerid';
            $name[1]='cachettagname';
            $value[0]=$makerid;
            $value[1]=$cachetname;
            $res=$this->rep->RepSelByTwo($name,$value);

            if(count($res)>0){
                return $this->success('repeat') ;
            }else{
                return $this->fail(16006);
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
                $bool = Storage::disk('cachetPicUpload')->put($filename, file_get_contents($realPath));
                //判断是否上传成功
                if ($bool) {
                    return json_encode(['res'=>'success','picpath'=>'uploads/cachetPic/'.date('Ymd').'/'.$filename]);
                } else {
                    return json_encode(['res'=>'error']);
                }
            }
//        }
    }
    //文件删除
    public function  filedelete($data){
        $sum=0;
        for($i=0;$i<count($data[0]['cachetPicPath']);$i++){
            $picpath=explode('/',$data[0]['cachetPicPath'][$i])[2];
            $bool = Storage::disk('picuploads')->delete($picpath);
            if($bool){
                $sum++;
            }
        }
        if($sum==count($data[0]['cachetPicPath'])){
            return true;
            }else{
            return false;
        }
    }
    //+商家用户添加公章
    public function MakerAddCachet(Request $request){
        if($request->isMethod('post')){
            $data['makerid']=$request->input('userid');
            $cachetKindInfo=$request->input('cachetKindInfo');
            $data['cachettagname']=$request->input('cachetnameInput');
            $data['cachetPrice']=$request->input('priceInput');
            $data['cachetSize']=$request->input('sizeInput');
            $data['cachetColor']=$request->input('colorInput');
            $file=$request->file('file');
            //获取cachetKindid
            $n[0]='makerid';
            $n[1]='cakindname';
            $v[0]=$data['makerid'];
            $v[1]=$cachetKindInfo;
            //获取公章种类id
            $data['cachetKindid']=$this->kindrep->RepSelByTwo($n,$v)[0]['cachetKindid'];
            //判断要插入的公章之前是否存在
            $name[0]='makerid';
            $name[1]='cachettagname';
            $value[0]=$data['makerid'];
            $value[1]=$data['cachettagname'];
            $res=$this->rep->RepSelByTwo($name,$value);

            if(count($res)>0){//该数据已有，跟新cachetPicPath信息
                $arr=array();
                $arr=json_decode($res[0]['cachetPicPath'],true);
                $result=json_decode($this->fileStorage($file),true);
                if($result['res']=='success') {
                    array_push($arr, $result['picpath']);
                    //更新数据
                    $test['cachetPicPath'] = json_encode($arr);
                    $res3 = $this->rep->RepUpdateByTwo($name, $value, $test);
                    if ($res3) {
                        return $this->success($res3,16009);//更新成功
                    } else {
                        return $this->fail(16005);
                    }
                }else{
                    return $this->fail(16007);
                }
            }else{
                $result=json_decode($this->fileStorage($file),true);
                if($result['res']=='success'){
                    $arr= array();
                    array_push($arr,$result['picpath']);
                    $data['cachetPicPath']=$arr;
                    //数组转json字符串
                    $data['cachetPicPath']=json_encode($data['cachetPicPath']);
                    //添加数据
                    $res3=$this->rep->RepMakerAddCachet($data);
                    if($res3){
                        return $this->success($res3,16008);
                    }else{
                        return $this->fail(16003);
                    }
                }else{
                    return $this->fail(16007);
                }
            }
        }
    }
    //+商家按cachetid查询公章
    public function MakerSelCachetBy(Request $request){
        if($request->isMethod('post')){
            $cachetid=$request->input('cachetid');
            $res=$this->rep->RepSelBy('cachetid',$cachetid);

            //查询公章种类名称
            $cachetkindname=$this->kindrep->RepSelByOne('cachetKindid',$res[0]['cachetKindid'])[0]['cakindname'];
            $res[0]['cakindname']=$cachetkindname;
            $res=$this->jsonToArray($res);
            if(count($res)>0){
                return $this->success($res);
            }else{
                return $this->fail(16002);
            }

        }
    }
   //+商家按cachetid删除公章
    public function MakerDelCachet(Request $request){
        if($request->isMethod('post')){
            $makerid=$request->input('makerid');
            $cachetid=$request->input('cachetid');
            //查询要删除的公章图片路径
            $data=$this->rep->RepSelBy('cachetid',$cachetid);
             $data=$this->jsonToArray($data);
            $result=$this->filedelete($data);    //删除pic下的图片
            if($result){

                $name[0]='makerid';
                $name[1]='cachetid';
                $value[0]=$makerid;
                $value[1]=$cachetid;
                $res=$this->rep->RepDeleteByTwo($name,$value);
                if($res){
                    return $this->success();
                }else{
                    return $this->fail(16004);
                }
            }else{
                return $this->fail(16004);
            }


        }
    }
    //商家按cachetid 下载公章图片数据
    public function MakerDownCachetPic(Request $request){
        if($request->isMethod('post')){
            $cachetid=$request->input('cachetid');
            $index=$request->input('index');
            $res=$this->rep->RepSelBy('cachetid',$cachetid);
            $arr=json_decode($res[0]['cachetPicPath'],true);
            $filename=explode('/',$arr[$index])[2];
            $content = '测试response';
            $status = 200;
//            $value = 'text/html;charset=utf-8';
//            $response = new \Illuminate\Http\Response($content,$status);
//            $header=$response->header('Content-Type','image/jpeg');
//            $data=Storage::disk('picuploads')->download($filename,$filename,$header);
//            $content=Storage::disk('picuploads')->download($filename);
            $data=Storage::disk('picuploads')->download($filename);
            return $data;
        }
    }

    //+商家按cachetid更新公章 删除 cachetPicPath
    public function MakerDelPicpath(Request $request){
        if($request->isMethod('post')){
            $cachetid=$request->input('cachetid');
            //查询要删除的公章图片路径
            $data2=$this->rep->RepSelBy('cachetid',$cachetid);
            $data2=$this->jsonToArray($data2);
            $result=$this->filedelete($data2);    //删除pic下的图片
            if($result){
                $data['cachetPicPath']=null;//
                $res=$this->rep->RepUpdateByone('cachetid',$cachetid,$data);
                if($res){
                    return $this->success();
                }else{
                    return $this->fail(16004);
                }
            }else{
                return $this->fail(16004);
            }


        }
    }
    // //+商家按cachetid更新公章
    public function MakerUpCachet(Request $request){
        if($request->isMethod('post')){
            $data['makerid']=$request->input('userid');
            $cachetKindInfo=$request->input('cachetKindInfo');
            $cachetid=$request->input('cachetid');
            //接收的数据为json字符串
            $data['cachettagname']=$request->input('cachetnameInput');
            $data['cachetPrice']=$request->input('priceInput');
            $data['cachetSize']=$request->input('sizeInput');
            $data['cachetColor']=$request->input('colorInput');

            $file=$request->file('file');
            //获取cachetKindid
            $n[0]='makerid';
            $n[1]='cakindname';
            $v[0]=$data['makerid'];
            $v[1]=$cachetKindInfo;
            $data['cachetKindid']=$this->kindrep->RepSelByTwo($n,$v)[0]['cachetKindid'];
            //查询已存在的公章修改cachetPicPath
            $res=$this->rep->RepSelBy('cachetid',$cachetid);
                $arr=array();
                if($res[0]['cachetPicPath']!=null){
                    $arr=json_decode($res[0]['cachetPicPath'],true);
                }

                $result=json_decode($this->fileStorage($file),true);
                array_push($arr,$result['picpath']);
                //更新数据
                $data['cachetPicPath']=json_encode($arr);
                $res3=$this->rep->RepUpdateByone('cachetid',$cachetid,$data);
                if($res3){
                    return $this->success();
                }else{
                    return $this->fail(16005);
                }
        }
    }
    //买家查询所有公章
    public function UserSelCachet(Request $request){
        if($request->isMethod('post')){
            $datares=$this->kindrep->RepSelCakind();
            $datares2=array();
            $cloum=['cachetid','cachetKindid','cachetPrice','cachetPicPath','cachetNum'];
            for($i=0;$i<count($datares);$i++)
            {
                //按照cachetKindid查询cachet表中第一个出现的种类
                $datares2[$i]=$this->rep->RepUserSelByCakindid($datares[$i]['cachetKindid'],$cloum);
                //获取cakind表中的公章种类说明
                $datares2[$i]['cachetExplain']=$datares[$i]['cachetExplain'];
            }
            for($i=0;$i<count($datares2);$i++){
                $datares2[$i]['cachetPrice']=json_decode($datares2[$i]['cachetPrice']);
                $datares2[$i]['cachetPicPath']=json_decode($datares2[$i]['cachetPicPath']);
                $datares2[$i]['show']=true;
            }
                $test=array();
                $k=0;
                if(count($datares2)%2==0){
                    for($j=0;$j<count($datares2)/2;$j++){
                        for($i=0;$i<2;$i++){
                            $test[$j][$i]=$datares2[$k];
                            $k++;
                        }
                    }
                    return $test;
                }
                else{
                    $len=count($datares2);
                    for($j=0;$j<(int)($len/2);$j++){
                        for($i=0;$i<2;$i++){
                            $test[$j][$i]=$datares2[$k];
                            $k++;
                        }
                    }
                    $test[($len+1)/2-1][0]=$datares2[$len-1];
                    $arr['show']=false;
                    $test[($len+1)/2-1][1]=$arr;
                    return $test;
                }
        }
    }

    //公章详情查询
    public function UserSelCachetDetail(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->input('cachetKindid');
            $res= $this->rep->RepjoinSelect('cachetKindid',$data);
             $res=$this->jsonToArray(json_decode($res, true));
            if (count($res)>0) {
                return $this->success($res);
            } else {
                return $this->fail(16002);
            }
        }
    }
    public function arrayAdd($dataarr,$name){
        $arr=array();
        $arr=$dataarr;
        for($j=0;$j<count($arr);$j++){
            if($j==0){
                $arr[$j][$name]=true;
            }else{
                $arr[$j][$name]=false;
            }
        }
        return $arr;
    }

    //数据表中json字符串转数组
    public function jsonToArray($data){
        for($i=0;$i<count($data);$i++){
            $data[$i]['cachetPrice']=json_decode($data[$i]['cachetPrice'],true);
            $data[$i]['cachetPicPath']=json_decode($data[$i]['cachetPicPath'],true);
            $data[$i]['cachetSize']=json_decode($data[$i]['cachetSize'],true);
            $data[$i]['cachetColor']=json_decode($data[$i]['cachetColor'],true);
        }
        return $data;
    }

}
