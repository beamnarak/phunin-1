<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }
    
    public function spare_parts(){
        return $this->hasMany('App\SparePart');
    }
}
