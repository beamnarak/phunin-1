<div class="panel panel-default">
    <div class="panel-body">
        <p>อะไหล่เบิกใช้แยกตามเครื่องจักร</p>
        {!! Form::open(['action' => 'ReportController@stockout_each_machine', 'method' => 'GET']) !!}
            <div class="col-md-3">
                {{ Form::selectMonth('month',1, ['class' => 'form-control selectpicker']) }}
            </div>
            <div class="col-md-3">
                {{ Form::selectYear('year', 2017, 2020, 2019, ['class' => 'field form-control selectpicker']) }}
            </div>
            <div class="col-md-3">
                {{Form::select('machine', $machines->pluck('name','id'),null,['placeholder'=>'ไม่มีรายการที่ถูกเลือก','class' => 'form-control selectpicker','data-live-search'=>'true'])}}
            </div>
            <div class="col-md-3">
                {{Form::submit(Lang::get('button.submit'), ['class' => 'btn btn-primary form-control'])}}
            </div>
        {!! Form::close() !!}  
    </div>
</div>