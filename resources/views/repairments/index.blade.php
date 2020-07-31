@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>{{Lang::get('repairment.title')}}</h3>
                    <div class="btn-group pull-right">
                        <a href="{{ route('repairments.create') }}" class="btn btn-primary" >{{lang::get('crud.create')}}</a>
                    </div>
                </div>

                <div class="panel-body">
                @if(count($repairments) > 0)
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{Lang::get('repairment.start_date')}}</th>
                                <th>{{Lang::get('repairment.end_date')}}</th>
                                <th>{{Lang::get('repairment.machine')}}</th>
                                <th>{{Lang::get('repairment.description')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                                @foreach($repairments as $repairment)
                                <tr>
                                    <td><a href="{{route('repairments.show', $repairment->id)}}">{{ $repairment->start_date }}</a></td>
                                    <td>{{ $repairment->end_date }}</td>
                                    <td><a href="{{route('machines.show', $repairment->machine_id)}}">{{$repairment->machine->name}}</a></td>
                                    @if(!empty($repairment->description))
                                    <td>{{ $repairment->description }}</td>
                                    @else
                                    <td>-</td>
                                    @endif
                                </tr>
                                @endforeach
                            
                        </tbody>
                    </table>
                    {{ $repairments->links() }}
                    @else
                        No Position Found.
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection