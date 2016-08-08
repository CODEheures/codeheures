@extends('layouts.pdf')

@section('user.action')
    @if(auth()->user()->isDemo)
        <div class="specimen"><img src="{{ asset('css/images/specimen.png') }}"></div>
    @endif
    <div class="seller">
        <div class="from-seller">Designation du vendeur</div>
        <div class="infos">
            Sylvain Gagnot - CODEheures<br />
            Entreprise individuelle<br />
            1 rue Milhaud, 37300 Joué-les-Tours<br />
            Siret: 1234567891234
        </div>
    </div>
    <div class="clear"></div>
    <div class="customer">
        <div class="to-customer">Designation du client</div>
        <div class="infos">
            @if($quotation->user->enterprise)
                {{ $quotation->user->enterprise }}<br />
                Siret: {{ $quotation->user->siret }}<br />
            @endif
            {{ $quotation->user->firstName }} {{ $quotation->user->lastName }}<br />
            @foreach($quotation->user->addresses as $address)
                @if($address->type=='invoice')
                    {{ $address->address }}<br />
                    @if($address->complement)
                    {{ $address->complement }}<br />
                    @endif
                    {{ $address->zipCode }} {{ $address->town }}
                @endif
            @endforeach
        </div>
    </div>
    <div class="clear"></div>
    <p class="indication">Sauf indication, les montants sont indiqués TTC</p>
    @include('customer.quotation.order.view')
    @if($quotation->isOrdered)
        <p class="isOrdered">(signé numériquement le {{ \Carbon\Carbon::parse($quotation->orderDate)->formatLocalized('%d-%m-%Y') }}
            par le Mobile n°0{{ substr($quotation->phoneUsedForOrder,0,1) }}.{{ substr($quotation->phoneUsedForOrder,1,2) }}.{{ substr($quotation->phoneUsedForOrder,3,2) }}.{{ substr($quotation->phoneUsedForOrder,5,2) }}.{{ substr($quotation->phoneUsedForOrder,7,2) }})
        </p>
    @endif
    <p class="sign">Date et Signature du client:</p>
@endsection