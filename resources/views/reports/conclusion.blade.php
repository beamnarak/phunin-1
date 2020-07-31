@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>{{Lang::get('report.conclusion')}}</h3>
                </div>

                <div class="panel-body">
                    <table class="table">
                        <tr>
                            <th>วันที่</th>
                            <th>รับเข้า</th> 
                            <th>เบิกออก</th>
                            <th>คงเหลือ</th>
                        </tr>
                        <tr>
                            <td>ยอดยกมาปี {{$last_year}}</td>
                            <!--td>{{number_format($in_last_year,2)}}</td-->
                            <!--td>{{number_format($out_last_year,2)}}</td-->
                            <td></td>
                            <td></td>
                            <td>{{number_format($previous_remain,2)}}</td>
                        </tr>
                        @for ($i = 0; $i < 12; $i++)
                        <tr>
                            <td>{{$i + 1}} / {{$this_year}}</td>
                            <td>{{ number_format($in[$i], 2) }}</td>
                            <td>{{ number_format($out[$i], 2) }}</td>
                            <td>{{ number_format($remain[$i], 2) }}</td>
                        </tr>
                        @endfor
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection