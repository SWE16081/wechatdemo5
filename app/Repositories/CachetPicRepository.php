<?php
/**
 * Created by PhpStorm.
 * User: SWESWE
 * Date: 2019/9/19
 * Time: 15:10
 */

namespace App\Repositories;


class CachetPicRepository extends BaseRepository
{

    public function modelname()
    {
        // TODO: Implement modelname() method.
        return 'cachetpic';
    }
    //添加图片
    public function RepAddPic($data){
        return parent::dataAdd($data);
    }
    //按cachetid查询图片
    public function  RepSelPicByCaid($data){
        return parent::findByGet('cachetid',$data,'cachetimg');
    }

}