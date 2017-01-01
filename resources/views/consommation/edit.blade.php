@extends('layouts.common')

@section('meta-index')
    <meta name="robots" content="noindex">
@endsection

@section('css')
    @parent
    @include('plugins.graphConso.css')
    @include('plugins.inputEffect.css')
@endsection

@section('title')
    <title>CODEheures | Commande {{ $purchase->hash_key }}</title>
@endsection

@section('navbar')
    @include('navbar.admin', ['active' => 'monitor'])
@endsection

@section('user.action')
    <h1>Détails commande N° {{ $purchase->hash_key }}</h1>
    <nav class="monitor-return">
        <p><a href="{{ route('purchase.show', ['id' => $purchase->id]) }}"><i class="ion-arrow-left-c"></i>Commande</a></p>
    </nav>
    @include('consommation.view')
@endsection

@section('script')
    @parent
    @include('plugins.graphConso.scripts')
@endsection