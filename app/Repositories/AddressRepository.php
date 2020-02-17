<?php
/**
 * Created by PhpStorm.
 * User: SWESWE
 * Date: 2019/10/2
 * Time: 18:37
 */

namespace App\Repositories;


class AddressRepository extends BaseRepository
{

    public function modelname()
    {
        // TODO: Implement modelname() method.
        return 'address';
    }
    public function RepSelAll(){
        return parent::dataSelect();
    }
    public function RepAddAddress($data){
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
    public function RepSelByFive($name,$value,$columns = array('*')){
        return parent::findBy5($name,$value,$columns);
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