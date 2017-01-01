@extends('layouts.common')

@section('css')

@endsection

@section('title')
    <title>CODEheures | Produits</title>
@endsection

@section('navbar')
    @include('navbar.admin', ['active' => 'product'])
@endsection

@section('user.action')
    <h1>Produits</h1>
    <nav class="product-title">
        <p><a href="{{ route('admin.product.create') }}"><i class="ion-ios-plus-outline"></i>Ajouter un produit</a></p>
    </nav>
    @include('admin.product.index.view')
@endsection

@section('script')

@endsection