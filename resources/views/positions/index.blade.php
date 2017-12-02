@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>{{Lang::get('position.title')}}</h3>
                    <div class="btn-group pull-right">
                        <a href="{{ route('positions.create') }}" class="btn btn-primary" >{{lang::get('crud.create')}}</a>
                    </div>
                </div>

                <div class="panel-body">
                @if(count($positions) > 0)
                    <table class="table">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>{{Lang::get('position.code')}}</th>
                                <th>{{Lang::get('position.description')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                                @foreach($positions as $position)
                                <tr>
                                    <td>{{$position->id}}</td>
                                    <td><a href="{{route('positions.show', $position->id)}}">{{$position->code}}</a></td>
                                    <td><a href="{{route('positions.show', $position->id)}}">{{$position->description}}</a></td>
                                </tr>
                                @endforeach
                            
                        </tbody>
                    </table>
                    {{ $positions->links() }}
                    @else
                        No Position Found.
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection