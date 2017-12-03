<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SparePart extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
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
