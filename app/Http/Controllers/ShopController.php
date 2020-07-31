<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shop;

class ShopController extends Controller
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
        $shops = Shop::orderBy('created_at','desc')->paginate(10);
        return view('shops.index')->with('shops', $shops);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('shops.create');
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
            'name' => 'required|string|unique:shops,name',
        ]);

        $shop = new Shop;
        $shop->name = preg_replace('!\s+!', ' ', $request->input('name'));
        //$shop->name = $request->input('name');
        $shop->description = $request->input('description');
        $shop->user_id = auth()->user()->id;
        $shop->save();

        return redirect('/shops')->with('success','Shop created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $shop = Shop::find($id);
        return view('shops.show')->with('shop', $shop);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $shop = Shop::find($id);
        
        /*
        if(auth()->user()->id !== $shop->user_id){
            return redirect()->route('shops.index')->with('error', 'Unauthorized Page');
        }*/

        return view('shops.edit')->with('shop',$shop);
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
            'name' => 'required|string|unique:shops,name,'.$id,
        ]);
        $shop = Shop::find($id);
        //$shop->name = $request->input('name');
        $shop->name = preg_replace('!\s+!', ' ', $request->input('name'));
        $shop->description = $request->input('description');
        $shop->user_id = auth()->user()->id;
        $shop->save();

        return redirect('/shops')->with('success','Shop updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shop = Shop::find($id);
        
        $shop->delete();

        return redirect('/shops')->with('success','Shop Removed');
    }
}
