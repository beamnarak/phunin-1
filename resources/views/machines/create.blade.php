@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>{{Lang::get('machine.title')}}</h3>
                </div>

                <div class="panel-body">
                {!! Form::open(['action' => 'MachineController@store', 'method' => 'POST']) !!}
                    <div class="form-group">
                        {{ Form::label('name', Lang::get('machine.name')) }}
                        {{Form::text('name','',['class' => 'form-control', 'placeholder' => Lang::get('machine.name') ])}}
                    </div>
                    <div class="form-group">
                        {{ Form::label('description', Lang::get('machine.description')) }}
                        {{Form::textarea('description','',['class' => 'form-control', 'placeholder' => Lang::get('machine.description') ])}}
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