<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\StockOut;
use App\Machine;
use App\SparePart;
use App\Employee;
use Validator;

class StockOutController extends Controller
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
        $stock_outs = StockOut::orderBy('date')->paginate(10);
        return view('stock_outs.index')->with('stock_outs', $stock_outs);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array(
            'machines' => Machine::all(),
            'employees' => Employee::all(),
            'spare_parts' => SparePart::all(),
        );
        return view('stock_outs.create')->with($data);
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
            'request_id' => 'required|unique:stock_outs,request_id',
            'date' => 'required',
            'machine_id' => 'required',
            'employee_id' => 'required',
        ]);

        // save stock_out
        $stock_out = new StockOut;
        $stock_out->request_id = $request->input('request_id');
        $stock_out->machine_id = $request->input('machine_id');
        $stock_out->employee_id = $request->input('employee_id');
        $stock_out->date = $request->input('date');
        $stock_out->note = $request->input('note');
        $stock_out->user_id = auth()->user()->id;
        
        // save pivot
        $spds = $request->input('spare_part_ids');
        $qtys = $request->input('qtys');

        // check array must not duplicate
        if(count(array_unique($spds))<count($spds))
        {
            return redirect()->back()->withInput()->with('error','ข้อมูลอะไหล่ซ้ำกันไม่ได้');
        }
        else
        {
            $stock_out->save();
            $sid = StockOut::where('request_id','=',$request->input('request_id'))->first()->id;
            
            for($i = 0; $i<count($spds); $i++){
                if($qtys[$i]<=0) $qtys[$i] = 1;
                $spare_part = SparePart::find($spds[$i]);
                $spare_part->stock_outs()->attach($sid,['amount'=>$qtys[$i]]);
            }
            return redirect('/stock_outs')->with('success','StockOut created');
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
        $stock_out = StockOut::find($id);
        return view('stock_outs.show')->with('stock_out', $stock_out);
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
        $stock_out = StockOut::find($id);
        
        if(auth()->user()->id !== $stock_out->user_id){
            return redirect()->route('stock_outs.index')->with('error', 'Unauthorized Page');
        }

        return view('stock_outs.edit')->with('stock_out',$stock_out);
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
            'name' => 'required|string|unique:stock_outs,name,'.$id,
        ]);
        $stock_out = StockOut::find($id);
        $stock_out->name = $request->input('name');
        $stock_out->user_id = auth()->user()->id;
        $stock_out->save();

        return redirect('/stock_outs')->with('success','StockOut updated');
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
        $stock_out = StockOut::find($id);
        $stock_out->spare_parts()->detach();
        $stock_out->delete();

        return redirect('/stock_outs')->with('success','StockOut Removed');
    }
}
