@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>{{Lang::get('stock_in.title')}}</h3>
                </div>

                <div class="panel-body">
                    
                    <div class="form-group">
                        {{ Form::label('shop', Lang::get('id')) }} : {{$stock_in->id}}</h4>
                    </div>
                    <div class="form-group">
                        <h4>{{ Form::label('order_id', Lang::get('stock_in.order_id')) }} : {{$stock_in->order_id}}</h4>
                    </div>
                    <div class="form-group">
                        <h4>{{ Form::label('date', Lang::get('stock_in.date')) }} : 
                            @if($stock_in->spare_parts->count() > 0)
                                {{$stock_in->spare_parts->first()->pivot->date}}
                            @endif
                        </h4>
                    </div>
                    <div class="form-group">
                        <h4>{{ Form::label('shop', Lang::get('shop.title')) }} : {{$stock_in->shop->name}}</h4>
                    </div>
                    <div class="form-group">
                        <h4>{{ Form::label('total', Lang::get('stock_in.total')) }} : {{number_format($stock_in->getTotalPrice(),2)}} บาท</h4>
                    </div>
                    <div class="form-group">
                        <h4>{{ Form::label('total', Lang::get('stock_in.note')) }} : {{$stock_in->note}}</h4>
                    </div>
                    <div class="form-group">
                        <h4>{{ Form::label('total', Lang::get('common.writer')) }} : {{$stock_in->user->name}}</h4>
                    </div>
                    <table class="table">
                        <thead>
                            <th>{{Lang::get('spare_part.title')}}</th>
                            <th>{{Lang::get('stock_in.qty')}}</th>
                            <th>{{Lang::get('stock_in.price')}}</th>
                            <th>{{Lang::get('stock_in.total')}}</th>
                        </thead>
                        <tbody>
                            @foreach($stock_in->spare_parts->sortBy('code') as $spare_part)
                                <tr>
                                    <td><a href="{{route('spare_parts.show',$spare_part->id)}}">{{$spare_part->detail}}</a></td>
                                    <td>{{$spare_part->pivot->amount}} {{$spare_part->unit->name}}</td>
                                    <td>{{number_format($spare_part->pivot->price,2)}}</td>
                                    <td>{{number_format($spare_part->pivot->amount * $spare_part->pivot->price,2)}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="panel-footer">
                {!! Form::open(['action' => ['StockInController@destroy', $stock_in->id], 'method' => 'POST' ]) !!}
                    {{Form::hidden('_method','DELETE') }}
                    {{Form::submit(Lang::get('button.delete'), ['class' => 'btn btn-danger'])}}
                {!! Form::close() !!}   
                </div>


            </div>
        </div>
    </div>
</div>
@endsection
