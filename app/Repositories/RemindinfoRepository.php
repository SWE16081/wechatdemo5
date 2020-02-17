<?php
/**
 * Created by PhpStorm.
 * User: SWESWE
 * Date: 2019/10/2
 * Time: 18:37
 */

namespace App\Repositories;


class RemindinfoRepository extends BaseRepository
{

    public function modelname()
    {
        // TODO: Implement modelname() method.
        return 'remindinfo';
    }
    public function RepAdddData($data){
        return parent::dataAdd($data);
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
    public function RepSelPageByTwo($name,$data){
        $res=parent::paginateByTwo($name,$data,6);
        return $res;
    }
    //按条件查询
    public function RepSelBy($name,$data,$columns = array('*')){
        return parent::findByGet($name,$data,$columns);
    }

    //双条件查询
    public function RepSelByTwo($name,$data,$columns = array('*')){
        return parent::findBy2($name,$data,$columns);
    }
    public function RepSelByFive($name,$value,$columns = array('*')){
        return parent::findBy5($name,$value,$columns);
    }
    //三条件查询
    public function RepSelByThree($name,$value,$data){
        return parent::findBy3($name,$value,$data);
    }
    //按单条件更新数据
    public function RepUpdateByone($name,$value,$data)
    {
        return parent::updateBy($name,$value,$data);
    }
    //
    //单条件删除
    public function RepDeleteByOne($name,$value){
        return parent::dataDelete($name,$value);
    }
    //按双条件更新数据
    public function RepUpdateByTwo($name,$value,$data){
        return parent::updateBy2($name,$value,$data);
    }

}