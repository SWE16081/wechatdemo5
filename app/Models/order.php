<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    //
    protected $table="order";
    protected $fillable=['userid','makerid','cachetid','cachetname','cachetsize','cachetcolor','number',
        'price','picpath','cachetinfo',
        'totalprice','name','phone','deliverway','address','state','explain'];
}
