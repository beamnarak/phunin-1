@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>{{Lang::get('shop.title')}}</h3>
                    <div class="btn-group pull-right">
                        <a href="{{ route('shops.create') }}" class="btn btn-primary" >{{lang::get('crud.create')}}</a>
                    </div>
                </div>

                <div class="panel-body">
                @if(count($shops) > 0)
                    <table class="table">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>{{Lang::get('shop.name')}}</th>
                                <th>{{Lang::get('shop.description')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                                @foreach($shops as $shop)
                                <tr>
                                    <td>{{$shop->id}}</td>
                                    <td><a href="{{route('shops.show', $shop->id)}}">{{$shop->name}}</a></td>
                                    @if($shop->description)
                                        <td>{{$shop->description}}</td>
                                    @else
                                        <td>-</td>
                                    @endif
                                </tr>
                                @endforeach
                            
                        </tbody>
                    </table>
                    {{$shops->links()}}
                    @else
                        No Shop Found.
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection