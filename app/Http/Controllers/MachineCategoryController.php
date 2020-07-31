<?php

namespace App\Http\Controllers;

use App\MachineCategory;
use Illuminate\Http\Request;

class MachineCategoryController extends Controller
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
        $machine_categories = MachineCategory::orderBy('created_at','desc')->paginate(10);
        return view('machine_categories.index')->with('machine_categories', $machine_categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('machine_categories.create');
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
            'name' => 'required|string|unique:machine_categories,name',
            'group' => 'required|string',
        ]);

        $machine_category = new MachineCategory;
        $machine_category->name = $request->input('name');
        $machine_category->group = $request->input('group');
        $machine_category->user_id = auth()->user()->id;
        $machine_category->save();

        return redirect('/machine_categories')->with('success','Machine Category created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MachineCategory  $machineCategory
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = array(
            $machine_category = MachineCategory::find($id),
        );
        return view('machine_categories.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MachineCategory  $machineCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $machine_category = MachineCategory::find($id);
        
        /*
        if(auth()->user()->id !== $machine->user_id){
            return redirect()->route('machines.index')->with('error', 'Unauthorized Page');
        }
        */
        
        return view('machine_categories.edit')->with('machine_category',$machine_category);
    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MachineCategory  $machineCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $this->validate($request, [
            'name' => 'required|string|unique:machine_categories,name,'.$id,
            'group' => 'required|string',
        ]);

        $machine_category = new MachineCategory;
        $machine_category->name = $request->input('name');
        $machine_category->group = $request->input('group');
        $machine_category->user_id = auth()->user()->id;
        $machine_category->save();

        return redirect('/machine_categories')->with('success','Machine Category updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MachineCategory  $machineCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $machine_category = Machine::find($id);
        
        $machine_category->delete();

        return redirect('/machine_categories')->with('success','Machine Category Removed');
    }
}
