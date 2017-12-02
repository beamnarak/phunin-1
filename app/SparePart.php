<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SparePart extends Model
{
    public function users(){
        return $this->hasMany('App\User');
    }

    public function unit(){
        return $this->belongsTo('App\Unit');
    }

    public function position(){
        return $this->belongsTo('App\Position');
    }

    public function category(){
        return $this->belongsTo('App\Category');
    }
}
