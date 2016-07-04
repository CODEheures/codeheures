@extends('layouts.common')

@section('css')
    @include('plugins.graphConso.css')
@endsection

@section('navbar')
    @include('navbar.customer', ['active' => 'monitor'])
@endsection

@section('user.action')
    <h1>Bonjour {{ auth()->user()->name }}</h1>
    @include('customer.monitor.view')
@endsection

@section('script')
    @include('plugins.graphConso.scripts')
    <script type="text/javascript">
        $(function() {
            $('section#user div.purchase table.purchase-table tfoot').trigger('click');
        });
    </script>
@endsection