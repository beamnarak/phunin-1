<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SparePart;
use App\Category;
use App\Unit;
use App\Position;

class SparePartController extends Controller
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
        $spare_parts = SparePart::orderBy('created_at')->paginate(10);
        return view('spare_parts.index')->with('spare_parts', $spare_parts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array(
            'units' => Unit::all(),
            'positions' => Position::all(),
            'categories' => Category::all(),
        );
        return view('spare_parts.create')->with($data);
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
            'code' => 'required|string|unique:spare_parts,code',
            'category_id' => 'required',
            'position_id' => 'required',
            'unit_id' => 'required',
        ]);

        $spare_part = new SparePart;

        $spare_part->code = $request->input('code');
        $spare_part->description = $request->input('description');
        $spare_part->note = $request->input('note');
        $spare_part->category_id = $request->input('category_id');
        $spare_part->position_id = $request->input('position_id');
        $spare_part->unit_id = $request->input('unit_id');

        $spare_part->user_id = auth()->user()->id;
        $spare_part->save();

        return redirect('/spare_parts')->with('success','SparePart created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $spare_part = SparePart::find($id);
        return view('spare_parts.show')->with('spare_part', $spare_part);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $spare_part = SparePart::find($id);
        
        if(auth()->user()->id !== $spare_part->user_id){
            return redirect()->route('spare_parts.index')->with('error', 'Unauthorized Page');
        }

        return view('spare_parts.edit')->with('spare_part',$spare_part);
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
            'code' => 'required|string|unique:spare_parts,code,'.$id,
            'category_id' => 'required',
            'position_id' => 'required',
            'unit_id' => 'required',
        ]);

        $spare_part = SparePart::find($id);

        $spare_part->code = $request->input('code');
        $spare_part->description = $request->input('description');
        $spare_part->note = $request->input('note');
        $spare_part->category_id = $request->input('category_id');
        $spare_part->position_id = $request->input('position_id');
        $spare_part->unit_id = $request->input('unit_id');

        $spare_part->user_id = auth()->user()->id;
        $spare_part->save();

        return redirect('/spare_parts')->with('success','SparePart updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $spare_part = SparePart::find($id);
        
        $spare_part->delete();

        return redirect('/spare_parts')->with('success','SparePart Removed');
    }
}
