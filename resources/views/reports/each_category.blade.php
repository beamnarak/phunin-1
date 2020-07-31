@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-md-offset-0">
            
            <div class="panel-body">
                    <button class="btn btn-primary pull-right">Next</button>
            </div>   
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>{{Lang::get('report.each_category')}}</h3>
                    <h4>Category: {{ $category->name }}</h4>
                    <h4>Month: {{ $month }}</h4>
                    <h4>Year: {{ $year }}</h4>
                </div>             
                <div class="panel-body">
                    <table class="table">
                        <tr>
                            <th>Code</th>
                            <th>Detail</th>
                            <th>Price/Unit</th>
                            <th>Bring Forward</th>
                            <th>In</th>
                            <th>Out</th>
                            <th>Carry Forward</th>
                        </tr>
                        @for ($i = 0; $i < $spare_parts->count(); $i++)
                        <tr>
                            <td>{{ $code[$i] }}</td>
                            <td>{{ $description[$i] }}</td>
                            <td>{{ $price_per_unit[$i] }}</td>
                            <td>{{ $bring_forward[$i] }}</td>
                            <td>{{ $in[$i] }}</td>
                            <td>{{ $out[$i] }}</td>
                            <td>{{ $carry_forward[$i] }}</td>
                        </tr>
                        @endfor
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection