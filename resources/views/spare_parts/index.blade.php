@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>{{Lang::get('spare_part.title')}}</h3>
                    <div class="btn-group pull-right">
                        <a href="{{ route('spare_parts.create') }}" class="btn btn-primary" >{{lang::get('crud.create')}}</a>
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
                            </tr>
                        </thead>
                        <tbody>
                            
                                @foreach($spare_parts as $spare_part)
                                <tr>
                                    <td><a href="{{route('spare_parts.show', $spare_part->id)}}">{{$spare_part->code}}</a></td>
                                    <td><a href="{{route('spare_parts.show', $spare_part->id)}}">{{$spare_part->description}}</a></td>
                                    <td><a href="{{route('spare_parts.show', $spare_part->id)}}">{{$spare_part->unit->name}}</a></td>
                                    <td><a href="{{route('spare_parts.show', $spare_part->id)}}">{{$spare_part->category->name}}</a></td>
                                    <td><a href="{{route('spare_parts.show', $spare_part->id)}}">{{$spare_part->position->code}}</a></td>
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