<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockOut extends Model
{
    public function spare_parts(){
        return $this->belongsToMany('App\SparePart')
            ->withPivot('amount')
            ->withTimestamps();
    }
    public function employee(){
        return $this->belongsTo('App\Employee');
    }
    public function machine(){
        return $this->belongsTo('App\Machine');
    }
}
