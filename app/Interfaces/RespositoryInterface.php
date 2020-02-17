<?php

/**
 * Created by PhpStorm.
 * User: SWESWE
 * Date: 2019/7/28
 * Time: 9:59
 */
namespace App\Interfaces;
interface RespositoryInterface
{
    public function  paginate($data=6);
    public function paginateBy($name,$value,$data = 6);
    public function paginateByTwo($name,$value,$data = 6);
    public function dataSelect();
    public function dataAdd(array $data);
//    //单个条件查询--first
    public function findByfirst($field, $value,$columns = array('*'));
    //单条件查询---get
    public function findByGet($field, $value,$columns = array('*'));
//    //多个条件查询
    public function findBy2($field, $value,$columns = array('*'));
    public function findBy3($field, $value,$columns = array('*'));
    public function findBy4($field, $value,$columns = array('*'));
    public function findBy5($field, $value,$columns = array('*'));
//    //单个条件删除
    public function dataDelete($field, $value);
//    //多个条件删除
    public function dataDelete2($field, $value);
//    public function dataDelete3($field, $value);
//    //单条件更新
    public function updateBy($field, $value,$data);
    //多条件更新
    public function updateBy2($field,$value,$data);
    public function updateBy3($field,$value,$data);
}