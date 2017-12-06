<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PHUNIN') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/css/bootstrap-datepicker.css">
    
</head>
<body>
    <div id="app">
        @include('inc.navbar')
        @include('inc.messages')
        @yield('content')
    </div>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/js/bootstrap-datepicker.min.js"></script>
    <script>
        $('.datepicker').datepicker({
            format:'yyyy-mm-dd',
        });
    </script>
    <!-- use in stock_in.create and edit -->
    <script>
    
    var template = '<div class="form-inline dynamic-form-container">'+
                    spare_part_label + spare_part_field + qyt_field + price_field+   
                    '<a href="#" class="btn btn-xs btn-danger btn-remove">{!!Lang::get('stock_in.remove')!!}</a>'+
                    '</div>';
    $('.btn-add-more').on('click', function(e) {
        e.preventDefault();

        $(this).before(template);
    });

    $(document).on('click','.btn-remove',function(e){
        e.preventDefault();
        $(this).parents('.dynamic-form-container').remove();
    });
</script>
</body>
</html>
