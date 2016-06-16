@extends('navbar.navbar')

@section('navbar_class_option')
    shrink-force
@endsection

@section('links')
    <a href="{{ route('home') }}#accueil" >Accueil</a>
    <a href="{{ route('admin.monitor.index') }}" {!! ($active == 'monitor') ? 'class="active"':'' !!}>Suivis clients</a>
    <a href="{{ route('admin.quotation.index') }}" {!! ($active == 'quotation') ? 'class="active"':'' !!}>Devis</a>
    <a href="{{ route('admin.product.index') }}" {!! ($active == 'product') ? 'class="active"':'' !!}>Produits</a>
@endsection