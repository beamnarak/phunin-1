@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>{{Lang::get('stock_out.title')}}</h3>
                </div>

                <div class="panel-body">
                    {!! Form::open(['action' => 'StockOutController@create', 'method' => 'GET', 'class' => 'pull-right']) !!}
                     <div class="form-inline">
                        {{ Form::label('spare_part', Lang::get('stock_out.index_create')) }}
                        {{Form::number('amount',1,['class' => 'form-control bfh-number', 'min' => '1' ])}}
                        {{Form::submit(Lang::get('crud.create'), ['class' => 'btn btn-primary'])}}
                    </div>
                    {!! Form::close() !!}  
                @if(count($stock_outs) > 0)
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{Lang::get('stock_out.request_id')}}</th>
                                <th>{{Lang::get('stock_out.date')}}</th>
                                <th>{{Lang::get('machine.title')}}</th>
                                <th>{{Lang::get('employee.title')}}</th>
                                <th>{{Lang::get('spare_part.title')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                                @foreach($stock_outs as $stock_out)
                                <tr>
                                    <td><a href="{{route('stock_outs.show', $stock_out->id)}}">{{$stock_out->request_id}}</a></td>
                                    <td><a href="{{route('stock_outs.show', $stock_out->id)}}">{{$stock_out->date}}</a></td>
                                    <td><a href="{{route('machines.show', $stock_out->machine->id)}}">{{$stock_out->machine->name}}</a></td>
                                    <td>{{$stock_out->employee->name}}</td>
                                    <td>
                                    @foreach($stock_out->spare_parts as $spare_part)
                                        {{$spare_part->description}}: {{$spare_part->pivot->amount}} {{$spare_part->unit->name}} <br>    
                                    @endforeach
                                    </td>
                                </tr>
                                @endforeach
                            
                        </tbody>
                    </table>
                    {{ $stock_outs->links() }}
                    @else
                        No StockOut Found.
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection