<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Machine;
use App\StockOut;
use App\MachineCategory;
use App\Repairment;

class MachineController extends Controller
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
        $machines = Machine::orderBy('created_at','desc')->paginate(10);
        return view('machines.index')->with('machines', $machines);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array(
            'machine_categories' => MachineCategory::orderBy('name','asc'),
        );
        return view('machines.create')->with($data);
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
            'name' => 'required|string|unique:machines,name',
            'machine_category_id' => 'required',
        ]);

        $machine = new Machine;
        $machine->name = preg_replace('!\s+!', ' ', $request->input('name'));
        //$machine->name = $request->input('name');
        $machine->description = $request->input('description');
        $machine->machine_category_id = $request->input('machine_category_id');
        $machine->user_id = auth()->user()->id;
        $machine->save();

        return redirect('/machines')->with('success','Machine created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = array(
            'machine' => Machine::find($id),
            'stock_outs' => StockOut::where('machine_id','=',$id)
                            ->orderBy('request_id','desc')
                            ->get(),
            'repairments' => Repairment::where('machine_id','=',$id)
                            ->orderBy('end_date','desc')
                            ->get(),
        );
        return view('machines.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $data = array(
            'machine_categories' => MachineCategory::orderBy('name','asc'),
            'machine' => Machine::find($id),
        );
        /*
        if(auth()->user()->id !== $machine->user_id){
            return redirect()->route('machines.index')->with('error', 'Unauthorized Page');
        }
        */
        
        return view('machines.edit')->with($data);
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
        $this->validate($request, [
            'name' => 'required|string|unique:machines,name,'.$id,
        ]);
        $machine = Machine::find($id);
        $machine->name = preg_replace('!\s+!', ' ', $request->input('name'));
        $machine->machine_category_id = $request->input('machine_category_id');
        //$machine->name = $request->input('name');
        $machine->description = $request->input('description');
        $machine->user_id = auth()->user()->id;
        $machine->save();

        return redirect('/machines')->with('success','Machine updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $machine = Machine::find($id);
        
        $machine->delete();

        return redirect('/machines')->with('success','Machine Removed');
    }
}
