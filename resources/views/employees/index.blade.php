@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>{{Lang::get('employee.title')}}</h3>
                    <div class="btn-group pull-right">
                        <a href="{{ route('employees.create') }}" class="btn btn-primary" >{{lang::get('crud.create')}}</a>
                    </div>
                </div>

                <div class="panel-body">
                @if(count($employees) > 0)
                    <table class="table">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>{{Lang::get('employee.name')}}</th>
                                <th>{{Lang::get('department.title')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                                @foreach($employees as $employee)
                                <tr>
                                    <td>{{$employee->id}}</td>
                                    <td><a href="{{route('employees.show', $employee->id)}}">{{$employee->name}}</a></td>
                                
                                    <td>{{$employee->department->name}}</td>
                                </tr>
                                @endforeach
                        </tbody>
                    </table>
                    {{$employees->links()}}
                    @else
                        No Employee Found.
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection