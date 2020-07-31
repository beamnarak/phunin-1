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
                    <div class="form-group">
                        <h4>{{ Form::label('request_id', Lang::get('stock_out.request_id')) }} : {{$stock_out->request_id}}</h4>
                    </div>
                    
                    <div class="form-group">
                        <h4>{{ Form::label('date', Lang::get('stock_out.date')) }} : 
                            @if($stock_out->spare_parts->count() > 0)
                                {{$stock_out->spare_parts->first()->pivot->date}}
                            @endif
                        </h4>
                    </div>
                    <div class="form-group">
                        <h4>{{ Form::label('employee', Lang::get('stock_out.requestioner')) }} : {{$stock_out->employee->name}}</h4>
                    </div>
                    <div class="form-group">
                        <h4>{{ Form::label('machine', Lang::get('machine.title')) }} : {{$stock_out->machine->name}}</h4>
                    </div>

                    <div class="form-group">
                        <h4>{{ Form::label('writer', Lang::get('common.writer')) }} : {{$stock_out->user->name}}</h4>
                    </div>
                    <div class="form-group">
                        <h4>{{ Form::label('note', Lang::get('stock_out.note')) }} : {{$stock_out->note}}</h4>
                    </div>

                    <table class="table">
                        <thead>
                            <th>{{Lang::get('spare_part.title')}}</th>
                            <th>{{Lang::get('stock_out.qty')}}</th>
                        </thead>
                        <tbody>
                            @foreach($stock_out->spare_parts as $spare_part)
                            <tr>
                                <td>{{$spare_part->description}}</td>
                                <td>{{number_format($spare_part->pivot->amount*-1,2)}} {{$spare_part->unit->name}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="panel-footer">
                {!! Form::open(['action' => ['StockOutController@destroy', $stock_out->id], 'method' => 'POST' ]) !!}
                    {{Form::hidden('_method','DELETE') }}
                    {{Form::submit(Lang::get('button.delete'), ['class' => 'btn btn-danger'])}}
                {!! Form::close() !!}   
                </div>


            </div>
        </div>
    </div>
</div>
@endsection
