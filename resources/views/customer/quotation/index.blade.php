@extends('layouts.common')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/qtip2/jquery.qtip.css') }}">
@endsection

@section('navbar')
    @include('navbar.customer', ['active' => 'quotation'])
@endsection

@section('user.action')
    <h1>Bonjour {{ auth()->user()->name }}</h1>
    <p>Sauf indication, les montants sont indiqués TTC</p>
    @include('customer.quotation.index.view')
@endsection

@section('script')
    <script type="text/javascript">
        $(function() {
            $('section#user div.quotation table.quotation-table tfoot').trigger('click');
        });
    </script>
    <script type="text/javascript" src="{{ asset('js/qtip2.min.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            $('a[title]').qtip({
                position: {
                    my: 'top center',
                    at: 'bottom center'
                },
                style: {
                    classes: 'qtip-tipsy'
                }
            });
        });
    </script>
@endsection