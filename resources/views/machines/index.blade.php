@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>{{Lang::get('machine.title')}}</h3>
                    <div class="btn-group pull-right">
                        <a href="{{ route('machines.create') }}" class="btn btn-primary" >{{lang::get('crud.create')}}</a>
                    </div>
                </div>

                <div class="panel-body">
                @if(count($machines) > 0)
                    <table class="table">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>{{Lang::get('machine.name')}}</th>
                                <th>{{Lang::get('machine.description')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                                @foreach($machines as $machine)
                                <tr>
                                    <td>{{$machine->id}}</td>
                                    <td><a href="{{route('machines.show', $machine->id)}}">{{$machine->name}}</a></td>
                                    @if($machine->description)
                                        <td>{{$machine->description}}</td>
                                    @else
                                        <td>-</td>
                                    @endif
                                </tr>
                                @endforeach
                            
                        </tbody>
                    </table>
                    {{$machines->links()}}
                    @else
                        No Machine Found.
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection