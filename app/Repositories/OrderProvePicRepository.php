<?php
/**
 * Created by PhpStorm.
 * User: SWESWE
 * Date: 2019/9/19
 * Time: 15:10
 */

namespace App\Repositories;


class OrderProvePicRepository extends BaseRepository
{

    public function modelname()
    {
        // TODO: Implement modelname() method.
        return 'orprovepic';
    }
    //添加
    public function RepDataAdd($data){
        return parent::dataAdd($data);
    }


}