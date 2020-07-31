@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <div class="panel panel-default"> 
                <div class="panel-heading">
                    <h3>{{Lang::get('unit.title')}}</h3>
                    
                </div>

                <div class="panel-body">
                <div class="btn-group pull-right">
                    
                        <a href="{{ route('units.create') }}" class="btn btn-primary" >{{lang::get('crud.create')}}</a>
                    </div>
                @if(count($units) > 0)
                    <table class="table">
                        <thead>
                            <tr>
                                <th><h3>{{Lang::get('unit.name')}}<h3></th>
                            </tr>
                        </thead>
                        <tbody>
                            
                                @foreach($units as $unit)
                                <tr>
                                    <td><a href="{{route('units.show', $unit->id)}}">{{$unit->name}}</a></td>
                                    
                                </tr>
                                @endforeach
                            
                        </tbody>
                    </table>
                    {{ $units->links() }}
                    @else
                        No Unit Found.
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection