@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5>{{Lang::get('spare_part.title')}} - [{{ $spare_part->id}}]</h5>
                    <h3>{{$spare_part->detail}}</h3>
                </div>

                <div class="panel-body">
                    <div class="form-group">
                        <h5>{{ Form::label('category', Lang::get('category.title')) }} : {{$spare_part->category->name}}</h5>
                    </div>
                    <div class="form-group">
                        <h5>{{ Form::label('position', Lang::get('position.title')) }} : {{$spare_part->position->code}}</h5>
                    </div>
                    <div class="form-group">
                        <h5>{{ Form::label('unit', Lang::get('unit.title')) }} : {{$spare_part->unit->name}}</h5>
                    </div>
                    <div class="form-group">
                        <h5>{{ Form::label('unit', Lang::get('spare_part.minimum')) }} : {{$spare_part->minimum}}</h5>
                    </div>
                    <div class="form-group">
                        <h5>{{ Form::label('note', Lang::get('spare_part.note')) }} : 
                            @if($spare_part->note)
                                {{$spare_part->note}}
                            @else
                                -
                            @endif
                        </h5>
                    </div>
                </div>
                <div class="panel-footer">
                    <a href="{{route('spare_parts.edit',$spare_part->id)}}" class="btn btn-primary">{{Lang::get('crud.edit')}}</a>
                    {!! Form::open(['action' => ['SparePartController@destroy', $spare_part->id], 'method' => 'POST', 'class'=>'pull-right' ]) !!}
                        {{Form::hidden('_method','DELETE') }}
                        {{Form::submit(Lang::get('button.delete'), ['class' => 'btn btn-danger'])}}
                    {!! Form::close() !!}   
                </div>
            </div>
            <div class="panel">
                <div class="panel-body">   
                    <h5>
                        ค้นพบรายการนำเข้าเบิกออกทั้งหมด <b>{{$results->count()}}</b> รายการ<br>
                        จำนวนคงเหลือ <b>{{$spare_part->getTotalAmount()}}</b> {{$spare_part->unit->name}}
                    </h5>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{Lang::get('common.date')}}</th>
                                <th>{{Lang::get('stock_out.request_id')}}/{{Lang::get('stock_in.order_id')}}</th>

                                <th>{{Lang::get('common.amount')}}</th>
                                <th>{{Lang::get('stock_in.price')}}</th>
                                <th>{{Lang::get('stock_in.total')}}</th>
                                <!--th>{{Lang::get('stock_in.title')}}</th-->
                                <!--th>{{Lang::get('stock_out.title')}}</th-->
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($results as $r) 
                        
                            @if($r->amount <0)
                                <tr style="background-color:#00ffaa;">
                                    <td>{{$r->date}}</td>
                                    <td><a href="{{route('stock_outs.show',$r->pivot->stock_out_id)}}"> เลขที่ใบเบิก: {{App\StockOut::find($r->pivot->stock_out_id)->request_id }}</a></td>
                                    <td>{{ $r->amount }}</td>
                                    <td>{{ number_format($spare_part->getPriceBeforeDate($r->date),2) }} บาท</td>
                                    <td>{{ number_format($r->amount * $spare_part->getPriceBeforeDate($r->date),2) }} บาท</td>
                                </tr>
                            @else
                                <tr style="background-color:white;">
                                    <td>{{$r->date}}</td>
                                    <td><a href="{{route('stock_ins.show',$r->pivot->stock_in_id)}}"> เลขที่สั่งซื้อ: {{App\StockIn::find($r->pivot->stock_in_id)->order_id }} | {{App\Shop::find(App\StockIn::find($r->pivot->stock_in_id)->shop_id)->name }}</a></td>
                                    <td>{{ $r->amount }}</td>
                                    <td>{{ number_format($r->price, 2) }} บาท</td>
                                    <td>{{ number_format($r->amount * $r->price, 2) }} บาท</td>
                                </tr>
                            @endif
                            
                        
                        @endforeach
                        
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
