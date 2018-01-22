@extends('navbar.navbar')

@section('navbar_class_option')
    {!! isset($navOptions['shrinkForce']) && $navOptions['shrinkForce'] === true ? 'shrink-force' : 'full' !!}
@endsection

@section('links')
    @if(isset($navOptions['active']) && $navOptions['active'] === 'home')
        <a href="{{ route('home') }}#accueil" aria-selected="true" data-entrie="accueil">Accueil<div class="activeplus"></div></a>
    @else
        <a href="{{ route('home') }}#accueil" aria-selected="false" data-entrie="accueil">Accueil<div class="activeplus"></div></a>
    @endif
    <a href="{{ route('home') }}#prestations" aria-selected="false" data-entrie="prestations">Prestations<div class="activeplus"></div></a>
    <a href="{{ route('home') }}#contact" aria-selected="false" data-entrie="contact">Contact<div class="activeplus"></div></a>
@endsection
