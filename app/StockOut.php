<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;
use Log;

class StockOut extends Model
{
    /*
        request_id
        machine_id 
        employee_id
        note
        user_id
     */
    public function spare_parts()
    {
        return $this->belongsToMany('App\SparePart')
            ->withPivot('amount', 'date')
            ->withTimestamps();
    }
    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }
    public function machine()
    {
        return $this->belongsTo('App\Machine');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }


    public function getTotalPrice()
    {
        $total = 0;
        foreach ($this->spare_parts as $spare_part) {
            $total += $spare_part->pivot->amount * $spare_part->getLastPrice($spare_part->id);
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
        Log::info('Model:StockOut/Function:scopeInMonthAndYear');

        $start_date = null;
        $end_date = null;
        if ($month < 10) {
            $start_date = Carbon::createFromFormat('d-m-Y', '01-0' . $month . '-' . $year)->startOfMonth();
        } else {
            $start_date = Carbon::createFromFormat('d-m-Y', '01-' . $month . '-' . $year)->startOfMonth();
        }

        $end_date = clone $start_date;

        Log::info('Month:' . $month . '==' . $end_date);

        $end_date = $end_date->endOfMonth();
        $start_date = $start_date->format('Y-m-d');

        Log::info('End of Month:' . $end_date->endOfMonth());
        Log::info('Start Date:' . $start_date);
        Log::info('End Date:' . $end_date);

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

    public function getTotalPriceOfMachineInMonthAndYear($machine_id, $month, $year)
    {
        $price = 0;

        $stock_outs = StockOut::inMonthAndYear($month, $year)
            ->where('machine_id', '=', $machine_id)->get();

        foreach ($stock_outs as $s) {
            foreach ($s->spare_parts as $spare_part) {
                $price += $spare_part->getLastPrice($spare_part->id) * $spare_part->pivot->amount * -1;
            }
        }

        return $price;
    }

    public static function getMonthlySumInYear($year, $option)
    {
        // option =  ['all','pro','tra']
        $sum = 0;
        $sums = [];
        for ($i = 1; $i <= 12; $i++) {
            $sum = 0;
            /*
            if($i<10){
                $start_date = Carbon::createFromFormat('m-Y', '0'.$i.'-'.$year)->startOfMonth();
            }else {
                $start_date = Carbon::createFromFormat('m-Y', $i.'-'.$year)->startOfMonth();
            }
            $end_date = clone $start_date;
            $end_date = $end_date->endOfMonth();
            $start_date = $start_date->format('Y-m-d');
            $end_date = $end_date->format('Y-m-d');

            $stock_outs = StockOut::whereHas('spare_parts', function ($q) use ($start_date,$end_date){
                $q->whereBetween('date',array($start_date,$end_date));
            })->get();
             */
            $stock_outs = StockOut::inMonthAndYear($i, $year)->get();

            Log::info('Model:StockOut/Function:getMonthlySumInYear');
            Log::info($i . 'count:' . $stock_outs->count());

            foreach ($stock_outs as $s) {
                if ($option == 'all') {
                    foreach ($s->spare_parts as $spare_part) {
                        if ($spare_part)
                        //$sum += $spare_part->getLastPrice($spare_part->id) * $spare_part->pivot->amount * -1;
                        $sum += $spare_part->getPriceBeforeDate($s->spare_parts->first()->pivot->date) * $spare_part->pivot->amount * -1;
                    }
                } elseif ($option == 'pro') {
                    if ($s->machine->machine_category->name == 'งานผลิต') {
                        foreach ($s->spare_parts as $spare_part) {
                            if ($spare_part)
                            //$sum += $spare_part->getLastPrice($spare_part->id) * $spare_part->pivot->amount * -1;
                            $sum += $spare_part->getPriceBeforeDate($s->spare_parts->first()->pivot->date) * $spare_part->pivot->amount * -1;
                        }
                    }
                } elseif ($option == 'tra') {
                    if ($s->machine->machine_category->name == 'งานขนส่ง') {
                        foreach ($s->spare_parts as $spare_part) {

                            if ($spare_part)
                            //$sum += $spare_part->getLastPrice($spare_part->id) * $spare_part->pivot->amount * -1;
                            $sum += $spare_part->getPriceBeforeDate($s->spare_parts->first()->pivot->date) * $spare_part->pivot->amount * -1;
                        }
                    }
                }
            }
            Log::info($i . ':' . $sum);
            $sums[$i - 1] = $sum;
        }
        return $sums;
    }

    /*
    $stock_ins = StockIn::whereHas('spare_parts', function ($q) use ($start_date,$end_date){
            $q->whereBetween('date',array($start_date,$end_date))->distinct();
        })->paginate(100000000);
     */
    public function scopeOrderByDate($qr, $sort)
    {
        return $qr->whereHas('spare_parts', function ($q) use ($sort) {
            $q->orderBy('date', $sort);
        });
    }
}