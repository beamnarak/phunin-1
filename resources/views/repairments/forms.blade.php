<!-- start_date -->
<div class="form-group">
    {{Form::label('start_date', Lang::get('repairment.start_date')) }}
    {{Form::text('start_date',null,['class' => 'form-control datepicker', 'placeholder' => Lang::get('repairment.start_date') ])}}
</div>

<!-- end_date -->
<div class="form-group">
    {{Form::label('end_date', Lang::get('repairment.end_date')) }}
    {{Form::text('end_date',null,['class' => 'form-control datepicker', 'placeholder' => Lang::get('repairment.end_date') ])}}
</div>

<!-- shop_id -->
<div class="form-group">
    {{Form::label('shop', Lang::get('repairment.shop')) }}
    {{Form::select('shop_id', $shops->pluck('name','id'),null,['placeholder'=>'ไม่มีรายการที่ถูกเลือก','class' => 'form-control selectpicker','data-live-search'=>'true', 'id'=>'beam']) }} 
    
</div>

<!-- machine_id -->
<div class="form-group">
    {{Form::label('machine', Lang::get('machine.title')) }}
    {{Form::select('machine_id', $machines->pluck('name','id'),null,['placeholder'=>'ไม่มีรายการที่ถูกเลือก','class' => 'form-control selectpicker','data-live-search'=>'true'])}}
    <!-- {{Form::text('machine',null,['class' => 'form-control', 'placeholder' => Lang::get('repairment.machine'), 'id'=>'machine_field' ])}} -->

</div>

<!-- wage_cost -->
<div class="form-group">
    {{Form::label('wage_cost', Lang::get('repairment.wage_cost')) }}
    {{Form::number('wage_cost',null,['class' => 'form-control', 'placeholder' => Lang::get('repairment.wage_cost'), 'min' =>'0.00', 'step'=>'0.01'])}}
</div>

<!-- travel_cost -->
<div class="form-group">
    {{Form::label('travel_cost', Lang::get('repairment.travel_cost')) }}
    {{Form::number('travel_cost',null,['class' => 'form-control', 'placeholder' => Lang::get('repairment.travel_cost'), 'min' =>'0.00', 'step'=>'0.01'])}}
</div>

<!-- accommodation_fee -->
<div class="form-group">
    {{Form::label('accommodation_fee', Lang::get('repairment.accommodation_fee')) }}
    {{Form::number('accommodation_fee',null,['class' => 'form-control', 'placeholder' => Lang::get('repairment.accommodation_fee'), 'min' =>'0.00', 'step'=>'0.01'])}}
</div>

<!-- spare_part_cost -->
<div class="form-group">
    {{Form::label('spare_part_cost', Lang::get('repairment.spare_part_cost')) }}
    {{Form::number('spare_part_cost',null,['class' => 'form-control', 'placeholder' => Lang::get('repairment.spare_part_cost'), 'min' =>'0.00', 'step'=>'0.01'])}}
</div>

<!-- delivery_cost -->
<div class="form-group">
    {{Form::label('delivery_cost', Lang::get('repairment.delivery_cost')) }}
    {{Form::number('delivery_cost',null,['class' => 'form-control', 'placeholder' => Lang::get('repairment.accommodation_fee'), 'min' =>'0.00', 'step'=>'0.01'])}}
</div>

<!-- clearance_cost -->
<div class="form-group">
    {{Form::label('clearance_cost', Lang::get('repairment.clearance_cost')) }}
    {{Form::number('clearance_cost',null,['class' => 'form-control', 'placeholder' => Lang::get('repairment.clearance_cost'), 'min' =>'0.00', 'step'=>'0.01'])}}
</div>

<!-- description -->
<div class="form-group">
    {{ Form::label('description', Lang::get('repairment.description')) }}
    {{Form::textarea('description',null,['class' => 'form-control', 'placeholder' => Lang::get('repairment.description') ])}}
</div>

<!-- payment_list -->
<div class="form-group">
    {{ Form::label('payment_list', Lang::get('repairment.payment_list')) }}
    {{Form::textarea('payment_list',null,['class' => 'form-control', 'placeholder' => Lang::get('repairment.payment_list') ])}}
</div>
<hr>
{{Form::submit($submitButtonText, ['class' => 'btn btn-primary pull-right'])}}
                