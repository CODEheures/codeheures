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
        <h1>Mentions légales et politique de confidentialité</h1>
        <h2 class="fa fa-quote-left">1°)</h2>
        <p>
            <!-- voir http://www.fobec.com/legale-et-politique-confidentialite.html -->
        </p>
@endsection

@section('script')@endsection