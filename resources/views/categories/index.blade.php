@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>{{Lang::get('category.title')}}</h3>
                    {!! Form::open(['action' => 'CategoryController@search', 'method' => 'POST',]) !!}
                            <div class="form-inline">
                                {{Form::text('keyword','',['class' => 'form-control' ])}}
                                {{Form::submit(Lang::get('common.search'), ['class' => 'btn btn-info'])}}
                            </div>
                    {!! Form::close() !!} 
                </div>

                <div class="panel-body">
                    <div class="btn-group pull-right">
                        <a href="{{ route('categories.create') }}" class="btn btn-primary" >{{lang::get('crud.create')}}</a>
                    </div>
                @if(count($categories) > 0)
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{Lang::get('category.name')}}</th>
                                <th>{{Lang::get('category.description')}}</th>
                                <th>{{Lang::get('category.spare_part_count')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                                @foreach($categories as $category)
                                <tr>
                                    <td><a href="{{route('categories.show', $category->id)}}">{{$category->name}}</a></td>
                                    @if($category->description)
                                        <td>{{$category->description}}</td>
                                    @else
                                        <td>-</td>
                                    @endif
                                    <td>{{$category->spare_parts->count()}}</td>
                                </tr>
                                @endforeach
                            
                        </tbody>
                    </table>
                    
                    {{ $categories->links() }}
                    @else
                        No Category Found.
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection