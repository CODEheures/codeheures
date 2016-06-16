@extends('navbar.navbar')

@section('navbar_class_option')
    shrink-force
@endsection

@section('links')
    <a href="{{ route('home') }}#accueil" >Accueil</a>
    <a href="{{ route('customer.monitor.index') }}" {!! ($active == 'monitor') ? 'class="active"':'' !!}>Mon suivi</a>
    <a href="{{ route('customer.quotation.index') }}" {!! ($active == 'quotation') ? 'class ="active"':'' !!}>Mes devis{!! (session()->get('nbNewQuote') > 0) ? '<span class="newQuote">'.session()->get('nbNewQuote').'</span>':'' !!}</a>
    <a href="{{ route('customer.account.edit') }}"  {!! ($active == 'account') ? 'class ="active"':'' !!}>Mon profil</a>
@endsection