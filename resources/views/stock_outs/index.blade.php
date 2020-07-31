@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-md-offset-0">
 
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>{{Lang::get('stock_out.title')}}</h3>
                    <div class="form-group">
                    {!! Form::open(['action' => 'StockOutController@search', 'method' => 'POST',]) !!}
                            <div class="form-inline">
                                <div class="form-group">
                                    {{ Form::label('date', Lang::get('stock_in.start_date')) }}
                                    {{Form::text('start_date','',['class' => 'datepicker', 'placeholder' => Lang::get('stock_in.date') ])}}
                                </div>
                                <div class="form-group">
                                    {{ Form::label('date', Lang::get('stock_in.end_date')) }}
                                    {{Form::text('end_date','',['class' => 'datepicker', 'placeholder' => Lang::get('stock_in.date') ])}}
                                </div>
                                {{Form::submit(Lang::get('common.search'), ['class' => 'btn btn-info'])}}
                            </div> 
                    {!! Form::close() !!} 
                    </div>
                    <div class="form-group">
                    <!-- ค้นหาเลขใบเบิก -->
                    {!! Form::open(['action' => 'StockOutController@searchByRID', 'method' => 'POST',]) !!}
                            <div class="form-inline">
                                {{Form::label('search_by_rid', 'ค้นหาเลขที่ใบเบิก')}}
                                {{Form::text('keyword','',['class' => 'form-control' ])}}
                                {{Form::submit(Lang::get('common.search'), ['class' => 'btn btn-info'])}}
                            </div> 
                    {!! Form::close() !!} 
                    </div>
                </div>

                <div class="panel-body">
                
                <p>หน้านี้มีทั้งหมด {{$stock_outs->count()}} รายการ</p>
                    {!! Form::open(['action' => 'StockOutController@create', 'method' => 'GET', 'class' => 'pull-right']) !!}
                     <div class="form-inline">
                        {{ Form::label('spare_part', Lang::get('stock_out.index_create')) }}
                        {{Form::number('amount',1,['class' => 'form-control bfh-number', 'min' => '1' ])}}
                        {{Form::submit(Lang::get('crud.create'), ['class' => 'btn btn-primary'])}}
                    </div>
                    {!! Form::close() !!}  
                @if(count($stock_outs) > 0)
                {{ $stock_outs->links() }}
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{Lang::get('stock_out.request_id')}}</th>
                                <th>{{Lang::get('stock_out.date')}}</th>
                                <th>{{Lang::get('machine.title')}}</th>
                                <th>{{Lang::get('employee.title')}}</th>
                                <th>{{Lang::get('spare_part.title')}}</th>
                                <th>{{Lang::get('spare_part.remain')}}</th>
                                <th>{{Lang::get('common.writer')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                                @foreach($stock_outs as $stock_out)
                                <tr>
                                    <td><a href="{{route('stock_outs.show', $stock_out->id)}}">{{$stock_out->request_id}}</a></td>
                                    <td>
                                        @if($stock_out->spare_parts->count() > 0)
                                            {{$stock_out->spare_parts->first()->pivot->date}}
                                        @endif
                                    </td>
                                    <td><a href="{{route('machines.show', $stock_out->machine->id)}}">{{$stock_out->machine->name}}</a></td>
                                    <td>{{$stock_out->employee->name}}</td>
                                    <td>
                                    @foreach($stock_out->spare_parts->sortBy('code') as $spare_part) 
                                        @if($spare_part != null)
                                           <a href="{{route('spare_parts.show', $spare_part->id)}}"> {{$spare_part->detail}} : {{number_format($spare_part->pivot->amount*-1,2)}} {{$spare_part->unit->name}}</a> <br>    
                                        @endif
                                    @endforeach
                                    </td>
                                    <td>
                                    @foreach($stock_out->spare_parts->sortBy('code') as $spare_part) 
                                        @if($spare_part != null)
                                            {{$spare_part->getTotalAmount()}} <br>    
                                        @endif
                                    @endforeach
                                    </td>
                                    <td>{{$stock_out->user->name}}</td>
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