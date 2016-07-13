@extends('layouts.common')

@section('css')
@endsection

@section('title')
    CODEheures | Recharger mon compte
@endsection

@section('navbar')
    @include('navbar.customer', ['active' => null])
@endsection

@section('user.action')
    <h1>Recharger mon compte en heures</h1>
    <nav class="monitor-return">
        <p><a href="{{ auth()->user()->role == 'admin' ? route('admin.monitor.index'):route('customer.monitor.index') }}"><i class="ion-arrow-left-c"></i>Tableau de bord</a></p>
    </nav>
    <h3>Etape 1/3: choix du pack</h3>
    @include('sale.choice.view')
@endsection

@section('script')
@endsection