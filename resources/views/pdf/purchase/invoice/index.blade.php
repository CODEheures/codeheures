@extends('layouts.pdf')

@section('user.action')
    @if(auth()->user()->isDemo)
        <div class="specimen"><img src=".//images/specimen.png"></div>
    @endif
    <div class="seller">
        <div class="from-seller">Designation du vendeur</div>
        <div class="infos">
            Sylvain Gagnot - CODEheures EIRL<br />
            1 rue Milhaud, 37300 Joué-les-Tours<br />
            Siret: 827 753 864 00012
        </div>
    </div>
    <div class="clear"></div>
    <div class="customer">
        <div class="to-customer">Designation du client</div>
        <div class="infos">
            {{ $payment->getPayer()->getPayerInfo()->getShippingAddress()->getRecipientName() }}<br />
            {{ $payment->getPayer()->getPayerInfo()->getShippingAddress()->getLine1() }}<br />
            {{ $payment->getPayer()->getPayerInfo()->getShippingAddress()->getLine2() }}<br />
            {{ $payment->getPayer()->getPayerInfo()->getShippingAddress()->getPostalCode() }} {{ $payment->getPayer()->getPayerInfo()->getShippingAddress()->getCity() }}<br />
        </div>
    </div>
    <div class="clear"></div>
    @include('pdf.purchase.invoice.view')
@endsection