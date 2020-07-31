<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class StockIn extends Model
{
    public function spare_parts()
    {
        return $this->belongsToMany('App\SparePart')
            ->withPivot('price', 'amount', 'date')
            ->withTimestamps();
    }
    public function shop()
    {
        return $this->belongsTo('App\Shop');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function getTotalPrice()
    {
        $total = 0;
        foreach ($this->spare_parts as $spare_part) {
            $total += $spare_part->pivot->amount * $spare_part->pivot->price;
        }
        return $total;
    }

    public function scopeInYear($qr, $year)
    {
        $start_date = Carbon::createFromFormat('d-m-Y', '01-01-' . $year)->format('Y-m-d');
        $end_date = Carbon::createFromFormat('d-m-Y', '31-12-' . $year)->format('Y-m-d');
        return $qr->whereHas('spare_parts', function ($q) use ($start_date, $end_date) {
            $q->whereBetween('date', array($start_date, $end_date));
        });
    }

    public function scopeInMonthAndYear($qr, $month, $year)
    {
        $start_date = null;
        $end_date = null;
        if ($month < 10) {
            $start_date = Carbon::createFromFormat('d-m-Y', '01-0' . $month . '-' . $year)->startOfMonth();
        } else {
            $start_date = Carbon::createFromFormat('d-m-Y', '01-' . $month . '-' . $year)->startOfMonth();
        }
        $end_date = clone $start_date;
        $end_date = $end_date->endOfMonth(); 
        $start_date = $start_date->format('Y-m-d');
        $end_date = $end_date->format('Y-m-d');

        return $qr->whereHas('spare_parts', function ($q) use ($start_date, $end_date) {
            $q->whereBetween('date', array($start_date, $end_date));
        });
    }


    public function scopeFromBeginToMonthAndYear($qr, $month, $year)
    {
        $end_date = null;
        $start_date = Carbon::createFromFormat('d-m-Y', '01-01-2017')->startOfMonth();
        if ($month < 10)
            $end_date = Carbon::createFromFormat('d-m-Y', '01-0'.$month.'-'.$year)->endOfMonth();
        else
            $end_date = Carbon::createFromFormat('d-m-Y', '01-'.$month.'-'.$year)->endOfMonth();
        $start_date = $start_date->format('Y-m-d');
        $end_date = $end_date->format('Y-m-d');

        return $qr->whereHas('spare_parts', function ($q) use ($start_date, $end_date) {
            $q->whereBetween('date', array($start_date, $end_date));
        });
    }

    public function scopeOrderByDate($qr, $sort)
    {
        return $qr->whereHas('spare_parts', function ($q) use ($sort) {
            $q->orderBy('date', $sort);
        });
    }
}
