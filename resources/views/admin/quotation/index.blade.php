@extends('layouts.common')

@section('css')

@endsection

@section('title')
    CODEheures | Devis Clients
@endsection

@section('navbar')
    @include('navbar.admin', ['active' => 'quotation'])
@endsection

@section('user.action')
    <h1>Devis Clients</h1>
    <nav class="quotation-title">
        <p><a href="{{ route('admin.quotation.create') }}"><i class="ion-ios-plus-outline"></i>Ajouter un devis</a></p>
    </nav>
    @include('admin.quotation.index.view')
@endsection

@section('script')

@endsection