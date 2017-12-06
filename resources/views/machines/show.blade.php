@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>{{Lang::get('machine.title')}}</h3>
                </div>

                <div class="panel-body">
                    <div class="form-group">
                        <h4>{{ Form::label('name', Lang::get('machine.name')) }} : {{$machine->name}}</h4>
                    </div>
                    <div class="form-group">
                        <h4>{{ Form::label('description', Lang::get('machine.description')) }} : 
                            @if($machine->description)
                                {{$machine->description}}
                            @else
                                -
                            @endif
                        </h4>
                    </div>
                </div>
                <div class="panel-footer">
                <a href="{{route('machines.edit',$machine->id)}}" class="btn btn-primary">{{Lang::get('crud.edit')}}</a>
                {!! Form::open(['action' => ['MachineController@destroy', $machine->id], 'method' => 'POST', 'class'=>'pull-right' ]) !!}
                    {{Form::hidden('_method','DELETE') }}
                    {{Form::submit(Lang::get('button.delete'), ['class' => 'btn btn-danger'])}}
                {!! Form::close() !!}   
                </div>
                <table class="table">
                    <thead>
                        <th>{{Lang::get('stock_out.date')}}</th>
                        <th>{{Lang::get('stock_out.request_id')}}</th>
                        <th>{{Lang::get('spare_part.title')}}</th>
                        <th>{{Lang::get('stock_out.qty')}}</th>
                    </thead>
                    <tbody>
                        @foreach($stock_outs as $stock_out)
                            @foreach($stock_out->spare_parts as $spare_part)
                            <tr>
                                <td>{{$stock_out->date}}</td>
                                <td>{{$stock_out->request_id}}</td>
                                <td>{{$spare_part->description}}</td>
                                <td>{{$spare_part->pivot->amount}}</td>
                            </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
