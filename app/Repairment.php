<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Repairment extends Model
{

    protected $fillable = [
        'start_date', 'end_date', 'shop_id',
        'machine_id', 'wage_cost', 'travel_cost',
        'accommodation_fee', 'spare_part_cost', 'delivery_cost',
        'clearance_cost', 'description', 'payment_list'
    ];

    public function machine()
    {
        return $this->belongsTo('App\Machine');
    }

    public function shop()
    {
        return $this->belongsTo('App\Shop');
    }

    public function getTotal()
    {
        $total = 0;
        if ($this) {
            $total = $this->wage_cost +
                $this->travel_cost +
                $this->accommodation_fee +
                $this->spare_part_cost +
                $this->delivery_cost;
        }
        return $total;
    }

    public function scopeInMonthAndYear($q, $month, $year)
    {
        $start_date = null;
        $end_date = null;
        if ($month < 10) {
            $start_date = Carbon::createFromFormat('m-Y', '0' . $month . '-' . $year)->startOfMonth();
        } else {
            $start_date = Carbon::createFromFormat('m-Y', $month . '-' . $year)->startOfMonth();
        }
        $end_date = clone $start_date;
        $end_date = $end_date->endOfMonth();
        $start_date = $start_date->format('Y-m-d');
        $end_date = $end_date->format('Y-m-d');

        return $q->whereBetween('end_date', array($start_date, $end_date))->get();
    }
}
