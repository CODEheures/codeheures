@extends('layouts.common')

@section('css')
    @parent
    @include('plugins.inputEffect.css')
@endsection

@section('navbar')
    @include('navbar.customer', ['active' => 'account'])
@endsection

@section('user.action')
    <h1>Bonjour {{ auth()->user()->name }}</h1>
    @include('customer.account.edit.view')
@endsection

@section('script')
    @parent
    @include('plugins.inputEffect.scripts')
@endsection