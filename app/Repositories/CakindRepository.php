<?php
/**
 * Created by PhpStorm.
 * User: SWESWE
 * Date: 2019/9/20
 * Time: 15:29
 */

namespace App\Repositories;

use App\Models\cakind;
class CakindRepository extends BaseRepository
{

    public function modelname()
    {
        // TODO: Implement modelname() method.
        return 'cakind';
    }

    //连接查询
    public function RepjoinSelect($name,$data,$columns = array('*')){
        $cakind=new cakind();
        return $cakind->first()->cachet;
    }
    //添加公章种类
    public function RepAddCakind($data){
        return parent::dataAdd($data);
    }
    //分页查询公章种类表
    public function RepSelCakind(){
        return parent::paginate();
    }
    //全部查询
    public function RepSelall(){
        return parent::dataSelect();
    }
    //单条件查询
    public function RepSelByOne($name,$value,$columns = array('*')){
        return parent::findByGet($name,$value,$columns);
    }
    //双条件查询
    public function RepSelByTwo($name,$data,$columns = array('*')){
        return parent::findBy2($name,$data,$columns);
    }
    //按cachetkindid查询公章种类说明
    public function RepSelExBykind($data){
        return parent::findByfirst('cachetKindid',$data,['cachetExplain']);
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