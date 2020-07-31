@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-md-offset-0">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>{{Lang::get('spare_part.title')}}</h3>
                    
                    <div class="row">
                        <div class="col-md-6">
                            {!! Form::open(['action' => 'SparePartController@search', 'method' => 'POST',]) !!}
                                    <div class="form-inline">
                                        {{Form::text('keyword','',['class' => 'form-control' ])}}
                                        {{Form::submit(Lang::get('common.search'), ['class' => 'btn btn-info'])}}
                                    </div>
                            {!! Form::close() !!} 
                        </div>  
                    <div class="col-md-3"></div>
                    <div class="col-md-3">
                        <div class="btn-group pull-right">
                            
                            <a href="{{ route('spare_parts.create') }}" class="btn btn-primary" >{{lang::get('crud.create')}}</a>
                        </div>
                        </div>
                    </div>
                </div>

                <div class="panel-body">


                @if(count($spare_parts) > 0)
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{Lang::get('spare_part.code')}}</th>
                                <th>{{Lang::get('spare_part.description')}}</th>
                                <th>{{Lang::get('unit.title')}}</th>
                                <th>{{Lang::get('category.title')}}</th>
                                <th>{{Lang::get('position.title')}}</th>
                                <th>{{Lang::get('spare_part.remain')}}</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                                
                                @foreach($spare_parts as $spare_part)
                                @if($spare_part)
                                <tr>
                                    <td><a href="{{route('spare_parts.show', $spare_part->id)}}">{{$spare_part->code}}</a></td>
                                    <td><a href="{{route('spare_parts.show', $spare_part->id)}}">{{$spare_part->description}}</a></td>
                                    <td>{{$spare_part->unit->name}}</td>
                                    @if($spare_part->category)
                                        <td>{{$spare_part->category->name}}</td>
                                    @else
                                        <td>error at id: {{$spare_part->category_id}}</td>
                                    @endif
                                    <td>{{$spare_part->position->code}}</td>
                                    <td>{{$spare_part->getTotalAmount()}}</td>
                                </tr>
                                @else
                                <tr>
                                    <td>error</td>
                                </tr>
                                @endif
                                @endforeach
                        </tbody>
                    </table>
                        {{ $spare_parts->links() }}
                    @else
                        No Spare Part Found.
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection