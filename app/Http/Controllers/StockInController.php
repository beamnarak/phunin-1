<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\StockIn;
use App\Shop;
use App\SparePart;
use Validator;

class StockInController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show', 'fix_date']]);
    }

    public function index()
    {
        $stock_ins = StockIn::orderBy('created_at', 'desc')->paginate(10);
        return view('stock_ins.index')->with('stock_ins', $stock_ins);
    } 
    
    // สำหรับแก้ไขวันที่ใน Pivot
    /*
    public function fix_date()
    {
        $stock_ins = StockIn::where('order_id','like','%x%')->get();

        foreach($stock_ins as $stock_in){
            foreach($stock_in->spare_parts as $spare_part){
                $stock_in->spare_parts()->sync([$spare_part->id => ['date' => '2017-12-30']], false);
            }
        }
        $stock_ins = StockIn::where('order_id','like','%x%')->get();

        return view('stock_ins.fix_date')->with('stock_ins', $stock_ins);
    } */
/*
    public function delete_x()
    {
        $stock_ins = StockIn::where('order_id','like','%x%')->get();
        foreach($stock_ins as $stock_in){
            $s = StockIn::find($stock_in->id);

            $s->spare_parts()->detach();
            $s->delete();
        }

        $stock_ins = StockIn::orderBy('created_at','desc')->paginate(10);
        return view('stock_ins.index')->with('stock_ins', $stock_ins);
    }
     */
    public function search(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        if ($start_date == '') {
            return redirect()->route('stock_ins.index')->with('error', 'ข้อมูลค้นหาไม่ถูกต้อง');
        }

        if ($end_date == '') {
            $end_date = $start_date;
        }

        $stock_ins = StockIn::whereHas('spare_parts', function ($q) use ($start_date, $end_date) {
            $q->whereBetween('date', array($start_date, $end_date))->distinct();
        })->paginate(100000000);

        $data = array(
            'stock_ins' => $stock_ins,
        );
        return view('stock_ins.index')->with($data);
    }
    public function searchByPID(Request $request)
    {
        $keyword = $request->input('keyword');
        $result = StockIn::where('order_id', 'like', '%' . $keyword . '%')
            ->orderBy('order_id', 'asc')->distinct()->paginate(1000000000);
        return view('stock_ins.index')->with('stock_ins', $result);
    }

    /**
     * Show the form for creating a new resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array(
            'shops' => Shop::orderBy('name', 'asc')->get(),
            'spare_parts' => SparePart::orderBy('code', 'asc')->get(),
        );
        return view('stock_ins.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'order_id' => array(
                'required',
                'unique:stock_ins,order_id',
                'regex:/^[yexz]?[0-9]{3}\/[0-9]{5}\-[0-9]{2}$/u'
            ),
            'date' => 'required',
            'shop_id' => 'required',
        ]);
   
        // save stock_in
        $stock_in = new StockIn;
            
        //$stock_in->order_id = $request->input('order_id');
        $stock_in->order_id = preg_replace('!\s+!', ' ', $request->input('order_id'));

        $stock_in->shop_id = $request->input('shop_id');
        $stock_in->note = $request->input('note');
        $stock_in->user_id = auth()->user()->id;
        
        // save pivot
        $spds = $request->input('spare_part_ids');
        $prices = $request->input('prices');
        $qtys = $request->input('qtys');
        $date = $request->input('date');

        $flag = 0;
        if ($spds == null) {
            $flag = 1;
        } elseif (count($spds) != count($qtys) || count($spds) != count($prices) || count($prices) != count($qtys)) {
            $flag = 1;
            return redirect()->back()->withInput()->with('error', 'คุณใส่ข้อมูลไม่ครบ');
        } else {
            for ($i = 0; $i < count($spds); $i++) {
                if ($spds[$i] == null) {
                    $flag = 1;
                }
            }
        }

        if ($flag == 1) {
            return redirect()->back()->withInput()->with('error', 'กรุณาเลือกข้อมูลอะไหล่');
        }

        // check array must not duplicate
        if (count(array_unique($spds)) < count($spds)) {
            return redirect()->back()->withInput()->with('error', 'ข้อมูลอะไหล่ซ้ำกันไม่ได้');
        } else {
            $stock_in->save();
            $sid = StockIn::where('order_id', '=', $request->input('order_id'))->first()->id;

            for ($i = 0; $i < count($spds); $i++) {
                if ($qtys[$i] < 0 || $qtys[$i] == null) $qtys[$i] = 0;
                if ($prices[$i] < 0 || $prices[$i] == null) $prices[$i] = 0;
                $spare_part = SparePart::find($spds[$i]);
                $spare_part->stock_ins()->attach($sid, ['amount' => $qtys[$i], 'price' => $prices[$i], 'date' => $date]);
            }
            return redirect('/stock_ins')->with('success', 'StockIn created');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $stock_in = StockIn::find($id);
        return view('stock_ins.show')->with('stock_in', $stock_in);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        /*
        $stock_in = StockIn::find($id);
        
        if(auth()->user()->id !== $stock_in->user_id){
            return redirect()->route('stock_ins.index')->with('error', 'Unauthorized Page');
        }

        return view('stock_ins.edit')->with('stock_in',$stock_in);
         */
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /*
        $this->validate($request, [
            'name' => 'required|string|unique:stock_ins,name,'.$id,
        ]);
        $stock_in = StockIn::find($id);
        $stock_in->name = $request->input('name');
        $stock_in->user_id = auth()->user()->id;
        $stock_in->save();

        return redirect('/stock_ins')->with('success','StockIn updated');
         */
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $stock_in = StockIn::find($id);

        /*
        if(auth()->user()->id !== $stock_in->user_id){
            return redirect()->route('stock_ins.index')->with('error', 'Unauthorized Page');
        }*/

        $stock_in->spare_parts()->detach();
        $stock_in->delete();

        return redirect('/stock_ins')->with('success', 'StockIn Removed');
    }

}
