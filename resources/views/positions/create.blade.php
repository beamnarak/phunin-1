@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>{{Lang::get('position.title')}}</h3>
                </div>

                <div class="panel-body">
                {!! Form::open(['action' => 'PositionController@store', 'method' => 'POST']) !!}
                    <div class="form-group">
                        {{ Form::label('code', Lang::get('position.code')) }}
                        {{Form::text('code','',['class' => 'form-control', 'placeholder' => Lang::get('position.code') ])}}
                    </div>
                    <div class="form-group">
                        {{ Form::label('description', Lang::get('position.description')) }}
                        {{Form::text('description','',['class' => 'form-control', 'placeholder' => Lang::get('position.description') ])}}
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