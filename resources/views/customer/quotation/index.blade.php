@extends('layouts.common')

@section('css')
    @parent
    @include('plugins.qtip.css')
    @include('plugins.introJs.css')
@endsection

@section('navbar')
    @include('navbar.customer', ['active' => 'quotation'])
@endsection

@section('user.action')
    <h1>Bonjour {{ auth()->user()->name }} @if(auth()->user()->email == env('DEMO_USER_MAIL'))<small><a href="#" id="visite"><i class="fa fa-angle-right"></i> Faire la visite <i class="fa fa-angle-left"></i> </a></small> @endif</h1>
    <p>Sauf indication, les montants sont indiqués TTC</p>
    @include('customer.quotation.index.view')
@endsection

@section('script')
    @parent
    @include('plugins.qtip.scripts')
    @include('plugins.introJs.scripts')
@endsection