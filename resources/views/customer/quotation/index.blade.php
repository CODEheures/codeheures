@extends('layouts.common')

@section('css')
    @parent
    @include('plugins.qtip.css')
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
    @parent
    @include('plugins.qtip.scripts')
@endsection