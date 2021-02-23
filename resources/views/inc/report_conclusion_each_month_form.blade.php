<div class="panel panel-default">
    <div class="panel-body">
        <p>สรุปมูลค่าการรับเข้าเบิกออกเป็นรายเดือน</p>
        {!! Form::open(['action' => 'ReportController@conclusion_each_month', 'method' => 'GET']) !!}
            <div class="col-md-3">
                {{ Form::selectYear('year', 2017, now()->year, now()->year, ['class' => 'field form-control selectpicker']) }}
            </div>
            <div class="col-md-3">
                {{Form::submit(Lang::get('button.submit'), ['class' => 'btn btn-primary form-control'])}}
            </div>
        {!! Form::close() !!}  
    </div>
</div>