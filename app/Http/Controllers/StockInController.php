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
        $this->middleware('auth', ['except'=>['index','show']]);
    }

    public function index()
    {
        $stock_ins = StockIn::orderBy('date')->paginate(10);
        return view('stock_ins.index')->with('stock_ins', $stock_ins);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array(
            'shops' => Shop::all(),
            'spare_parts' => SparePart::all(),
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
            'order_id' => 'required|unique:stock_ins,order_id',
            'date' => 'required',
            'shop_id' => 'required',
        ]);

        // save stock_in
        $stock_in = new StockIn;
        $stock_in->order_id = $request->input('order_id');
        $stock_in->shop_id = $request->input('shop_id');
        $stock_in->date = $request->input('date');
        $stock_in->note = $request->input('note');
        $stock_in->user_id = auth()->user()->id;
        
        // save pivot
        $spds = $request->input('spare_part_ids');
        $prices = $request->input('prices');
        $qtys = $request->input('qtys');

        // check array must not duplicate
        if(count(array_unique($spds))<count($spds))
        {
            return redirect()->back()->withInput()->with('error','ข้อมูลอะไหล่ซ้ำกันไม่ได้');
        }
        else
        {
            $stock_in->save();
            $sid = StockIn::where('order_id','=',$request->input('order_id'))->first()->id;
            
            for($i = 0; $i<count($spds); $i++){
                if($qtys[$i]<=0) $qtys[$i] = 1;
                if($prices[$i]<=0) $prices[$i] = 1;
                $spare_part = SparePart::find($spds[$i]);
                $spare_part->stock_ins()->attach($sid,['amount'=>$qtys[$i],'price'=>$prices[$i]]);
            }
            return redirect('/stock_ins')->with('success','StockIn created');
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
        $stock_in->spare_parts()->detach();
        $stock_in->delete();

        return redirect('/stock_ins')->with('success','StockIn Removed');
    }
}
