<?php
/**
 * Created by PhpStorm.
 * User: SWESWE
 * Date: 2019/9/22
 * Time: 14:08
 */

namespace App\Repositories;


use Illuminate\Support\Facades\DB;

class ShopcarRepository extends BaseRepository
{

    public function modelname()
    {
        // TODO: Implement modelname() method.
        return 'shopcar';
    }
    public function RepUserAddShopcar($data){
        return parent::dataAdd($data);
    }
    //shopcar和cakind连查询
    public function RepJoinSelect($name,$data,$columns=array('*')){
        $columns=['shopcarid','buyerid','cachetid',
            'cachetname','cachetsize','picpath',
            'cachetcolor','number','price','cachetExplain'];
        $res=DB::table('shopcar')
            ->join('cakind','shopcar.cachetkindid','=','cakind.cachetKindid')
            ->where('shopcar.'.$name,'=',$data)
            ->get($columns);
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
    //按3条件查询
    public function RepSelByThree($name,$value,$columns = array('*')){
        return parent::findBy3($name,$value,$columns);
    }
    //按4条件查询
    public function RepSelByFour($name,$value,$columns = array('*')){
        return parent::findBy4($name,$value,$columns);
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
    //按3条件更新数据
    public function RepUpdateByThere($name,$value,$data){
        return parent::updateBy3($name,$value,$data);
    }
    //单条件删除
    public function RepDeleteByOne($name,$value){
        return parent::dataDelete($name,$value);
    }
    //多条件删除
    public function  RepDeleteByTwo($name,$value){
        return parent::dataDelete2($name,$value);
    }





}