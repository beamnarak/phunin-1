@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>{{Lang::get('shop.title')}}</h3>
                </div>

                <div class="panel-body">
                {!! Form::open(['action' => 'ShopController@store', 'method' => 'POST']) !!}
                    <div class="form-group">
                        {{ Form::label('name', Lang::get('shop.name')) }}
                        {{Form::text('name','',['class' => 'form-control', 'placeholder' => Lang::get('shop.name') ])}}
                    </div>
                    <div class="form-group">
                        {{ Form::label('description', Lang::get('shop.description')) }}
                        {{Form::textarea('description','',['class' => 'form-control', 'placeholder' => Lang::get('shop.description') ])}}
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