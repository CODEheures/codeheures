@extends('layouts.common')

@section('css')
    @parent
    @include('plugins.inputEffect.css')
@endsection

@section('title')
    CODEheures | Edition Prestation standard
@endsection

@section('navbar')
    @include('navbar.admin', ['active' => 'prestations'])
@endsection

@section('user.action')
    <h1>Edition prestations standard</h1>
    <nav class="prestation-title">
        <p><a href="{{ route('admin.prestation.index') }}"><i class="ion-arrow-left-c"></i>Retour à la liste des prestations standards</a></p>
    </nav>
    @include('admin.prestation.edit.view')
@endsection

@section('script')

@endsection