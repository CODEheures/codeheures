@extends('navbar.navbar')

@section('navbar_class_option')
    shrink-force
@endsection

@section('links')
    <a href="{{ route('home') }}#accueil">Accueil<div class="activeplus"></div></a>
    <a href="{{ route('home') }}#prestations">Prestations<div class="activeplus"></div></a>
    <a href="{{ route('home') }}#contact">Contact<div class="activeplus"></div></a>
    <a href="{{ route('login') }}"  aria-selected="true">Espace client<div class="activeplus"></div></a>
@endsection