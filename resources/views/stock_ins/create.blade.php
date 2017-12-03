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
                        {{Form::number('amount',Request::get('amount'),['class' => 'form-control bfh-number', 'min' => '1' ])}}
                        {{Form::submit(Lang::get('crud.create'), ['class' => 'btn btn-info'])}}
                    </div>
                    {!! Form::close() !!}  
                    <br><br>
                {!! Form::open(['action' => 'StockInController@store', 'method' => 'POST']) !!}
                    <div class="form-group">
                        {{ Form::label('order_id', Lang::get('stock_in.order_id')) }}
                        {{Form::text('order_id','',['class' => 'form-control', 'placeholder' => Lang::get('stock_in.order_id') ])}}
                    </div>
                    <div class="form-group">
                        {{ Form::label('date', Lang::get('stock_in.date')) }}
                        {{Form::text('date','',['class' => 'form-control datepicker', 'placeholder' => Lang::get('stock_in.date') ])}}
                    </div>
                    <div class="form-group">
                        {{Form::label('shop', Lang::get('shop.title')) }}
                        {{Form::select('shop_id', $shops->pluck('name','id'),null,['class' => 'form-control selectpicker','data-live-search'=>'true',])}}
                    </div>
                    <div class="form-group">
                        {{ Form::label('note', Lang::get('stock_in.note')) }}
                        {{Form::text('note','',['class' => 'form-control', 'placeholder' => Lang::get('stock_in.note') ])}}
                    </div>
                    <!-- Dynamic form field -->
                    <div class="form-horizontal">
                         {{ Form::label('spare_part', Lang::get('spare_part.title')) }}
                        @for($i = 0; $i < Request::get('amount'); $i++)
                            <div class="form-group">
                                {{Form::label('index', $i+1, ['class'=>'control-label col-sm-1'])}}
                                <div class="col-sm-5"> 
                                    {{Form::select('spare_part_ids['.$i.']', $spare_parts->pluck('description','id'),null,['class' => 'form-controler col-sm-12 selectpicker','data-live-search'=>'true',])}}
                                </div>
                                <div class="col-sm-2"> 
                                    {{Form::number('qtys['.$i.']','',['class' => 'form-control', 'placeholder' => Lang::get('stock_in.qty'), 'min' =>'0.00', 'step'=>'0.01'])}}
                                </div>
                                <div class="col-sm-3"> 
                                    {{Form::number('prices['.$i.']','',['class' => 'form-control', 'placeholder' => Lang::get('stock_in.price'), 'min' =>'0.00', 'step'=>'0.01' ])}}
                                </div>
                            </div>
                        @endfor
                    </div>
                    <hr>
                    {{Form::submit(Lang::get('button.submit'), ['class' => 'btn btn-primary pull-right'])}}
                {!! Form::close() !!}   

                </div>
            </div>
        </div>
    </div>
</div>

<script>
var spare_part_label = '{!!Form::label('spare_part', Lang::get('spare_part.title')) !!}'
var spare_part_field = '{!!Form::select('spare_part_ids[]', $spare_parts->pluck('description','id'),null,['class' => 'selectpicker','data-live-search'=>'true',])!!}' 
var qyt_field = '{!!Form::text('qtys[]','',['class' => 'form-control', 'placeholder' => Lang::get('stock_in.qty') ])!!}'
var price_field = '{!!Form::text('prices[]','',['class' => 'form-control', 'placeholder' => Lang::get('stock_in.price') ])!!}'
</script>
@endsection

