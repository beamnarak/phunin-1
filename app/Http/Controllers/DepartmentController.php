<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Department;

class DepartmentController extends Controller
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
        $departments = Department::orderBy('name','asc')->paginate(10);
        return view('departments.index')->with('departments', $departments);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('departments.create');
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
            'name' => 'required|string|unique:departments,name',
        ]);

        $department = new Department;
        $department->name = preg_replace('!\s+!', ' ', $request->input('name'));
        //$department->name = $request->input('name');
        $department->user_id = auth()->user()->id;
        $department->save();

        return redirect('/departments')->with('success','Department created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $department = Department::find($id);
        return view('departments.show')->with('department', $department);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $department = Department::find($id);
        /*
        if(auth()->user()->id !== $department->user_id){
            return redirect()->route('departments.index')->with('error', 'Unauthorized Page');
        }*/

        return view('departments.edit')->with('department',$department);
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
            'name' => 'required|string|unique:departments,name,'.$id,
        ]);
        $department = Department::find($id);
        $department->name = preg_replace('!\s+!', ' ', $request->input('name'));
        //$department->name = $request->input('name');
        $department->user_id = auth()->user()->id;
        $department->save();

        return redirect('/departments')->with('success','Department updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $department = Department::find($id);
        
        $department->delete();

        return redirect('/departments')->with('success','Department Removed');
    }
}
