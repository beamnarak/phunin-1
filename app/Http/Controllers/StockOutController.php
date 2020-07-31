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
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    public function index()
    {
        $stock_outs = StockOut::orderBy('created_at', 'desc')->paginate(10);
        return view('stock_outs.index')->with('stock_outs', $stock_outs);
    }

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

        $stock_outs = StockOut::whereHas('spare_parts', function ($q) use ($start_date, $end_date) {
            $q->whereBetween('date', array($start_date, $end_date));
        })->orderBy('request_id', 'asc')->paginate(10000000000);

        $data = array(
            'stock_outs' => $stock_outs,
        );
        return view('stock_outs.index')->with($data);
    }

    public function searchByRID(Request $request)
    {
        $keyword = $request->input('keyword');
        $result = StockOut::where('request_id', 'like', '%' . $keyword . '%')
            ->orderBy('request_id', 'asc')->distinct()->paginate(1000000000);
        $data = array(
            'stock_outs' => $result,
            'count' => $result->count()
        );
        return view('stock_outs.index')->with($data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array(
            'machines' => Machine::orderBy('name', 'asc')->get(),
            'employees' => Employee::orderBy('name', 'asc')->get(),
            'spare_parts' => SparePart::orderBy('code', 'asc')->get(),
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
            'request_id' => array(
                'required',
                'unique:stock_outs,request_id',
                'regex:/^[exz]?[0-9]{3}\/[0-9]{5}$/u' // e: edit each In or Out
            ),
            'date' => 'required',
            'machine_id' => 'required',
            'employee_id' => 'required',
        ]);

        // save stock_out
        $stock_out = new StockOut;
        
        //$stock_out->request_id = $request->input('request_id');
        $stock_out->request_id = preg_replace('!\s+!', ' ', $request->input('request_id'));

        $stock_out->machine_id = $request->input('machine_id');
        $stock_out->employee_id = $request->input('employee_id');
        $stock_out->note = $request->input('note');
        $stock_out->user_id = auth()->user()->id;
        
        // save pivot
        $spds = $request->input('spare_part_ids');
        $qtys = $request->input('qtys');
        $date = $request->input('date');

        if ($spds == null || count($spds) == 0 || count($qtys) == 0) {
            return redirect()->back()->withInput()->with('error', 'กรุณาใส่ข้อมูลอะไหล่ - 1');
        } elseif (count($spds) != count($qtys)) {
            return redirect()->back()->withInput()->with('error', 'คุณใส่ข้อมูลไม่ครบ - 2');
        } else {
            for ($i = 0; $i < count($spds); $i++) {
                if ($spds[$i] == null) {
                    return redirect()->back()->withInput()->with('error', 'คุณใส่ข้อมูลไม่ครบ - 3');
                }
            } 
        }

        // check array must not duplicate
        if (count(array_unique($spds)) < count($spds)) {
            return redirect()->back()->withInput()->with('error', 'ข้อมูลอะไหล่ซ้ำกันไม่ได้');
        } else {
            $stock_out->save();
            $sid = StockOut::where('request_id', '=', $request->input('request_id'))->first()->id;

            for ($i = 0; $i < count($spds); $i++) {
                if ($qtys[$i] <= 0 || $qtys[$i] == null) $qtys[$i] = 1;
                $spare_part = SparePart::find($spds[$i]);
                $spare_part->stock_outs()->attach($sid, ['amount' => $qtys[$i] * -1, 'date' => $date]);
            }
            return redirect('/stock_outs')->with('success', 'StockOut created');
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
        /*
        if(auth()->user()->id !== $stock_out->user_id){
            return redirect()->route('stock_outs.index')->with('error', 'Unauthorized Page');
        }*/

        $stock_out->spare_parts()->detach();
        $stock_out->delete();

        return redirect('/stock_outs')->with('success', 'StockOut Removed');
    }
}
