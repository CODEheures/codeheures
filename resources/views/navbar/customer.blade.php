@extends('navbar.navbar')

@section('navbar_class_option')
    shrink-force
@endsection

@section('links')
    <a href="{{ route('home') }}#accueil" aria-selected="false">Accueil<div class="activeplus"></div></a>
    <a href="{{ route('customer.monitor.index') }}" {!! ($active == 'monitor') ? 'aria-selected="true"':'aria-selected="false"' !!}>Mon suivi<div class="activeplus"></div></a>
    <a href="{{ route('customer.quotation.index') }}" {!! ($active == 'quotation') ? 'aria-selected="true"':'aria-selected="false"' !!}>
        <div class="composite-title" @if(auth()->user()->email == env('DEMO_USER_MAIL') && $active != 'quotation') data-intro="Ce lien de menu vous permet d'acceder à vos devis que vous pouvez valider en ligne par code SMS"
             data-step="11" data-position="bottom" data-highlightClass="introjs_class1" @endif>
            <span>Mes devis</span>{!! (session()->get('nbNewQuote') > 0) ? '<span class="newQuote">'.session()->get('nbNewQuote').'</span>':'' !!}</div><div class="activeplus">

        </div>
    </a>
    <a href="{{ route('customer.account.edit') }}"  {!! ($active == 'account') ? 'aria-selected="true"':'aria-selected="false"' !!}>Mon profil<div class="activeplus"></div></a>
@endsection