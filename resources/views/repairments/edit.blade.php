@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>{{Lang::get('repairment.title')}}</h3>
                </div>

                <div class="panel-body">
                    {!! Form::model($repairment, ['method' => 'PATCH', 'action' => ['RepairmentController@update',$repairment->id]]) !!}
                        @include('repairments.forms', ['submitButtonText' => Lang::get('repairment.edit')])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
