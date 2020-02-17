<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class address extends Model
{
    protected $table='address';
    protected $fillable=['userid','name','phone','city','address','checked'];
}
