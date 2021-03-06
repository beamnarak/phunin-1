<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SparePart;
use App\Category;
use App\Unit;
use App\Position;
use App\StockIn;
use App\StockOut;

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
        $spare_parts = SparePart::orderBy('created_at','desc')->paginate(10);
        return view('spare_parts.index')->with('spare_parts', $spare_parts);
    }

    public function search(Request $request)
    {
        if($request->input('keyword') != ''){
            $keyword = $request->input('keyword');
            $spare_parts = SparePart::whereHas('category', function($q) use ($keyword){
                                $q->nameLike($keyword);
                            })
                            ->orWhere('code','like','%'.$keyword.'%')
                            ->orWhere('description','like','%'.$keyword.'%')
                            ->orderBy('code')->paginate(10000);
            // create paginator
        } else {
            $spare_parts = SparePart::orderBy('created_at','desc')->paginate(10);
        }

        $data = array(
            'spare_parts' => $spare_parts,

        );
        return view('spare_parts.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array(
            'units' => Unit::orderBy('name','asc'),
            'positions' => Position::orderBy('code','asc'),
            'categories' => Category::orderBy('name','asc'),
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
            'code' => array(
                'required',
                'string',
                'unique:spare_parts,code',
                'regex:/^[0-9]{3}\-[0-9]{3}$/u'
            ),
            'description' => 'required',
            'category_id' => 'required',
            'position_id' => 'required',
            'unit_id' => 'required',
            'minimum' => 'required | numeric | min:0.01',
        ]);

        $spare_part = new SparePart;

        //$spare_part->code = $request->input('code');
        $spare_part->code = preg_replace('!\s+!', ' ', $request->input('code'));
        //$spare_part->description = $request->input('description');
        $spare_part->description = preg_replace('!\s+!', ' ', $request->input('description'));
        $spare_part->note = $request->input('note');
        $spare_part->category_id = $request->input('category_id');
        $spare_part->position_id = $request->input('position_id');
        $spare_part->unit_id = $request->input('unit_id');
        $spare_part->minimum = $request->input('minimum');

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
        
        $first = $spare_part->stock_ins()
                ->select('spare_part_stock_in.date as date', 'spare_part_stock_in.amount as amount', 'spare_part_stock_in.price as price')
                ->get();
        
        $second = $spare_part->stock_outs()
                ->select('spare_part_stock_out.date as date', 'spare_part_stock_out.amount as amount')
                ->get();

        $results = collect(); 

        foreach($first as $f){
            $results->push($f);
        }

        foreach($second as $s){
            $results->push($s);
        }

        $data = array(
            'spare_part' => $spare_part,
            'results' => $results->sortByDESC('date'),
            'first' => $first,
            'second' => $second, 
        );

        return view('spare_parts.show')->with($data);
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
        $data = array(
            'spare_part' => $spare_part,
            'units' => Unit::orderBy('name','asc'),
            'positions' => Position::orderBy('code','asc'),
            'categories' => Category::orderBy('name','asc'),
        );

        /*
        if(auth()->user()->id !== $spare_part->user_id){
            return redirect()->route('spare_parts.index')->with('error', 'Unauthorized Page');
        }
        */

        return view('spare_parts.edit')->with($data);
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
            'code' => array(
                'required',
                'string',
                'unique:spare_parts,code,'.$id,
                'regex:/^[0-9]{3}\-[0-9]{3}$/u'
            ),
            'description' => 'required',
            'category_id' => 'required',
            'position_id' => 'required',
            'unit_id' => 'required',
            'minimum' => 'required',
        ]);

        $spare_part = SparePart::find($id);

        //$spare_part->code = $request->input('code');
        $spare_part->code = preg_replace('!\s+!', ' ', $request->input('code'));
        //$spare_part->description = $request->input('description');
        $spare_part->description = preg_replace('!\s+!', ' ', $request->input('description'));
        
        $spare_part->note = $request->input('note');
        $spare_part->category_id = $request->input('category_id');
        $spare_part->position_id = $request->input('position_id');
        $spare_part->unit_id = $request->input('unit_id');
        $spare_part->minimum = $request->input('minimum');

        $spare_part->user_id = auth()->user()->id;
        $spare_part->save();

        return redirect()->route('spare_parts.show',['id'=>$id])->with('success','SparePart updated');
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
        
        $spare_part->stock_ins()->detach();
        $spare_part->stock_outs()->detach();
        $spare_part->delete();

        return redirect('/spare_parts')->with('success','SparePart Removed');
    }
}
