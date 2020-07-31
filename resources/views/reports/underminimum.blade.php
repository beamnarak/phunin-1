@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>{{Lang::get('report.remind_low')}}</h3>
                </div>

                <div class="panel-body">
                @if(count($spare_parts) > 0)
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{Lang::get('spare_part.code')}}</th>
                                <th>{{Lang::get('spare_part.description')}}</th>
                                <th>{{Lang::get('spare_part.remain')}}</th>
                                <th>{{Lang::get('spare_part.minimum')}}</th>
                                <th>{{Lang::get('unit.title')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                                @foreach($spare_parts as $spare_part)
                                <tr>
                                    @if($spare_part->getTotalAmount() < $spare_part->minimum)
                                    <td>{{$spare_part->code}}</td>
                                    <td><a href="{{route('spare_parts.show', $spare_part->id)}}">{{$spare_part->description}}</a></td>
                                        <td>{{$spare_part->getTotalAmount()}}</td>
                                        <td>{{$spare_part->minimum}}</td>
                                        <td>{{$spare_part->unit->name}}</td>
                                    @endif
                                </tr>
                                @endforeach
                            
                        </tbody>
                    </table>
                    @else
                        No Shop Found.
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection