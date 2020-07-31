@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>{{Lang::get('department.title')}}</h3>
                    <div class="btn-group pull-right">
                        <a href="{{ route('departments.create') }}" class="btn btn-primary" >{{lang::get('crud.create')}}</a>
                    </div>
                </div>

                <div class="panel-body">
                @if(count($departments) > 0)
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{Lang::get('department.name')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                                @foreach($departments as $department)
                                <tr>
                                    <td><a href="{{route('departments.show', $department->id)}}">{{$department->name}}</a></td>
                                    
                                </tr>
                                @endforeach
                            
                        </tbody>
                    </table>
                    {{ $departments->links() }}
                    @else
                        No Department Found.
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection