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
                        @for ($j=0; $j < $year_amount ; $j++) @for ($i=0; $i < 12; $i++) <tr>

                            <td>{{$i + 1}} / {{$j+$start_year}}</td>
                            <td>{{ number_format($in[$count], 2) }}</td>
                            <td>{{ number_format($out[$count], 2) }}</td>
                            <td>{{ number_format($remain[$count], 2) }}</td>
                        
                            </tr>
                            <?php $count++; ?>
                            @endfor
                            @endfor
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection