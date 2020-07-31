@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <p><a href="{{ URL::previous() }}" class="btn btn-primary">Back</a> </p>
            @include('inc.report_month_year_shop_form')
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-md-offset-0">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>{{Lang::get('stock_in.title')}} คิดเป็นเงินทั้งหมด: {{ number_format($total,2)}}</h3>
                </div>

                <div class="panel-body">

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
                                                <td>{{number_format($stock_in->getTotalPrice())}}</td>
                                            @else
                                                <td>ไม่พบรายการอะไหล่</td>
                                            @endif
                                            
                                            <td>{{$stock_in->user->name}}</td>
                                        </tr>
                                    
                                @endforeach
                            
                        </tbody>
                    </table>
                    @else
                        No StockIn Found.
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection