<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\SparePart;
use App\StockOut;
use App\StockIn;
use App\Machine;
use App\Shop;
use App\MachineCategory;
use App\Category;
use Carbon\Carbon;

class ReportController extends Controller
{

    public function index()
    {
        $data = array(
            'shops' => Shop::orderBy('name'),
            'machines' => Machine::orderBy('name'),
            'categories' => Category::orderBy('name'),
        );
        return view('reports.index')->with($data);
    }

    public function stockin_each_shop()
    {
        $stock_ins = StockIn::where('shop_id', '=', Input::get('shop'))
            ->inMonthAndYear(Input::get('month'), Input::get('year'))
            ->orderByDate('name', 'asc')->get();
        $total = 0;

        foreach ($stock_ins as $stock_in) {
            foreach ($stock_in->spare_parts as $spare_part) {
                $total += $spare_part->pivot->amount * $spare_part->pivot->price;
            }
        }

        $data = array(
            'stock_ins' => $stock_ins,
            'shops' => Shop::orderBy('name'),
            'total' => $total,
        );
        return view('reports.stockin_each_shop')->with($data);
    }

    public function stockout_each_machine()
    {
        $stock_outs = StockOut::where('machine_id', '=', Input::get('machine'))
            ->inMonthAndYear(Input::get('month'), Input::get('year'))
            ->orderByDate('name', 'asc')->get();
        $total = 0;

        foreach ($stock_outs as $stock_out) {
            foreach ($stock_out->spare_parts as $spare_part) {
                $total += $spare_part->pivot->amount * $spare_part->getLastPrice($spare_part->id);
            }
        }

        $data = array(
            'stock_outs' => $stock_outs,
            'machines' => Machine::orderBy('name'),
            'total' => $total,
            'machine' => Machine::find(Input::get('machine')),
        );
        return view('reports.stockout_each_machine')->with($data);
    }

    public function underminimum()
    {
        $spare_parts = SparePart::orderBy('name');
        return view('reports.underminimum')->with('spare_parts', $spare_parts);
    }

    public function each_category()
    {
        $month = Input::get('month');
        $year = Input::get('year');
        $monthBefore = $month;
        $yearBefore = $year;
        if ($month == 1) {
            $monthBefore = 12;
            $yearBefore = $year - 1;
        } else {
            $monthBefore -= 1;
        }
        $category = Category::find(Input::get('category'));
        $spare_parts = SparePart::where('category_id', '=', Input::get('category'))->orderBy('code')->get();
        $lastDate = null;
        if ($month < 10) {
            $lastDate = Carbon::createFromFormat('d-m-Y', '01-0' . $month . '-' . $year)->endOfMonth();
        } else {
            $lastDate = Carbon::createFromFormat('d-m-Y', '01-' . $month . '-' . $year)->endOfMonth();
        }
        $code = [];
        $description = [];
        $price_per_unit = [];
        $bring_forward = [];
        $in = [];
        $out = [];
        $carry_forward = [];

        $index = 0;
        foreach ($spare_parts as $spare_part) {
            $code[$index] = $spare_part->code;
            $description[$index] = $spare_part->description;
            $price_per_unit[$index] = $spare_part->getPriceBeforeDate($lastDate);

            $bring_forward_out = 0;
            $bring_forward_out += $spare_part
                ->stock_outs()
                ->fromBeginToMonthAndYear($monthBefore, $yearBefore)
                ->sum('amount');

            $bring_forward_in = 0;
            $bring_forward_in += $spare_part
                ->stock_ins()
                ->fromBeginToMonthAndYear($monthBefore, $yearBefore)
                ->sum('amount');

            $bring_forward[$index] = $bring_forward_in + $bring_forward_out;

            $in[$index] = 0;
            $in[$index]  += $spare_part->stock_ins()->inMonthAndYear($month, $year)->sum('amount');

            $out[$index] = 0;
            $out[$index]  += $spare_part->stock_outs()->inMonthAndYear($month, $year)->sum('amount');

            $carry_forward[$index] = $bring_forward[$index] + $in[$index] + $out[$index];
            $index = $index + 1;
        }

        $data = array(
            'month' => $month,
            'year' => $year,
            'code' => $code,
            'description' => $description,
            'price_per_unit' => $price_per_unit,
            'bring_forward' => $bring_forward,
            'in' => $in,
            'out' => $out,
            'carry_forward' => $carry_forward,
            'spare_parts' => $spare_parts,
            'category' => $category,
        );
        return view('reports.each_category')->with($data);
    }

    public function conclusion_each_month()
    {
        $year = Input::get('year');

        $in = [];
        $out = [];

        $count = 0;
        for ($i = 0; $i < 12; $i++) {
            $in[$count] = $this->getTotalCostIn($i + 1, $year);
            $out[$count] = $this->getTotalCostOut($i + 1, $year) * -1;
            $count++;
        }

        $data = array(
            'year' => $year,
            'in' => $in,
            'out' => $out,
        );

        return view('reports.conclusion_each_month')->with($data);
    }

    /*
    public function conclusion()
    {
        $START_YEAR = 2017;
        $last_year = 2018;
        $this_year = 2019;

        $in_last_year = 0; 
        $out_last_year = 0; 

        $in_last_year = $this->getTotalCostForStockIn($last_year);
        $out_last_year = $this->getTotalCostForStockOut($last_year);
        
        //$in_last_year = 15285402.25; // SUM of In from 2017..2018
        //$out_last_year = -12531365.57; // SUM of Out from 2017..2018

        $previous_remain = $in_last_year + $out_last_year;
        $in = [];
        $out = [];
        $remain = [];

        for ($i = 1; $i <= 12; $i++) {
            $in[$i - 1] = $this->getTotalCostIn($i, $this_year);
            $out[$i - 1] = $this->getTotalCostOut($i, $this_year) * -1;
            $remain[$i - 1] = $in[$i - 1] - $out[$i - 1] + $previous_remain;
            $previous_remain = $remain[$i - 1];
        }

        $data = array(
            'last_year' => $last_year,
            'this_year' => $this_year,
            'previous_remain' => $in_last_year + $out_last_year,
            'in_last_year' => $in_last_year,
            'out_last_year' => 0 - $out_last_year,
            'in' => $in,
            'out' => $out,
            'remain' => $remain,
        );
        return view('reports.conclusion')->with($data);
    }*/
    public function conclusion()
    {
        // Start Year = 2017
        $start_year = 2017;
        $this_year = now()->year;
        $year_amount = $this_year - $start_year;

        $in = [];
        $out = [];
        $remain = [];

        $count = 0;
        $last_remain = 0;
        for ($j = 0; $j < $year_amount; $j++) {
            for ($i = 0; $i < 12; $i++) {
                $in[$count] = $this->getTotalCostIn($i + 1, $start_year + $j);
                $out[$count] = $this->getTotalCostOut($i + 1, $start_year + $j) * -1;
                $last_remain +=  $in[$count] - $out[$count];
                $remain[$count] = $last_remain;

                $count++;
            }
        }

        $data = array(
            'start_year' => $start_year,
            'year_amount' => $year_amount,
            'in' => $in,
            'out' => $out,
            'remain' => $remain,
            'count' => 0,
        );

        return view('reports.conclusion')->with($data);
    }

    public function getTotalCostIn($month, $year)
    {
        $total = 0;
        $stock_ins = StockIn::inMonthAndYear($month, $year)->get();

        foreach ($stock_ins as $stock_in) {
            $total += $stock_in->getTotalPrice();
        }
        return $total;
    }

    public function getTotalCostOut($month, $year)
    {
        $stock_outs = StockOut::inMonthAndYear($month, $year)->get();
        $total = 0;

        foreach ($stock_outs as $stock_out) {
            $total += $stock_out->getTotalPrice();
        }
        return $total;
    }

    public function getTotalCostForStockIn($year)
    {
        $stock_ins = StockIn::inYear($year)->get();
        $total = 0;

        foreach ($stock_ins as $stock_in) {
            $total += $stock_in->getTotalPrice();
            //$total += $stock_in->spare_parts->count();
        }

        return $total;
    }

    public function getTotalCostForStockOut($year)
    {
        $stock_outs = StockOut::inYear($year)->get();
        $total = 0;

        foreach ($stock_outs as $stock_out) {
            //$total += $stock_out->spare_parts->count();
            $total += $stock_out->getTotalPrice();
        }

        return $total;
    }
}
