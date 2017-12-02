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
                    <div class="form-group">
                        <h4>{{ Form::label('code', Lang::get('spare_part.code')) }} : {{$spare_part->code}}</h4>
                    </div>
                    <div class="form-group">
                        <h4>{{ Form::label('description', Lang::get('spare_part.description')) }} : 
                            @if($spare_part->description)
                                {{$spare_part->description}}
                            @else
                                -
                            @endif
                        </h4>
                    </div>
                    <div class="form-group">
                        <h4>{{ Form::label('category', Lang::get('category.title')) }} : {{$spare_part->category->name}}</h4>
                    </div>
                    <div class="form-group">
                        <h4>{{ Form::label('position', Lang::get('position.title')) }} : {{$spare_part->position->code}}</h4>
                    </div>
                    <div class="form-group">
                        <h4>{{ Form::label('unit', Lang::get('unit.title')) }} : {{$spare_part->unit->name}}</h4>
                    </div>
                    <div class="form-group">
                        <h4>{{ Form::label('note', Lang::get('spare_part.note')) }} : 
                            @if($spare_part->note)
                                {{$spare_part->note}}
                            @else
                                -
                            @endif
                        </h4>
                    </div>
                </div>
                <div class="panel-footer">
                <a href="{{route('spare_parts.edit',$spare_part->id)}}" class="btn btn-primary">{{Lang::get('crud.edit')}}</a>
                {!! Form::open(['action' => ['SparePartController@destroy', $spare_part->id], 'method' => 'POST', 'class'=>'pull-right' ]) !!}
                    {{Form::hidden('_method','DELETE') }}
                    {{Form::submit(Lang::get('button.delete'), ['class' => 'btn btn-danger'])}}
                {!! Form::close() !!}   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
