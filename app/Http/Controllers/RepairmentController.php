<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repairment;
use App\Shop;
use App\Machine;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\Response;

class RepairmentController extends Controller
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
        $repairments = Repairment::paginate(10);
        $shops = Shop::all();
        $machines = Machine::all();
        $data = array(
            'repairments' => $repairments,
            'shops' => $shops,
            'machines' => $machines
        );
        return view('repairments.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $shops = Shop::all();
        $machines = Machine::all();
        $data = array(
            'shops' => $shops,
            'machines' => $machines
        );
        return view('repairments.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, []);
        $repairment = new Repairment;

        $repairment->start_date = $request->input('start_date');
        $repairment->end_date = $request->input('end_date');

        $repairment->shop_id = $request->input('shop_id');
        $repairment->machine_id = $request->input('machine_id');

        $repairment->wage_cost = $request->input('wage_cost');
        $repairment->travel_cost = $request->input('travel_cost');
        $repairment->accommodation_fee = $request->input('accommodation_fee');
        $repairment->spare_part_cost = $request->input('spare_part_cost');
        $repairment->delivery_cost = $request->input('delivery_cost');
        $repairment->clearance_cost = $request->input('clearance_cost');

        $repairment->description = $request->input('description');
        $repairment->payment_list = $request->input('payment_list');

        $repairment->user_id = auth()->user()->id;
        $repairment->save();

        return redirect('repairments')->with('success', 'Repairment created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $repairment = Repairment::findOrFail($id);
        return view('repairments.show', compact('repairment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $repairment = Repairment::findOrFail($id);
        $shops = Shop::all();
        $machines = Machine::all();
        $data = array(
            'repairment' => $repairment,
            'shops' => $shops,
            'machines' => $machines
        );
        return view('repairments.edit')->with($data);
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
        $this->validate($request, []);
        $repairment = Repairment::find($id);

        $repairment->start_date = $request->input('start_date');
        $repairment->end_date = $request->input('end_date');

        $repairment->shop_id = $request->input('shop_id');
        $repairment->machine_id = $request->input('machine_id');

        $repairment->wage_cost = $request->input('wage_cost');
        $repairment->travel_cost = $request->input('travel_cost');
        $repairment->accommodation_fee = $request->input('accommodation_fee');
        $repairment->spare_part_cost = $request->input('spare_part_cost');
        $repairment->delivery_cost = $request->input('delivery_cost');
        $repairment->clearance_cost = $request->input('clearance_cost');

        $repairment->description = $request->input('description');
        $repairment->payment_list = $request->input('payment_list');

        $repairment->user_id = auth()->user()->id;
        $repairment->save();

        return redirect('repairments')->with('success', 'Repairment updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $repairment = Repairment::findOrFail($id);
        $repairment->delete();

        return redirect('repairments')->with('success', 'Repairment Deleted');;
    }

    public function autocomplete()
    {
        $term = Input::get('term');

        $results = array();

        $queries = Machine::where('name', 'LIKE', '%' . $term . '%')
            ->take(5)->get();

        foreach ($queries as $q) {
            $results[] = [ 'id' => $query->id, 'value' => $query->name ];
        }

        return Response::json($results);
    }
}
