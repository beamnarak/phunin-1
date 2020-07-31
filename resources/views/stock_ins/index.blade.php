@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-md-offset-0">
            <div class="panel panel-default">
                <div class="panel-body">
                    <p><h4>แถบค้นหา</h4></p>
                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group">
                                {!! Form::open(['action' => 'StockInController@search', 'method' => 'POST',]) !!}
                                        <div class="form-inline">
                                            <div class="form-group">
                                                {{ Form::label('date', Lang::get('stock_in.start_date')) }}
                                                {{Form::text('start_date','',['class' => 'datepicker', 'placeholder' => Lang::get('stock_in.date') ])}}
                                            </div>
                                            <div class="form-group">
                                                {{ Form::label('date', Lang::get('stock_in.end_date')) }}
                                                {{Form::text('end_date','',['class' => 'datepicker', 'placeholder' => Lang::get('stock_in.date') ])}}
                                            </div>
                                            {{Form::submit(Lang::get('common.search'), ['class' => 'btn btn-primary'])}}
                                        </div> 
                                {!! Form::close() !!} 
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <!-- ค้นหาเลขใบสั่งซื้อ -->
                                {!! Form::open(['action' => 'StockInController@searchByPID', 'method' => 'POST',]) !!}
                                        <div class="form-inline">
                                            {{Form::label('search_by_rid', 'ค้นหาเลขที่ใบสั่งซื้อ')}}
                                            {{Form::text('keyword','',['class' => 'form-control' ])}}
                                            {{Form::submit(Lang::get('common.search'), ['class' => 'btn btn-primary'])}}
                                        </div> 
                                {!! Form::close() !!} 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>{{Lang::get('stock_in.title')}}</h3>
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-7">
                            {{ $stock_ins->links() }}  
                        </div>
                        <div class="col-md-5">
                            {!! Form::open(['action' => 'StockInController@create', 'method' => 'GET', 'class' => 'pull-right']) !!}
                            <div class="form-inline">
                                {{ Form::label('spare_part', Lang::get('stock_in.index_create')) }}
                                {{Form::number('amount',1,['class' => 'form-control bfh-number', 'min' => '1' ])}}
                                {{Form::submit(Lang::get('crud.create'), ['class' => 'btn btn-primary'])}}
                            </div>
                            {!! Form::close() !!}  
                        </div>
                    </div>

                @if(count($stock_ins) > 0)
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{Lang::get('stock_in.order_id')}}</th>
                                <th>{{Lang::get('stock_in.date')}}</th>
                                <th>{{Lang::get('shop.title')}}</th>
                                <th>{{Lang::get('spare_part.title')}}</th>
                                <th>{{Lang::get('stock_in.total')}}</th>
                                <th>{{Lang::get('common.writer')}}</th>
                            </tr>
                        </thead>
                        <tbody>

                            
                                @foreach($stock_ins as $stock_in)
                                    
                                        <tr>
                                            <td><a href="{{route('stock_ins.show', $stock_in->id)}}">{{$stock_in->order_id}}</a></td>
                                            <td>
                                                @if($stock_in->spare_parts->count() > 0)
                                                <a href="{{route('stock_ins.show', $stock_in->id)}}">{{$stock_in->spare_parts->first()->pivot->date}}</a>
                                                @endif
                                            </td>
                                            <td>{{$stock_in->shop->name}}</td>
                                            
                                            @if($stock_in->spare_parts->count()>0)
                                                <td>
                                                @foreach($stock_in->spare_parts->sortBy('code') as $spare_part)
                                                    @if($spare_part != null)
                                                    <a href="{{route('spare_parts.show',$spare_part->id)}}">{{$spare_part->detail}}</a> : {{number_format($spare_part->pivot->amount,2)}} {{$spare_part->unit->name}} | {{number_format($spare_part->pivot->price,2)}} บาท<br>
                                                    @endif
                                                @endforeach
                                                </td>
                                                <td>{{number_format($stock_in->getTotalPrice(),2)}}</td>
                                            @else
                                                <td>ไม่พบรายการอะไหล่</td>
                                            @endif
                                            <td>{{$stock_in->user->name}}</td>
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