@extends('layouts.common')

@section('css')
    @parent
    @include('plugins.inputEffect.css')
@endsection

@section('navbar')
    @include('navbar.customer', ['active' => 'quotation'])
@endsection

@section('user.action')
    <h1>Bonjour {{ auth()->user()->name }}</h1>
    <p>Sauf indication, les montants sont indiqués TTC</p>
    @include('customer.quotation.order.view')
@endsection

@section('script')
    @parent
    <script type="text/javascript">
        $(function() {
            $('section#user div.quotation table.quotation-table tfoot').trigger('click');
        });
    </script>
    @include('plugins.inputEffect.scripts')
@endsection