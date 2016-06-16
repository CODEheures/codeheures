@extends('navbar.navbar')

@section('navbar_class_option')
    shrink-force
@endsection

@section('links')
    <a href="{{ route('home') }}#accueil">Accueil</a>
    <a href="{{ route('home') }}#prestations">Prestations</a>
    <a href="{{ route('home') }}#contact">Contact</a>
    <a href="{{ route('login') }}"  class="active">Espace client</a>
@endsection