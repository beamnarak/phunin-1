@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>{{Lang::get('category.title')}}</h3>
                </div>

                <div class="panel-body">
                {!! Form::open(['action' => 'CategoryController@store', 'method' => 'POST']) !!}
                    <div class="form-group">
                        {{ Form::label('name', Lang::get('category.name')) }}
                        {{Form::text('name','',['class' => 'form-control', 'placeholder' => Lang::get('category.name') ])}}
                    </div>
                    <div class="form-group">
                        {{ Form::label('description', Lang::get('category.description')) }}
                        {{Form::textarea('description','',['class' => 'form-control', 'placeholder' => Lang::get('category.description') ])}}
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