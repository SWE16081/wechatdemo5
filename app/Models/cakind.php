<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class cakind extends Model
{
    //
    protected $table='cakind';
    protected $fillable=['makerid','cakindname','cachetExplain'];
    public function cachet(){
        return $this->hasMany('App\Models\cachet','cachetKindid','cachetKindid');
    }
}
