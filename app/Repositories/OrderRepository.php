<?php
/**
 * Created by PhpStorm.
 * User: SWESWE
 * Date: 2019/9/30
 * Time: 19:49
 */

namespace App\Repositories;


use App\Models\order;
use Illuminate\Support\Facades\DB;

class OrderRepository extends  BaseRepository
{

    public function modelname()
    {
        // TODO: Implement modelname() method.
        return 'order';
    }
    //订单分页全部查询
    public function RepSelPage($name,$data){
        $res=parent::paginate(4);
        return $res;
    }
    //订单分页按条件查询
    public function RepSelPageBy($name,$data){
    $res=parent::paginateBy($name,$data,6);
    return $res;
}
    public function RepSelPageByNot($name,$data){
        $res=order::where($name,'=',$data)
            ->whereIn('state', [2,3])->paginate(6);
        return $res;
    }
    public function RepSelPageByTwo($name,$data){
        $res=parent::paginateByTwo($name,$data,6);
        return $res;
    }
    public function RepDataAddReturnId($data){
        $res=$this->model->insertGetId($data);
        return $res;
    }
    public function  RepDataAdd($data){
        return parent::dataAdd($data);
    }
    //按条件查询
    public function RepSelBy($name,$data,$columns = array('*')){
        return parent::findByGet($name,$data,$columns);
    }
    //双条件查询
    public function RepSelByTwo($name,$data,$columns = array('*')){
        return parent::findBy2($name,$data,$columns);
    }
    //按单条件更新数据
    public function RepUpdateByone($name,$value,$data)
    {
        return parent::updateBy($name,$value,$data);
    }
    //单条件删除
    public function RepDeleteByOne($name,$value){
        return parent::dataDelete($name,$value);
    }
}