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

@endsection