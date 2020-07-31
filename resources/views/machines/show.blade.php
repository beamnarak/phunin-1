@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>{{Lang::get('machine.title')}}</h3>
                </div>

                <div class="panel-body">
                    <div class="form-group">
                        <h4>{{ Form::label('name', Lang::get('machine.name')) }} : {{$machine->name}}</h4>
                    </div>
                    <div class="form-group">
                        <h4>id: {{$machine->id}}</h4>
                    </div>
                    <div class="form-group">
                        <h4>{{ Form::label('description', Lang::get('machine.description')) }} : 
                            @if($machine->description)
                                {{$machine->description}}
                            @else
                                -
                            @endif
                        </h4>
                    </div>
                </div>
                <div class="panel-footer">
                <a href="{{route('machines.edit',$machine->id)}}" class="btn btn-primary">{{Lang::get('crud.edit')}}</a>
                {!! Form::open(['action' => ['MachineController@destroy', $machine->id], 'method' => 'POST', 'class'=>'pull-right' ]) !!}
                    {{Form::hidden('_method','DELETE') }}
                    {{Form::submit(Lang::get('button.delete'), ['class' => 'btn btn-danger'])}}
                {!! Form::close() !!}   
                </div>
                <hr>
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#stock_out_tab">รายการเบิกอะไหล่</a></li>
                    <li><a data-toggle="tab" href="#repairment_tab">รายการซ่อม</a></li>
                </ul>

                <div class="tab-content">
                    <!-- Stock Out -->
                    <div id="stock_out_tab" class="tab-pane fade in active">
                        <table class="table">
                            <thead>
                                <th>{{Lang::get('stock_out.date')}}</th>
                                <th>{{Lang::get('stock_out.request_id')}}</th>
                                <th>{{Lang::get('spare_part.title')}}</th>
                                <th>{{Lang::get('stock_out.qty')}}</th>
                                <th>{{Lang::get('stock_out.requestioner')}}</th>
                            </thead>
                            <tbody>
                                @foreach($stock_outs as $stock_out)
                                    @foreach($stock_out->spare_parts as $spare_part)
                                    <tr> 
                                        <td>{{$spare_part->pivot->date}}</td>
                                        <td><a href="{{route('stock_outs.show', $stock_out->id)}}">{{$stock_out->request_id}}</a></td>
                                        <td>{{$spare_part->description}}</td>
                                        <td>{{$spare_part->pivot->amount}} {{$spare_part->unit->name}}</td>
                                        @if($stock_out->employee != null)
                                        <td>{{$stock_out->employee->name}}</td>
                                        @else
                                        <td>null</td>
                                        @endif
                                    </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- Repairments -->
                    <div id="repairment_tab" class="tab-pane fade in active">
                        <table class="table">
                            <thead>
                                <th>{{Lang::get('repairment.start_date')}}</th>
                                <th>{{Lang::get('repairment.end_date')}}</th>
                                <th>{{Lang::get('repairment.shop')}}</th>
                                <th>{{Lang::get('repairment.cost')}}</th>
                                <th>{{Lang::get('repairment.description')}}</th>
                            </thead>
                            <tbody>
                                @foreach($repairments as $repairment)
                                    <tr> 
                                        <td><a href="{{route('repairments.show', $repairment->id)}}">{{$repairment->start_date}}</a></td>
                                        <td><a href="{{route('repairments.show', $repairment->id)}}">{{$repairment->end_date}}</a></td>
                                        <td>{{$repairment->shop->name}}</td>
                                        <td>{{number_format($repairment->wage_cost + $repairment->travel_cost + 
                                            $repairment->accommodation_fee + $repairment->spare_part_cost + 
                                            $repairment->delivery_cost + $repairment->clearance_cost, 2) }}</td>
                                        <td>{{$repairment->description}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>                        
            </div>
        </div>
    </div>
</div>
@endsection
