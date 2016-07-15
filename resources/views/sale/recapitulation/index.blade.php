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
        <p><a href="{{ route('customer.sale.choice') }}"><i class="ion-arrow-left-c"></i>Etape 1/3: choix du pack</a></p>
    </nav>
    <h3>Etape 2/3: Vérifier ma commande</h3>
    @include('sale.recapitulation.view')
@endsection

@section('script')
@endsection