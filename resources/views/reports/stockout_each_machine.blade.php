@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <p><a href="{{ URL::previous() }}" class="btn btn-primary">Back</a> </p>
            @include('inc.report_month_year_machine_form')
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-md-offset-0">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>{{Lang::get('stock_out.title')}}สำหรับ {{$machine->name}} คิดเป็นเงินทั้งหมด: {{ number_format($total,2)}}</h3>
                </div>

                <div class="panel-body">

                @if(count($stock_outs) > 0)
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{Lang::get('stock_out.request_id')}}</th>
                                <th>{{Lang::get('stock_out.date')}}</th>
                                <th>{{Lang::get('spare_part.title')}}</th>
                                <th>{{Lang::get('stock_out.total')}}</th>
                                <th>{{Lang::get('common.writer')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                                @foreach($stock_outs as $stock_out)
                                    
                                        <tr>
                                            <td><a href="{{route('stock_outs.show', $stock_out->id)}}">{{$stock_out->request_id}}</a></td>
                                            <td>
                                                @if($stock_out->spare_parts->count() > 0)
                                                <a href="{{route('stock_outs.show', $stock_out->id)}}">{{$stock_out->spare_parts->first()->pivot->date}}</a>
                                                @endif
                                            </td>
                                            
                                            @if($stock_out->spare_parts->count()>0)
                                                <td>
                                                @foreach($stock_out->spare_parts->sortBy('code') as $spare_part)
                                                    @if($spare_part != null)
                                                    <a href="{{route('spare_parts.show',$spare_part->id)}}">{{$spare_part->detail}}</a> : {{number_format($spare_part->pivot->amount,2)}} {{$spare_part->unit->name}} | {{number_format($spare_part->getLastPrice($spare_part->id),2)}} บาท<br>
                                                    @endif
                                                @endforeach
                                                </td>
                                                <td>{{number_format($stock_out->getTotalPrice())}}</td>
                                            @else
                                                <td>ไม่พบรายการอะไหล่</td>
                                            @endif
                                            
                                            <td>{{$stock_out->user->name}}</td>
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