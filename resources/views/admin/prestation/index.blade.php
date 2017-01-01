@extends('layouts.common')

@section('css')

@endsection

@section('title')
    <title>CODEheures | Prestations standards</title>
@endsection

@section('navbar')
    @include('navbar.admin', ['active' => 'prestations'])
@endsection

@section('user.action')
    <h1>Prestations Standards</h1>
    <nav class="prestation-title">
        <p><a href="{{ route('admin.prestation.create') }}"><i class="ion-ios-plus-outline"></i>Ajouter une prestation standard</a></p>
    </nav>
    @include('admin.prestation.index.view')
@endsection

@section('script')

@endsection