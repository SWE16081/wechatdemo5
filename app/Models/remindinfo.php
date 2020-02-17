<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class remindinfo extends Model
{
    //
    protected $table='remindinfo';
    protected $fillable=['userid','orderid','info'];
}
