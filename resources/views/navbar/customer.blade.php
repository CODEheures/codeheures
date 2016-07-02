@extends('navbar.navbar')

@section('navbar_class_option')
    shrink-force
@endsection

@section('links')
    <a href="{{ route('home') }}#accueil" >Accueil</a>
    <a href="{{ route('customer.monitor.index') }}" {!! ($active == 'monitor') ? 'aria-selected="true"':'aria-selected="false"' !!}>Mon suivi<div class="activeplus"></div></a>
    <a href="{{ route('customer.quotation.index') }}" {!! ($active == 'quotation') ? 'aria-selected="true"':'aria-selected="false"' !!}>Mes devis{!! (session()->get('nbNewQuote') > 0) ? '<span class="newQuote">'.session()->get('nbNewQuote').'</span>':'' !!}<div class="activeplus"></div></a>
    <a href="{{ route('customer.account.edit') }}"  {!! ($active == 'account') ? 'aria-selected="true"':'aria-selected="false"' !!}>Mon profil<div class="activeplus"></div></a>
@endsection