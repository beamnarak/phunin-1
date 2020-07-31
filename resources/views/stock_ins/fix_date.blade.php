@extends('layouts.app')

@section('content')
    <ul>
    @foreach($stock_ins as $stock_in)
        @foreach($stock_in->spare_parts as $spare_part)
        <li> {{$stock_in->order_id}} || {{$spare_part->pivot->date}}</li>
        @endforeach
    @endforeach
    </ul>
@endsection