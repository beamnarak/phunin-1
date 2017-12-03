<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockIn extends Model
{
    public function spare_parts(){
        return $this->belongsToMany('App\SparePart')
            ->withPivot('price','amount')
            ->withTimestamps();
    }
    public function shop(){
        return $this->belongsTo('App\Shop');
    }
}
