<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
class wechatCompanyInfo extends BaseController
{

    //用户查询公司信息
    //查询公司相关信息
    public function userSelComInfo(Request $request){
        if($request->isMethod("post")){
            $res=$this->rep->RepSelall();
            if(count($res)>0){
                $res=$this->jsonToArray($res);
                return $this->success($res);
            }else{
                return $this->fail(16007);
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
            $bool = Storage::disk('picuploads')->put($filename, file_get_contents($realPath));
            //判断是否上传成功
            if ($bool) {
                return json_encode(['res'=>'success','picpath'=>'uploads/pic/'.$filename]);
            } else {
                return json_encode(['res'=>'error']);
            }
        }
//        }
    }
    //添加公司相关信息
    public function makerInfoAdd(Request $request){
        if($request->isMethod("post")){
            $data['userid']=$request->input("userid");
            $data['companyinfo']=$request->input("companyinfo");
            $file=$request->file('file');
            //按userid判断该用户是否有证明材料
            $res=$this->rep->RepSelBy('userid',$data["userid"]);
            if(count($res)>0){
                $arr=array();
                $arr=json_decode($res[0]['proveinfo'],true);
                $result=json_decode($this->fileStorage($file),true);
                if($result['res']=='success') {
                    array_push($arr, $result['picpath']);
                    //更新数据
                    $test['proveinfo'] = json_encode($arr);
                    $res3 = $this->rep->RepUpdateByone("userid", $data["userid"], $test);
                    if ($res3) {
                        return $this->success($res3,16009);
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
                    $data['proveinfo']=$arr;
                    //数组转json字符串
                    $data['proveinfo']=json_encode($data['proveinfo']);
                    //添加数据
                    $res3=$this->rep->RepAddData($data);
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
    //查询公司相关信息
    public function makerInfoSel(Request $request){
        if($request->isMethod("post")){
            $userid=$request->input("userid");
            $res=$this->rep->RepSelBy("userid",$userid);
            if(count($res)>0){
                $res=$this->jsonToArray($res);
                return $this->success($res);
            }else{
                return $this->fail(16007);
            }
        }
    }
    //更新公司相关信息
    public function makerInfoUpdate(Request $request){
        if($request->isMethod("post")){
            $userid=$request->input("userid");
            $data['companyinfo']=$request->input("companyinfo");
            $file=$request->file('file');
//            //按userid判断该用户是否有证明材料
            $res=$this->rep->RepSelBy('userid',$userid);
            $arr=array();
            if($res[0]['proveinfo']!=null){
                $arr=json_decode($res[0]['proveinfo'],true);
            }
                $result=json_decode($this->fileStorage($file),true);
                    array_push($arr, $result['picpath']);
                    //更新数据
                    $test['proveinfo'] = json_encode($arr);
                    $test['companyinfo']=$data['companyinfo'];
                    $res3 = $this->rep->RepUpdateByone("userid", $userid, $test);
                    if ($res3) {
                        return $this->success($res3,16009);
                    } else {
                        return $this->fail(16005);
                    }
                }else{
                    return $this->fail(16007);
                }

//        }
    }
    //更新时删除
    public function makerInfoUpDel(Request $request){
        if($request->isMethod("post")){
            $userid=$request->input('userid');
            //查询要删除的公司证明材料图片路径
            $data2=$this->rep->RepSelBy('userid',$userid);
            $data2=$this->jsonToArray($data2);
            $result=$this->filedelete($data2);//删除pic下的图片
            if($result){
                $data['proveinfo']=null;//
                $res=$this->rep->RepUpdateByone("userid",$userid,$data);
                if($res){
                    return $this->success();
                }else{
                    return $this->fail(16004);
                }
            }else{
                return $this->fail(16011);
            }
        }
    }
    //删除
    public function makerInfoDel(Request $request){
        if($request->isMethod("post")){
            $userid=$request->input('userid');
            //查询要删除的公章图片路径
            $data=$this->rep->RepSelBy('userid',$userid);
            $data=$this->jsonToArray($data);
            $result=$this->filedelete($data);    //删除pic下的图片
            if($result){
                $name[0]='userid';
                $res=$this->rep->RepDeleteByOne("userid",$userid);
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
    //文件删除
    public function  filedelete($data){
        $sum=0;
        for($i=0;$i<count($data[0]['proveinfo']);$i++){
            $picpath=explode('/',$data[0]['proveinfo'][$i])[2];
            $bool = Storage::disk('picuploads')->delete($picpath);
            if($bool){
                $sum++;

            }
        }
//        return $sum;
        if($sum==count($data[0]['proveinfo'])){
            return true;
        }else{
            return false;
        }
    }
    //数据表中json字符串转数组
    public function jsonToArray($data){
        for($i=0;$i<count($data);$i++){
            $data[$i]['proveinfo']=json_decode($data[$i]['proveinfo'],true);
        }
        return $data;
    }


}
