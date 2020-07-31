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
                    <div class="form-group">
                        <h4>{{ Form::label('name', Lang::get('category.name')) }} : {{$category->name}}</h4>
                    </div>
                    <div class="form-group">
                        <h4>{{ Form::label('description', Lang::get('category.description')) }} : 
                            @if($category->description)
                                {{$category->description}}
                            @else
                                -
                            @endif
                        </h4>
                    </div>
                </div>
                <div class="panel-footer">
                <a href="{{route('categories.edit',$category->id)}}" class="btn btn-primary">{{Lang::get('crud.edit')}}</a>
                 
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">

                <div class="panel-body">
                @if(count($spare_parts) > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>{{Lang::get('spare_part.code')}}</th>
                            <th>{{Lang::get('spare_part.description')}}</th>
                            <th>{{Lang::get('spare_part.remain')}}</th>
                            <th>{{Lang::get('unit.title')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                            @foreach($spare_parts as $spare_part)
                            <tr>
                                <td><a href="{{route('spare_parts.show', $spare_part->id)}}">{{$spare_part->code}}</a></td>
                                <td><a href="{{route('spare_parts.show', $spare_part->id)}}">{{$spare_part->description}}</a></td>
                                <td>{{$spare_part->getTotalAmount()}}</td>
                                <td><a href="{{route('units.show', $spare_part->unit->id)}}">{{$spare_part->unit->name}}</a></td>
                            </tr>
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
