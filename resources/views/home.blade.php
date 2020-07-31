@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>รายการรับเข้าเบิกออกประจำวันที่ {{$date}}/{{$month}}/{{$year}} <span class="badge badge-secondary">New</span></h3>
                    
                </div>
                <div class="panel-body">
                    
                    <!--
                    <center>
                       {//!! $chart->html() !!}
                    </center>
                    --> 
                    <div class="panel-body">
                        <table class="table">
                            <tr>
                                <th>เลขที่ใบเบิก/ใบสั่งซื้อ</th>
                                <th>รายละเอียด</th>
                                <th>ร้านค้า</th>
                                <th>เครื่องจักร</th>
                                <th>ผู้เบิก</th>
                                <th>ผู้บันทึก</th>
                                <th>เวลาบันทึก</th>
                            </tr>
                            @foreach($results as $result)
                                @if( $result->request_id)
                                    <tr >
                                        <td >ใบเบิกเลขที่ <b>{{ $result->request_id }}</b></td>
                                        <td style="background-color:#f9f175;">
                                        @foreach($result->spare_parts->sortBy('code') as $spare_part) 
                                            @if($spare_part != null)
                                            <a href="{{route('spare_parts.show', $spare_part->id)}}"> {{$spare_part->detail}}</a> : <b>{{number_format($spare_part->pivot->amount,2)}} {{$spare_part->unit->name}} </b> <br>    
                                            @endif
                                        @endforeach
                                        </td>
                                        <td>-</td>
                                        <td>{{ $result->machine->name }}</td>
                                        <td>{{ $result->employee->name }}</td>
                                        <td>{{ $result->user->name }}</td>
                                        <td>{{ $result->created_at }}</td>
                                    </tr>
                                @else
                                    <tr>
                                        <td>ใบสั่งซื้อเลขที่ <b>{{ $result->order_id }}</b></td>

                                        @if($result->spare_parts->count()>0)
                                            <td>
                                            @foreach($result->spare_parts->sortBy('code') as $spare_part)
                                                @if($spare_part != null)
                                                <a href="{{route('spare_parts.show',$spare_part->id)}}">{{$spare_part->detail}}</a> : <b>{{number_format($spare_part->pivot->amount,2)}} {{$spare_part->unit->name}}</b> | <b>{{number_format($spare_part->pivot->price,2)}}</b> บาท<br>
                                                @endif
                                            @endforeach
                                            
                                            Total = <b>{{number_format($result->getTotalPrice(),2)}}</b> บาท
                                            </td>
                                        @else
                                            <td>ไม่พบรายการอะไหล่</td>
                                        @endif

                                        <td>{{ $result->shop->name }}</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>{{ $result->user->name }}</td>
                                        <td>{{ $result->created_at }}</td>
                                    </tr>        
                                @endif
                            @endforeach
                        </table>
                    </div>
                </div>

                <div class="panel-fotter">
                    <div class="container">
                    <!--
                        
                        -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
    <!--{//!! $chart->script() !!}-->
@endsection