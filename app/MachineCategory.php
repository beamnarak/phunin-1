<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MachineCategory extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function machines(){
        return $this->hasMany('App\Machine');
    }
}
