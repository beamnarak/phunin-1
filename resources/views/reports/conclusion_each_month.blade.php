@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>สรุปมูลค่ารับเข้าเบิกออกประจำปี {{$year}}</h3>
                </div>
                <div class="panel-body">
                    <table class="table">
                        <tr>
                            <th>เดือน</th>
                            <th>รับเข้า</th>
                            <th>เบิกออก</th>
                        </tr>
                        @for ($i=0; $i < 12; $i++) <tr>

                            <td>{{ $i+1 }}</td>
                            <td>{{ number_format($in[$i], 2) }}</td>
                            <td>{{ number_format($out[$i], 2) }}</td>
                            </tr>
                            @endfor
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection