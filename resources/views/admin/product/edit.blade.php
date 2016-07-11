@extends('layouts.common')

@section('css')
    @parent
    @include('plugins.inputEffect.css')
@endsection

@section('title')
    CODEheures | Edition Produit
@endsection

@section('navbar')
    @include('navbar.admin', ['active' => 'product'])
@endsection

@section('user.action')
    <h1>Edition produit</h1>
    <nav class="product-title">
        <p><a href="{{ route('admin.product.index') }}"><i class="ion-arrow-left-c"></i>Retour à la liste des produits</a></p>
    </nav>
    @include('admin.product.edit.view')
@endsection

@section('script')
    @parent

@endsection