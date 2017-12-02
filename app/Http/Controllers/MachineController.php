<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Machine;

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
        $machines = Machine::orderBy('created_at','asc')->paginate(10);
        return view('machines.index')->with('machines', $machines);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('machines.create');
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
        ]);

        $machine = new Machine;
        $machine->name = $request->input('name');
        $machine->description = $request->input('description');
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
        $machine = Machine::find($id);
        return view('machines.show')->with('machine', $machine);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $machine = Machine::find($id);
        
        if(auth()->user()->id !== $machine->user_id){
            return redirect()->route('machines.index')->with('error', 'Unauthorized Page');
        }

        return view('machines.edit')->with('machine',$machine);
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
        $machine->name = $request->input('name');
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
