<?php

namespace App\Http\Controllers;


use App\Repositories\BaseRepository;
use Illuminate\Http\Request;
 class BaseController
{
    //
    protected $rep;
    //构造函数注入依赖
    public function __construct(BaseRepository $rep)
    {
        $this->rep=$rep;
    }
     public function success($data=[],$code=200){
         return response()->json([
             'status'=>'success',
             'code'=>$code,
             'message'=>config('apierrorcode.code')[(int)($code)],
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
