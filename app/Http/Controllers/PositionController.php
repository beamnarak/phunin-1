<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Position;

class PositionController extends Controller
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
        $positions = Position::orderBy('created_at')->paginate(10);
        return view('positions.index')->with('positions', $positions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('positions.create');
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
            'code' => 'required|string|unique:positions,code',
        ]);

        $position = new Position;
        $position->code = $request->input('code');
        $position->description = $request->input('description');
        $position->user_id = auth()->user()->id;
        $position->save();

        return redirect('/positions')->with('success','Position created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $position = Position::find($id);
        return view('positions.show')->with('position', $position);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $position = Position::find($id);
        
        if(auth()->user()->id !== $position->user_id){
            return redirect()->route('positions.index')->with('error', 'Unauthorized Page');
        }

        return view('positions.edit')->with('position',$position);
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
            'code' => 'required|string|unique:positions,code,'.$id,
        ]);
        $position = Position::find($id);
        $position->code = $request->input('code');
        $position->description = $request->input('description');
        $position->user_id = auth()->user()->id;
        $position->save();

        return redirect('/positions')->with('success','Position updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $position = Position::find($id);
        
        $position->delete();

        return redirect('/positions')->with('success','Position Removed');
    }
}
