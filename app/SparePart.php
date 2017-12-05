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

    public function stock_ins(){
        return $this->belongsToMany('App\StockIn')
            ->withPivot('price','amount')
            ->withTimestamps();
    }
    public function stock_outs(){
        return $this->belongsToMany('App\StockOut')
            ->withPivot('amount')
            ->withTimestamps();
    }

    public function getTotalAmount(){
        $in_amount = $this->stock_ins()->sum('amount');
        $out_amount = $this->stock_outs()->sum('amount');

        return $in_amount-$out_amount;
    }
}
