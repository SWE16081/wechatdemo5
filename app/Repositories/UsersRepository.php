<?php
/**
 * Created by PhpStorm.
 * User: SWESWE
 * Date: 2019/9/8
 * Time: 14:10
 */

namespace App\Repositories;


class UsersRepository extends BaseRepository
{

    public function modelname()
    {
        // TODO: Implement modelname() method.
        return 'User';
    }
    //微信商家注册用户
    public function RepUserCreate($data)
    {

        $res=$this->model->insertGetId($data);
        return $res;
    }
    //查询账户是否存在
    public function RepUserSelExit($data){
        $res=parent::findByfirst('name',$data);
        return $res;
    }
    //按账号查询密码
    public function RepUserSelPsdByName($data){
        $res=parent::findByfirst('name',$data,'password');
        return $res;
    }
    //按账户查询role
    public function RepUserSelRoleByName($data){
        $res=parent::findByfirst('name',$data,'role');
        return $res;
    }
    //单条件查询first
    public function RepSelByOneFirst($name,$value,$columns = array('*')){
        return parent::findByfirst($name,$value,$columns);
    }
    //单条件查询
    public function RepSelByOne($name,$value,$columns = array('*')){
        return parent::findByGet($name,$value,$columns);
    }
    //双条件查询
    public function RepUserSelByTwo($name,$value,$columns = array('*')){
        $res=parent::findBy2($name,$value,$columns);
        return $res;
    }
}