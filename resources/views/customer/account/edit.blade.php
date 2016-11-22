@extends('layouts.common')

@section('meta-index')
    <meta name="robots" content="noindex, nofollow">
@endsection

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

@endsection