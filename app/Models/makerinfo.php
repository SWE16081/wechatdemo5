<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class makerinfo extends Model
{
    //
    protected $table="makerinfo";
    protected $fillable=['userid','companyinfo','proveinfo','expressprice'];
}
