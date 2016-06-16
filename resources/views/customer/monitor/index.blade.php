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
@endsection