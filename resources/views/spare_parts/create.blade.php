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
                {!! Form::open(['action' => 'SparePartController@store', 'method' => 'POST']) !!}
                    <div class="form-group">
                        {{ Form::label('code', Lang::get('spare_part.code')) }}
                        {{Form::text('code','',['class' => 'form-control', 'placeholder' => Lang::get('spare_part.code') ])}}
                    </div>
                    <div class="form-group">
                        {{ Form::label('description', Lang::get('spare_part.description')) }}
                        {{Form::text('description','',['class' => 'form-control','placeholder' => Lang::get('spare_part.description') ])}}
                    </div>

                    <div class="form-group">
                        {{Form::label('unit', Lang::get('unit.title')) }}
                        {{Form::select('unit_id', $units->pluck('name','id'),null,['class' => 'form-control selectpicker','data-live-search'=>'true',])}}
                    </div>

                    <div class="form-group">
                        {{Form::label('category', Lang::get('category.title')) }}
                        {{Form::select('category_id', $categories->pluck('name','id'),null,['class' => 'form-control selectpicker','data-live-search'=>'true',])}}
                    </div>

                    <div class="form-group">
                        {{Form::label('position', Lang::get('position.title')) }}
                        {{Form::select('position_id', $positions->pluck('code','id'),null,['class' => 'form-control selectpicker','data-live-search'=>'true',])}}
                    </div>

                    <div class="form-group">
                        {{ Form::label('minimum', Lang::get('spare_part.minimum')) }}
                        {{Form::number('minimum','',['class' => 'form-control', 'placeholder' => Lang::get('spare_part.minimum'), 'min' =>'0.00', 'step'=>'0.01'])}}
                    </div>

                    <div class="form-group">
                        {{ Form::label('note', Lang::get('spare_part.note')) }}
                        {{Form::textarea('note','',['class' => 'form-control', 'placeholder' => Lang::get('spare_part.note') ])}}
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