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
                {!! Form::open(['action' => 'EmployeeController@store', 'method' => 'POST']) !!}
                    <div class="form-group">
                        {{ Form::label('name', Lang::get('employee.name')) }}
                        {{Form::text('name','',['class' => 'form-control', 'placeholder' => Lang::get('employee.name') ])}}
                    </div>
                    <div class="form-group">
                        {{Form::label('department', Lang::get('department.title')) }}
                        {{Form::select('department_id', $departments->pluck('name','id'),null,['class' => 'form-control selectpicker','data-live-search'=>'true',])}}
                    </div>
                    <div class="form-group">
                        {{ Form::label('description', Lang::get('employee.description')) }}
                        {{Form::textarea('description','',['class' => 'form-control', 'placeholder' => Lang::get('employee.description') ])}}
                    </div>
                    <hr>
                    {{Form::submit(Lang::get('button.submit'), ['class' => 'btn btn-primary pull-right'])}}
                {!! Form::close() !!}   

                </div>
            </div>
        </div>
    </div>
</div>
@endsection