@extends('layouts.common')

@section('css')
    @include('plugins.graphConso.css')
@endsection

@section('navbar')
    @include('navbar.admin', ['active' => 'monitor'])
@endsection

@section('user.action')
    <h1>Bonjour {{ auth()->user()->name }}</h1>
    @include('admin.monitor.view')
@endsection

@section('script')
    @include('plugins.graphConso.scripts')
@endsection