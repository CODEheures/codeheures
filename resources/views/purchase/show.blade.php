@extends('layouts.common')

@section('css')
    @parent
    @include('plugins.graphConso.css')
    @include('plugins.inputEffect.css')
@endsection

@section('title')
    CODEheures | Commande {{ $purchase->hash_key }}
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