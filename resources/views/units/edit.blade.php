@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>{{Lang::get('unit.title')}}</h3>
                </div>

                <div class="panel-body">
                {!! Form::open(['action' => ['UnitController@update',$unit->id], 'method' => 'PUT']) !!}
                    <div class="form-group">
                        {{ Form::label('name', Lang::get('unit.name')) }}
                        {{Form::text('name',$unit->name,['class' => 'form-control', 'placeholder' => Lang::get('unit.name') ])}}
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