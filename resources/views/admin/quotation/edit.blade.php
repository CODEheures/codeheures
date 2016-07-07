@extends('layouts.common')

@section('css')
    @parent
    @include('plugins.inputEffect.css')
@endsection

@section('title')
    CODEheures | Edition Devis Clients
@endsection

@section('navbar')
    @include('navbar.admin', ['active' => 'quotation'])
@endsection

@section('user.action')
    <h1>Edition devis clients</h1>
    <nav class="quotation-title">
        <p><a href="{{ route('admin.quotation.index') }}"><i class="ion-arrow-left-c"></i>Retour à la liste des devis</a></p>
    </nav>
    @include('admin.quotation.edit.view')
@endsection

@section('script')
    @parent
    @include('plugins.inputEffect.scripts')
@endsection