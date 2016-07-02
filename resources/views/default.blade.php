<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="CODEheures | Sylvain Gagnot">
    <link rel="icon" type="image/png" href="{{ asset('css/images/favicon.png') }}">

    <title>@yield('title')</title>

    <!-- CSS -->

    @yield('css')
    @if(isset($isPdf) && $isPdf)
    {{--<link rel="stylesheet" type="text/css" href="{{ asset('css/pdf.css') }}">--}}
    @else
        <link href="{{ asset('css/select2/select2.css') }}" rel="stylesheet" />
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,800,400,600|Arvo:700|Flamenco:300' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    @endif
</head>

<body>

@yield('navbar')


@include('flash')
@include('error')


@yield('header')

@yield('main')



    @if(isset($isPdf) && $isPdf)
    @else
    <footer>
        @yield('footer')
    </footer>
    <script src="{{ asset('js/jquery-2.1.4.min.js') }}"></script>
    <script src="{{ asset('js/css.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[multiple]').select2();
        });
    </script>
    @endif
    @yield('script')
</body>
</html>
