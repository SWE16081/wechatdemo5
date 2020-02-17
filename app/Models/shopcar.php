<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class shopcar extends Model
{
    //
    protected $table='shopcar';
    protected $fillable=['shopcarid','buyerid','cachetid','cachetkindid',
        'cachetname','cachetsize','picpath','cachetcolor','cachetinfo','number','price',
        'checkboxchoose','created_at','updated_at'];


}
