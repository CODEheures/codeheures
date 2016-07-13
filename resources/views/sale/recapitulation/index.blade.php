@extends('layouts.common')

@section('css')
@endsection

@section('title')
    CODEheures | Recapitulation commande
@endsection

@section('navbar')
    @include('navbar.customer', ['active' => null])
@endsection

@section('user.action')
    <h1>Récapitualtion de votre achat</h1>
    <nav class="monitor-return">
        <p><a href="{{ auth()->user()->role == 'admin' ? route('admin.monitor.index'):route('customer.monitor.index') }}"><i class="ion-arrow-left-c"></i>Tableau de bord</a></p>
    </nav>
    <h3>Etape 2/3: Vérifier ma commande</h3>
    @include('sale.recapitulation.view')
@endsection

@section('script')
@endsection