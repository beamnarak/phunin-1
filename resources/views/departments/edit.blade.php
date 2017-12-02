@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>{{Lang::get('department.title')}}</h3>
                </div>

                <div class="panel-body">
                {!! Form::open(['action' => ['DepartmentController@update',$department->id], 'method' => 'PUT']) !!}
                    <div class="form-group">
                        {{ Form::label('name', Lang::get('department.name')) }}
                        {{Form::text('name',$department->name,['class' => 'form-control', 'placeholder' => Lang::get('department.name') ])}}
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