@extends('layouts.common')

@section('css')
    @parent
    @include('plugins.inputEffect.css')
@endsection

@section('title')
    <title>CODEheures | Ajout Prestation Standard</title>
@endsection

@section('navbar')
    @include('navbar.admin', ['active' => 'prestations'])
@endsection

@section('user.action')
    <h1>Ajout prestation standard</h1>
    <nav class="prestation-title">
        <p><a href="{{ route('admin.prestation.index') }}"><i class="ion-arrow-left-c"></i>Retour à la liste des prestations standards</a></p>
    </nav>
    @include('admin.prestation.edit.view')
@endsection

@section('script')

@endsection