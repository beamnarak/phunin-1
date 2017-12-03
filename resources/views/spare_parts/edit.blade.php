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
                        {{ Form::label('code', Lang::get('spare_part.code')) }}
                        {{Form::text('code',$spare_part->code,['class' => 'form-control', 'placeholder' => Lang::get('spare_part.code') ])}}
                    </div>
                    <div class="form-group">
                        {{ Form::label('description', Lang::get('spare_part.description')) }}
                        {{Form::text('description',$spare_part->description,['class' => 'form-control','placeholder' => Lang::get('spare_part.description') ])}}
                    </div>

                    <div class="form-group">
                        {{Form::label('unit', Lang::get('unit.title')) }}
                        {{Form::select('unit_id', $units->pluck('name','id'),$spare_part->unit_id,['class' => 'form-control selectpicker','data-live-search'=>'true',])}}
                    </div>

                    <div class="form-group">
                        {{Form::label('category', Lang::get('category.title')) }}
                        {{Form::select('category_id', $categories->pluck('name','id'),$spare_part->category_id,['class' => 'form-control selectpicker','data-live-search'=>'true',])}}
                    </div>
                    <div class="form-group">
                        {{Form::label('position', Lang::get('position.title')) }}
                        {{Form::select('position_id', $positions->pluck('code','id'),$spare_part->position_id,['class' => 'form-control selectpicker','data-live-search'=>'true',])}}
                    </div>

                    <div class="form-group">
                        {{ Form::label('note', Lang::get('spare_part.note')) }}
                        {{Form::textarea('note',$spare_part->note,['class' => 'form-control', 'placeholder' => Lang::get('spare_part.note') ])}}
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