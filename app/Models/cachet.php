<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class cachet extends Model
{
    //
    protected $table="cachet";
    protected $fillable=['makerid','cachetKindid','cachettagname',
        'cachetPrice','cachetNum','cachetPicPath','cachetSize','cachetColor'];
    //模型关联操作
    public function cakind(){
        return $this->belongsTo('App\Models\cakind','cachetKindid','cachetKindid');

    }
}
