<?php
/**
 * Created by PhpStorm.
 * User: SWESWE
 * Date: 2019/11/6
 * Time: 23:31
 */

namespace App\tools\ApiReturnData;


class ApiReturnData
{
  public function success($data=[]){
      return response()->json([
         'status'=>'success',
          'code'=>'200',
          'message'=>config('apierrorcode.code')[200],
          'data'=>$data
      ]);
  }

  public function fail($code,$data=[]){
      return response()->json([
          'status'=>'fail',
          'code'=>$code,
          'message'=>config('apierrorcode.code')[(int)($code)],
          'data'=>$data,
      ]);
  }

}