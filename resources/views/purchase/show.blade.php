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

@section('description')
    <meta name="description" content="Pour le suivi de la création de votre application internet, CODEheures vous met à disposition un dashboard client.">
@endsection

@section('navbar')
    @if(auth()->user()->role == 'admin')
        @include('navbar.admin', ['active' => 'monitor'])
    @else
        @include('navbar.customer', ['active' => 'monitor'])
    @endif
@endsection

@section('user.action')
    <h1>Détails commande</h1>
    <nav class="monitor-return">
        <p><a href="{{ auth()->user()->role == 'admin' ? route('admin.monitor.index'):route('customer.monitor.index') }}"><i class="ion-arrow-left-c"></i>Tableau de bord</a></p>
    </nav>
    @include('purchase.view')
@endsection

@section('script')
    @parent
    @include('plugins.graphConso.scripts')
@endsection