@extends('layouts.common')

@section('css')
    @parent
    @include('plugins.inputEffect.css') <!-- uniquement pour l'apelle à fa-icon! -->
@endsection

@section('title')
    CODEheures | Conditions générales de vente
@endsection

@section('navbar')
    @include('navbar.index', ['navOptions' => ['shrinkForce' => true, 'active' => null]])
@endsection

@section('user.action')
        <h1>Conditions Générales de ventes</h1>
        <h2 class="fa fa-quote-left">1°)</h2>
        <p>
            condition...
        </p>
@endsection

@section('script')@endsection