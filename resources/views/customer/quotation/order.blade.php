@extends('layouts.common')

@section('css')
    @parent
    @include('plugins.inputEffect.css')
    @include('plugins.introJs.css')
@endsection

@section('navbar')
    @include('navbar.customer', ['active' => 'quotation'])
@endsection

@section('user.action')
    <h1 @if(auth()->user()->isDemo) data-intro="Vous ici en visiteur. Toutes les actions sont
     accessibles sans conséquence en mode 'bac à sable'. Vous pouvez tester de rentrer le code SMS en bas de page afin
      de constater l'effet sur ce compte client"
         data-step="1" data-position="bottom" @endif
    >Bonjour {{ auth()->user()->name }} @if(auth()->user()->isDemo)<small><a href="#" id="visite"><i class="fa fa-angle-right"></i> Faire la visite <i class="fa fa-angle-left"></i> </a></small> @endif</h1>
    <p>Sauf indication, les montants sont indiqués TTC</p>
    @include('customer.quotation.order.view')
@endsection

@section('script')
    @parent
    @include('plugins.introJs.scripts')
@endsection