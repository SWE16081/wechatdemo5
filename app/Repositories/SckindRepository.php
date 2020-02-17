<?php
/**
 * Created by PhpStorm.
 * User: SWESWE
 * Date: 2019/9/28
 * Time: 14:36
 */

namespace App\Repositories;


class SckindRepository extends BaseRepository
{

    public function modelname()
    {
        // TODO: Implement modelname() method.
        return "sckind";
    }
    //插入
    public function RepAddSckind($data){
        return parent::dataAdd($data);
    }
    //单条件查询
    public function RepSelByOne($name,$value,$columns = array('*')){
        return parent::findByGet($name,$value,$columns);
    }

    //2条件查询
    public function RepSelBytwo($name,$value,$columns = array('*')){
        return parent::findBy2($name,$value,$columns);
    }
    //按单条件更新数据
    public function RepUpdateByone($name,$value,$data)
    {
        return parent::updateBy($name,$value,$data);
    }
    //按双条件更新数据
    public function RepUpdateByTwo($name,$value,$data){
        return parent::updateBy2($name,$value,$data);
    }
    //单条件删除
    public function RepDeleteByOne($name,$value){
        return parent::dataDelete($name,$value);
    }
    //2条件删除
    public function  RepDeleteByTwo($name,$value){
        return parent::dataDelete2($name,$value);
    }

}