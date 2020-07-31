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
                {!! Form::open(['action' => ['MachineCategoryController@update',$machine_category->id], 'method' => 'PUT']) !!}
                    <div class="form-group">
                        {{ Form::label('name', Lang::get('machine_category.name')) }}
                        {{Form::text('name',$machine_category->name,['class' => 'form-control', 'placeholder' => Lang::get('machine_category.name') ])}}
                    </div>
                    <div class="form-group">
                        {{ Form::label('description', Lang::get('machine_category.description')) }}
                        {{Form::textarea('description',$machine_category->description,['class' => 'form-control', 'placeholder' => Lang::get('machine_category.description') ])}}
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