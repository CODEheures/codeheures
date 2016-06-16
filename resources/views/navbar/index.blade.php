@extends('navbar.navbar')

@section('navbar_class_option')
    full
@endsection

@section('links')
    <a href="{{ route('home') }}#accueil" class="active">Accueil</a>
    <a href="{{ route('home') }}#prestations">Prestations</a>
    <a href="{{ route('home') }}#contact">Contact</a>
    @if(auth()->check() && auth()->user()->role == 'user')
        <a href="{{ route('customer.monitor.index') }}">Espace client</a>
    @elseif(auth()->check() && auth()->user()->role == 'admin')
        <a href="{{ route('admin.monitor.index') }}">Espace admin</a>
    @else
        <a href="{{ route('login') }}">Espace client</a>
    @endif
@endsection
