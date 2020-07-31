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
                {!! Form::open(['action' => 'StockOutController@create', 'method' => 'GET', 'class' => 'pull-right']) !!}
                     <div class="form-inline">
                        {{Form::label('spare_part', Lang::get('stock_out.index_create')) }}
                        {{Form::number('amount',Request::get('amount'),['class' => 'form-control bfh-number', 'min' => '1' ])}}
                        {{Form::submit(Lang::get('crud.create'), ['class' => 'btn btn-info'])}}
                    </div>
                    {!! Form::close() !!}  
                    <br><br>
                {!! Form::open(['action' => 'StockOutController@store', 'method' => 'POST']) !!}
                    <div class="form-group">
                        {{ Form::label('request_id', Lang::get('stock_out.request_id')) }}
                        {{Form::text('request_id','',['class' => 'form-control', 'placeholder' => 'ตัวอย่าง 999/99999' ])}}
                    </div>
                    <div class="form-group">
                        {{ Form::label('date', Lang::get('stock_out.date')) }}
                        {{Form::text('date','',['class' => 'form-control datepicker', 'placeholder' => Lang::get('stock_out.date') ])}}
                    </div>
                    <div class="form-group">
                        {{Form::label('employee', Lang::get('employee.title')) }}
                        {{Form::select('employee_id', $employees->pluck('name','id'),null,['placeholder'=>'ไม่มีรายการที่ถูกเลือก','class' => 'form-control selectpicker','data-live-search'=>'true',])}}
                    </div>
                    <div class="form-group">
                        {{Form::label('machine', Lang::get('machine.title')) }}
                        {{Form::select('machine_id', $machines->pluck('name','id'),null,['placeholder'=>'ไม่มีรายการที่ถูกเลือก','class' => 'form-control selectpicker','data-live-search'=>'true'])}}
                    </div>
                    <div class="form-group">
                        {{ Form::label('note', Lang::get('stock_out.note')) }}
                        {{Form::text('note','',['class' => 'form-control', 'placeholder' => Lang::get('stock_out.note') ])}}
                    </div>
                    <!-- Dynamic form field -->
                    <div class="form-horizontal">
                         {{ Form::label('spare_part', Lang::get('spare_part.title')) }}
                        @for($i = 0; $i < Request::get('amount'); $i++)
                            <div class="form-group">
                                {{Form::label('index', $i+1, ['class'=>'control-label col-sm-1'])}}
                                <div class="col-sm-5"> 
                                    {{Form::select('spare_part_ids['.$i.']', $spare_parts->pluck('detail','id'),null,['placeholder'=>'ไม่มีรายการที่ถูกเลือก','class' => 'form-controler col-sm-12 selectpicker','data-live-search'=>'true',])}}
                                </div>
                                <div class="col-sm-2"> 
                                    {{Form::number('qtys['.$i.']','',['class' => 'form-control', 'placeholder' => Lang::get('stock_out.qty'), 'min' =>'0.00', 'step'=>'0.01'])}}
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
var qyt_field = '{!!Form::text('qtys[]','',['class' => 'form-control', 'placeholder' => Lang::get('stock_out.qty') ])!!}'
var price_field = '{!!Form::text('prices[]','',['class' => 'form-control', 'placeholder' => Lang::get('stock_out.price') ])!!}'
</script>
@endsection

