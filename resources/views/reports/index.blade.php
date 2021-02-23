@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="jumbotron">
                <h1 class="display-4">Report</h1>
                @include('inc.report_month_year_shop_form')
                @include('inc.report_month_year_machine_form')
                @include('inc.report_each_category_form')
                @include('inc.report_conclusion_each_month_form')
            </div>
        </div>
    </div>
</div>
@endsection