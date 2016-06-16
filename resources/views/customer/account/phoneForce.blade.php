@extends('layouts.common')

@section('navbar')
    @include('navbar.customer', ['active' => 'account'])
@endsection

@section('user.action')
    <h1>Bonjour {{ auth()->user()->name }}</h1>
    @include('customer.account.phoneForce.view')
@endsection