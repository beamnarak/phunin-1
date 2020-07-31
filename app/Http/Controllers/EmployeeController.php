<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\Department;

class EmployeeController extends Controller
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
        $employees = Employee::paginate(10);
        return view('employees.index')->with('employees', $employees);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array(
            'departments' => Department::all(),
        );
        return view('employees.create')->with($data);
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
            'name' => 'required|string|unique:employees,name',
        ]);

        $employee = new Employee;
        $employee->name = preg_replace('!\s+!', ' ', $request->input('name'));
        //$employee->name = $request->input('name');
        $employee->description = $request->input('description');
        $employee->department_id = $request->input('department_id');
        $employee->user_id = auth()->user()->id;
        $employee->save();

        return redirect('/employees')->with('success','Employee created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = Employee::find($id);
        return view('employees.show')->with('employee', $employee);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = Employee::find($id);
        $data = array(
            'employee' => $employee,
            'departments' => Department::all(),
        );
        /*
            if(auth()->user()->id !== $employee->user_id){
                return redirect()->route('employees.index')->with('error', 'Unauthorized Page');
            }
        */

        return view('employees.edit')->with($data);
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
            'name' => 'required|string|unique:employees,name,'.$id,
        ]);
        $employee = Employee::find($id);
        //$employee->name = $request->input('name');
        $employee->name = preg_replace('!\s+!', ' ', $request->input('name'));
        $employee->description = $request->input('description');
        $employee->department_id = $request->input('department_id');
        $employee->user_id = auth()->user()->id;
        $employee->save();

        return redirect('/employees')->with('success','Employee updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::find($id);
        
        $employee->delete();

        return redirect('/employees')->with('success','Employee Removed');
    }
}
