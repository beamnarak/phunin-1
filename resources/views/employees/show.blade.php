@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>{{Lang::get('employee.title')}}</h3>
                </div>

                <div class="panel-body">
                    <div class="form-group">
                        <h4>{{ Form::label('name', Lang::get('employee.name')) }} : {{$employee->name}}</h4>
                    </div>
                    <div class="form-group">
                        <h4>{{ Form::label('description', Lang::get('employee.description')) }} : 
                            @if($employee->description)
                                {{$employee->description}}
                            @else
                                -
                            @endif
                        </h4>
                    </div>
                </div>
                <div class="panel-footer">
                <a href="{{route('employees.edit',$employee->id)}}" class="btn btn-primary">{{Lang::get('crud.edit')}}</a>
                {!! Form::open(['action' => ['EmployeeController@destroy', $employee->id], 'method' => 'POST', 'class'=>'pull-right' ]) !!}
                    {{Form::hidden('_method','DELETE') }}
                    {{Form::submit(Lang::get('button.delete'), ['class' => 'btn btn-danger'])}}
                {!! Form::close() !!}   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
