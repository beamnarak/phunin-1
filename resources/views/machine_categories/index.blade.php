@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-6">
                            <h3>{{Lang::get('machine_categories.title')}}</h3>
                        </div>
                        <div class="col-md-6">
                            <div class="btn-group pull-right">
                                <a href="{{ route('machine_categories.create') }}" class="btn btn-primary" >{{lang::get('crud.create')}}</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel-body">
                @if(count($machine_categories) > 0)
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{Lang::get('machine_categories.name')}}</th>
                                <th>{{Lang::get('machine_categories.group')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                                @foreach($machine_categories as $mc)
                                <tr>
                                    <td><a href="{{route('machine_categories.show', $mc->id)}}">{{$mc->name}}</a></td>
                                    @if($mc->group)
                                        <td>{{$mc->group}}</td>
                                    @else
                                        <td>-</td>
                                    @endif
                                </tr>
                                @endforeach
                            
                        </tbody>
                    </table>
                    {{$machine_categories->links()}}
                    @else
                        No Machine Category Found.
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection