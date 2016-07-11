@extends('layouts.common')

@section('css')
    @parent
    @include('plugins.inputEffect.css')
@endsection

@section('title')
    CODEheures | Création Devis Clients
@endsection

@section('navbar')
    @include('navbar.admin', ['active' => 'quotation'])
@endsection

@section('user.action')
    <h1>Nouveau devis clients</h1>
    <nav class="quotation-title">
        <p><a href="{{ route('admin.quotation.index') }}"><i class="ion-arrow-left-c"></i>Retour à la liste des devis</a></p>
    </nav>
    @include('admin.quotation.create.view')
@endsection

@section('script')
    @parent

@endsection