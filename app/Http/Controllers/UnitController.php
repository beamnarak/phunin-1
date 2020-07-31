<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Unit;

class UnitController extends Controller
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
        $data = array(
            'units' => Unit::orderBy('created_at','desc')->paginate(10),
        );
       
        return view('units.index')->with($data);
    }

    public function search(Request $request)
    {
        $units = Unit::orderBy('created_at','desc')->paginate(10);
        if($request->input('keyword') != '')
        {

        }

        $data = array(
            'units' => $units,
        );

        return view('units.index')->with($data);
    }

     /* Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('units.create');
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
            'name' => 'required|string|unique:units,name',
        ]);

        $unit = new Unit;
        $unit->name = preg_replace('!\s+!', ' ', $request->input('name'));
        //$unit->name = $request->input('name');
        $unit->user_id = auth()->user()->id;
        $unit->save();

        return redirect('/units')->with('success','Unit created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $unit = Unit::find($id);
        return view('units.show')->with('unit', $unit);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $unit = Unit::find($id);
        /*
        if(auth()->user()->id !== $unit->user_id){
            return redirect()->route('units.index')->with('error', 'Unauthorized Page');
        }*/

        return view('units.edit')->with('unit',$unit);
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
            'name' => 'required|string|unique:units,name,'.$id,
        ]);
        $unit = Unit::find($id);
        $unit->name = preg_replace('!\s+!', ' ', $request->input('name'));
        //$unit->name = $request->input('name');
        $unit->user_id = auth()->user()->id;
        $unit->save();

        return redirect('/units')->with('success','Unit updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $unit = Unit::find($id);
        
        $unit->delete();

        return redirect('/units')->with('success','Unit Removed');
    }
}
