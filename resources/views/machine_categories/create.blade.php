@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>{{Lang::get('machine_category.title')}}</h3>
                </div>

                <div class="panel-body">
                {!! Form::open(['action' => 'MachineCategoryController@store', 'method' => 'POST']) !!}
                    <div class="form-group">
                        {{ Form::label('name', Lang::get('machine_category.name')) }}
                        {{Form::text('name','',['class' => 'form-control', 'placeholder' => Lang::get('machine_category.name') ])}}
                    </div>
                    <div class="form-group">
                        {{Form::label('group', Lang::get('machine_category.group')) }}
                        {{Form::select('group', array('P' => 'Production', 'T' => 'Transportation'),null,['placeholder'=>'ไม่มีรายการที่ถูกเลือก','class' => 'form-control selectpicker'])}}
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