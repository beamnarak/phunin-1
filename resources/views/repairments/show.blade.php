@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>{{Lang::get('repairment.title')}}</h3>
                </div>

                <div class="panel-body">
                    <div class="form-group">
                        <h4>{{ Form::label('start_date', Lang::get('repairment.start_date')) }} : 
                            @if($repairment->start_date)
                                {{$repairment->start_date}}
                            @else
                                -
                            @endif
                        </h4>
                        <h4>{{ Form::label('end_date', Lang::get('repairment.end_date')) }} : 
                            @if($repairment->end_date)
                                {{$repairment->end_date}}
                            @else
                                -
                            @endif
                        </h4>
                        <h4>{{ Form::label('shop', Lang::get('repairment.shop')) }} : 
                            @if($repairment->shop_id)
                                {{$repairment->shop->name}}
                            @else
                                -
                            @endif
                        </h4>
                        <h4>{{ Form::label('machine', Lang::get('repairment.machine')) }} : 
                            @if($repairment->machine_id)
                                {{$repairment->machine->name}}
                            @else
                                -
                            @endif
                        </h4>
                        <h4>{{ Form::label('description', Lang::get('repairment.description')) }} : 
                            @if($repairment->description)
                                {{$repairment->description}}
                            @else
                                -
                            @endif
                        </h4>
                        <h4>{{ Form::label('payment_list', Lang::get('repairment.payment_list')) }} : 
                            @if($repairment->payment_list)
                                {{$repairment->payment_list}}
                            @else
                                -
                            @endif
                        </h4>

                        <hr>
                        <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Cost List</th>
                                <th>Price (฿)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ Lang::get('repairment.wage_cost') }}</td>
                                <td>
                                    @if($repairment->wage_cost)
                                        {{ number_format($repairment->wage_cost, 2) }}
                                    @else
                                        -
                                    @endif
                                </td>
                            <tr>
                            <tr>
                                <td>{{ Lang::get('repairment.travel_cost') }}</td>
                                <td>
                                    @if($repairment->travel_cost)
                                        {{ number_format($repairment->travel_cost, 2) }}
                                    @else
                                        -
                                    @endif
                                </td>
                            <tr>
                            <tr>
                                <td>{{ Lang::get('repairment.accommodation_fee') }}</td>
                                <td>
                                    @if($repairment->accommodation_fee)
                                        {{ number_format($repairment->accommodation_fee, 2) }}
                                    @else
                                        -
                                    @endif
                                </td>
                            <tr>
                            <tr>
                                <td>{{ Lang::get('repairment.spare_part_cost') }}</td>
                                <td>
                                    @if($repairment->spare_part_cost)
                                        {{ number_format($repairment->spare_part_cost, 2) }}
                                    @else
                                        -
                                    @endif
                                </td>
                            <tr>
                            <tr>
                                <td>{{ Lang::get('repairment.delivery_cost') }}</td>
                                <td>
                                    @if($repairment->delivery_cost)
                                        {{ number_format($repairment->delivery_cost, 2) }}
                                    @else
                                        -
                                    @endif
                                </td>
                            <tr>
                            <tr>
                                <td>{{ Lang::get('repairment.clearance_cost') }}</td>
                                <td>
                                    @if($repairment->clearance_cost)
                                        {{ number_format($repairment->clearance_cost, 2) }}
                                    @else
                                        -
                                    @endif
                                </td>
                            <tr>
                            <tr>
                                <td>{{ Lang::get('repairment.total') }}</td>
                                <td>
                                    @if($repairment->getTotal())
                                        {{ number_format($repairment->getTotal(), 2) }}
                                    @else
                                        -
                                    @endif
                                </td>
                            <tr>
                        </tbody>
                        </table>

                    </div>
                </div>


                <div class="panel-footer">
                <a href="{{route('repairments.edit',$repairment->id)}}" class="btn btn-primary">{{Lang::get('crud.edit')}}</a>
                {!! Form::open(['action' => ['RepairmentController@destroy', $repairment->id], 'method' => 'POST', 'class'=>'pull-right' ]) !!}
                    {{Form::hidden('_method','DELETE') }}
                    {{Form::submit(Lang::get('button.delete'), ['class' => 'btn btn-danger'])}}
                {!! Form::close() !!}   
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection
