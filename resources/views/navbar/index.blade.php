@extends('navbar.navbar')

@section('navbar_class_option')
    {!! isset($navOptions['shrinkForce']) && $navOptions['shrinkForce'] === true ? 'shrink-force' : 'full' !!}
@endsection

@section('links')
    @if(isset($navOptions['active']) && $navOptions['active'] === 'home')
        <a href="{{ route('home') }}#accueil" aria-selected="true">Accueil<div class="activeplus"></div></a>
    @else
        <a href="{{ route('home') }}#accueil" aria-selected="false">Accueil<div class="activeplus"></div></a>
    @endif
    <a href="{{ route('home') }}#prestations" aria-selected="false">Prestations<div class="activeplus"></div></a>
    <a href="{{ route('home') }}#contact" aria-selected="false">Contact<div class="activeplus"></div></a>
    @if(auth()->check() && auth()->user()->role == 'user')
        <a href="{{ route('customer.monitor.index') }}" aria-selected="false">Espace client<div class="activeplus"></div></a>
    @elseif(auth()->check() && auth()->user()->role == 'admin')
        <a href="{{ route('admin.monitor.index') }}" aria-selected="false">Espace admin<div class="activeplus"></div></a>
    @else
        @if(isset($navOptions['active']) && $navOptions['active'] === 'customer')
            <a href="{{ route('login') }}" aria-selected="true">Espace client<div class="activeplus"></div></a>
        @else
            <a href="{{ route('login') }}" aria-selected="false">Espace client<div class="activeplus"></div></a>
        @endif
    @endif
@endsection
