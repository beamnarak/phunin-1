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
                    {!! Form::open(['action' => 'StockInController@create', 'method' => 'GET', 'class' => 'pull-right']) !!}
                     <div class="form-inline">
                        {{ Form::label('spare_part', Lang::get('stock_in.index_create')) }}
                        {{Form::number('amount',1,['class' => 'form-control bfh-number', 'min' => '1' ])}}
                        {{Form::submit(Lang::get('crud.create'), ['class' => 'btn btn-primary'])}}
                    </div>
                    {!! Form::close() !!}  
                @if(count($stock_ins) > 0)
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{Lang::get('stock_in.order_id')}}</th>
                                <th>{{Lang::get('stock_in.date')}}</th>
                                <th>{{Lang::get('shop.title')}}</th>
                                <th>{{Lang::get('spare_part.title')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                                @foreach($stock_ins as $stock_in)
                                <tr>
                                    <td><a href="{{route('stock_ins.show', $stock_in->id)}}">{{$stock_in->order_id}}</a></td>
                                    <td><a href="{{route('stock_ins.show', $stock_in->id)}}">{{$stock_in->date}}</a></td>
                                    <td>{{$stock_in->shop->name}}</td>
                                    <td>
                                    @foreach($stock_in->spare_parts as $spare_part)
                                        {{$spare_part->description}} <br>    
                                    @endforeach
                                    </td>
                                </tr>
                                @endforeach
                            
                        </tbody>
                    </table>
                    {{ $stock_ins->links() }}
                    @else
                        No StockIn Found.
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection