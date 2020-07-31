<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Log;
use Carbon\Carbon;


class SparePart extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function unit()
    {
        return $this->belongsTo('App\Unit');
    }

    public function position()
    {
        return $this->belongsTo('App\Position');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function stock_ins()
    {
        return $this->belongsToMany('App\StockIn')
            ->withPivot('price', 'amount', 'date')
            ->withTimestamps();
    }
    public function stock_outs()
    {
        return $this->belongsToMany('App\StockOut')
            ->withPivot('amount', 'date')
            ->withTimestamps();
    }

    public function getTotalAmount()
    {
        $in_amount = $this->stock_ins()->sum('amount');
        $out_amount = $this->stock_outs()->sum('amount') * -1;

        return $in_amount - $out_amount;
    }

    public function getLastPrice($id)
    {
        $price = 0;
        if (SparePart::find($id))
            if (count(SparePart::find($id)->stock_ins()->get()) > 0) {
            //Log::info('##spare_part id: '.$id.' || '.count(SparePart::find($id)->stock_ins()->get()));

            $price = SparePart::find($id)->stock_ins()
                ->orderBy('spare_part_stock_in.date', 'desc')
                ->first()->pivot->price;
        }
        return $price;
    }

    public function getPriceBeforeDate($date)
    {
        $price = 0;
        if ($this->stock_ins()->count() > 0 && $date != null) {
            $stock_ins = $this->stock_ins()
                ->where('spare_part_stock_in.date', '<=', $date)
                ->orderBy('spare_part_stock_in.date', 'desc');

            if ($stock_ins->count() > 0) {
                $price = $stock_ins->first()->pivot->price;
            } else {
                $price = $this->stock_ins()
                    ->orderBy('spare_part_stock_in.date', 'desc')
                    ->first()->pivot->price;
            }
        }
        return $price;
    }

    public function getDetailAttribute()
    {
        return $this->attributes['code'] . ' | ' . $this->attributes['description'];
    }
}
