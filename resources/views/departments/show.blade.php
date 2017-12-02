@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>{{Lang::get('department.title')}}</h3>
                </div>

                <div class="panel-body">
                    <div class="form-group">
                        <h4>{{ Form::label('name', Lang::get('department.name')) }} : {{$department->name}}</h4>
                    </div>
                </div>
                <div class="panel-footer">
                <a href="{{route('departments.edit',$department->id)}}" class="btn btn-primary">{{Lang::get('crud.edit')}}</a>
                {!! Form::open(['action' => ['DepartmentController@destroy', $department->id], 'method' => 'POST', 'class'=>'pull-right' ]) !!}
                    {{Form::hidden('_method','DELETE') }}
                    {{Form::submit(Lang::get('button.delete'), ['class' => 'btn btn-danger'])}}
                {!! Form::close() !!}   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
