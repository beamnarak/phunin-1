@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>{{Lang::get('machine_category.title')}}</h3>
                </div>

                <div class="panel-body">
                    <div class="form-group">
                        <h4>{{ Form::label('name', Lang::get('machine_category.name')) }} : {{$machine_category->name}}</h4>
                    </div>
                    <div class="form-group">
                        <h4>{{ Form::label('group', Lang::get('machine_category.group')) }} : 
                            @if($machine_category->group)
                                {{$machine_category->group}}
                            @else
                                -
                            @endif
                        </h4>
                    </div>
                </div>
                <div class="panel-footer">
                <a href="{{route('machine_categories.edit',$machine_category->id)}}" class="btn btn-primary">{{Lang::get('crud.edit')}}</a>
                {!! Form::open(['action' => ['MachineController@destroy', $machine_category->id], 'method' => 'POST', 'class'=>'pull-right' ]) !!}
                    {{Form::hidden('_method','DELETE') }}
                    {{Form::submit(Lang::get('button.delete'), ['class' => 'btn btn-danger'])}}
                {!! Form::close() !!}   
                </div>
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
                                <td>{{$spare_part->group}}</td>
                                <td>{{$spare_part->pivot->amount}} {{$spare_part->unit->name}}</td>
                                <td>{{$stock_out->employee->name}}</td>
                            </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
