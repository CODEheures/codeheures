@extends('layouts.common')

@section('css')
    @include('plugins.graphConso.css')
    @include('plugins.introJs.css')
@endsection

@section('navbar')
    @include('navbar.customer', ['active' => 'monitor'])
@endsection

@section('user.action')
    <h1 @if(auth()->user()->email == env('DEMO_USER_MAIL')) data-intro="Vous ici en visiteur. Toutes les actions sont
     accessibles sans conséquence en mode 'bac à sable'. Même le paiment paypal est mis à disposition avec un compte
     de test (utilisateur+mot de passe fournis) si vous souhaitez aller jusqu'au bout du test d'achat pour recharger ce compte"
        data-step="1" data-position="bottom" @endif
    >Bonjour {{ auth()->user()->name }} @if(auth()->user()->email == env('DEMO_USER_MAIL'))<small><a href="#" id="visite"><i class="fa fa-angle-right"></i> Faire la visite <i class="fa fa-angle-left"></i> </a></small> @endif</h1>
    @include('customer.monitor.view')
@endsection

@section('script')
    @include('plugins.graphConso.scripts')
    <script type="text/javascript">
        $(function() {
            $('section#user div.purchase table.purchase-table tfoot').trigger('click');
        });
    </script>
    @include('plugins.introJs.scripts')
@endsection