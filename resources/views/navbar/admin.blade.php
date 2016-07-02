@extends('navbar.navbar')

@section('navbar_class_option')
    shrink-force
@endsection

@section('links')
    <a href="{{ route('home') }}#accueil" >Accueil<div class="activeplus"></div></a>
    <a href="{{ route('admin.monitor.index') }}" {!! ($active == 'monitor') ? 'aria-selected="true"':'aria-selected="false"' !!}>Suivis clients<div class="activeplus"></div></a>
    <a href="{{ route('admin.quotation.index') }}" {!! ($active == 'quotation') ? 'aria-selected="true"':'aria-selected="false"' !!}>Devis<div class="activeplus"></div></a>
    <a href="{{ route('admin.product.index') }}" {!! ($active == 'product') ? 'aria-selected="true"':'aria-selected="false"' !!}>Produits<div class="activeplus"></div></a>
@endsection