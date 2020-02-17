<?php
/**
 * Created by PhpStorm.
 * User: SWESWE
 * Date: 2019/9/11
 * Time: 14:48
 */

namespace App\Repositories;
use App\Models\cachet;
use Illuminate\Support\Facades\DB;

class CachetRepository extends BaseRepository
{

    public function modelname()
    {
        // TODO: Implement modelname() method.
        return 'cachet';
    }
    //添加公章
    public function RepMakerAddCachet($data){
        return parent::dataAdd($data);
    }

    //买家查询公章
    public function RepUserSelCaCachet(){
        $res=parent::paginate(4);
//        $res=parent::dataSelect();
        return $res;
    }
    //按cachetid查询
    public function RepUserSelByCachetid($data){
        return parent::findByfirst('cachetid',$data);
    }
    //按cakindid查询first
    public function RepUserSelByCakindid($data,$cloum){
        return parent::findByfirst('cachetKindid',$data,$cloum);
    }
    //连接查询
    public function RepjoinSelect($name,$data,$columns = array('*')){
       $res= DB::table('cachet')
            ->join('cakind','cachet.cachetKindid','=','cakind.cachetKindid')
           ->where('cachet.'.$name,'=',$data)
           ->get($columns);
       return $res;
    }
    //单条件查询
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