<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\StockOut;
use App\StockIn;
use App\Repairment;
use App\SpartPart;
use Charts;
use DB;
use App\MachineCategory;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   /*
        $data = getChart();
        return view('home')->with($data);
        */
        $today = Carbon::today();
    
        $results = collect();
        $stock_ins = StockIn::orderBy('created_at','desc')
                            ->whereDate('created_at','=',Carbon::today()->toDateString())
                            ->get();
        $stock_outs = StockOut::orderBy('created_at','desc')
                            ->whereDate('created_at','=',Carbon::today()->toDateString())
                            ->get();

        foreach($stock_ins as $in){
            $results->push($in);
        }

        foreach($stock_outs as $out){
            $results->push($out);
        }

        $data = array(
            'date' => $today->day,  
            'month' => $today->month,
            'year' => $today->year,
            'results' => $results->sortByDESC('created_at')
        );
        return view('home')->with($data);
    }


    public function getRepairmentCostsMonthlySumInYear($year, $option)
    {
        $sum = 0;
        $sums = [];
        for ($i = 1; $i <= 12; $i++) {
            $sum = 0;
            $repairments = Repairment::inMonthAndYear($i, $year);

            foreach ($repairments as $r) {
                if ($option == 'pro' && $r->machine->machine_category->name == 'งานผลิต') {
                    $sum += $r->getTotal();
                } elseif ($option == 'tra' && $r->machine->machine_category->name == 'งานขนส่ง') {
                    $sum += $r->getTotal();
                }
            }
            $sums[$i - 1] = $sum;
        }

        return $sums;
    }

    public function getChart(){
        $pro_sums = StockOut::getMonthlySumInYear(2019, 'pro');
        $tran_sums = StockOut::getMonthlySumInYear(2019, 'tra');
        $repair_costs_in_prod = $this->getRepairmentCostsMonthlySumInYear(2019, 'pro');
        $repair_costs_in_trans = $this->getRepairmentCostsMonthlySumInYear(2019, 'tra');

        for ($i = 0; $i < 12; $i++) {
            $sums[$i] = $pro_sums[$i] + $tran_sums[$i] + $repair_costs_in_prod[$i] + $repair_costs_in_trans[$i];
        }
            //$sums = $pro_sums + $tran_sums;

        $chart = Charts::multi('areaspline', 'highcharts')
                //->loader(true)->loaderColor('#FF0000')
                //->elementLabel('ยอดเงิน (บาท)')
            ->title('ค่าใช้จ่ายคิดจากการเบิกอะไหล่ประจำปี 2018')
            ->colors(['#001122', '#99ccff', '#556677', '#223366', '#3366aa'])
            ->labels([
                'ม.ค.', 'ก.พ.', 'มี.ค.',
                'เม.ย.', 'พ.ค.', 'มิ.ย.',
                'ก.ค.', 'ส.ค.', 'ก.ย.',
                'ต.ค.', 'พ.ย.', 'ธ.ค.'
            ])
                //->values($sums)
            ->dataset('รวม', $sums)
            ->dataset('ผลิต', $pro_sums)
            ->dataset('งานซ่อม-ผลิต', $repair_costs_in_prod)
            ->dataset('ขนส่ง', $tran_sums)
            ->dataset('งานซ่อม-ขนส่ง', $repair_costs_in_trans)
            ->dimensions(0, 500);

        $data = array(
            'chart' => $chart,  // put {!! $chart->html() !!} to b;ade for renderring chart
            'sums' => $sums,
            'machine_categories' => MachineCategory::all(),
        );

        return $data;
    }
}
