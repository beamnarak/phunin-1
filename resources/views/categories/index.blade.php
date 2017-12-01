@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>{{Lang::get('category.title')}}</h3>
                    <div class="btn-group pull-right">
                        <a href="{{ route('categories.create') }}" class="btn btn-primary" >{{lang::get('crud.create')}}</a>
                    </div>
                </div>

                <div class="panel-body">
                @if(count($categories) > 0)
                    <table class="table">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>{{Lang::get('category.name')}}</th>
                                <th>{{Lang::get('category.description')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                                @foreach($categories as $category)
                                <tr>
                                    <td>{{$category->id}}</td>
                                    <td><a href="{{route('categories.show', $category->id)}}">{{$category->name}}</a></td>
                                    @if($category->description)
                                        <td>{{$category->description}}</td>
                                    @else
                                        <td>-</td>
                                    @endif
                                </tr>
                                @endforeach
                            
                        </tbody>
                    </table>
                    @else
                        No Category Found.
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection