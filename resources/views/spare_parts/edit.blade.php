@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>{{Lang::get('spare_part.title')}}</h3>
                </div>

                <div class="panel-body">
                {!! Form::open(['action' => ['SparePartController@update',$spare_part->id], 'method' => 'PUT']) !!}
                    <div class="form-group">
                        {{ Form::label('name', Lang::get('spare_part.name')) }}
                        {{Form::text('name',$spare_part->name,['class' => 'form-control', 'placeholder' => Lang::get('spare_part.name') ])}}
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