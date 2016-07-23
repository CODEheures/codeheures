@extends('layouts.pdf')

@section('user.action')
    @if($entity->user->email == env('DEMO_USER_MAIL'))
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
            @if($entity->user->enterprise)
                {{ $entity->user->enterprise }}<br />
                Siret: {{ $entity->user->siret }}<br />
            @endif
            {{ $entity->user->firstName }} {{ $entity->user->lastName }}<br />
            @foreach($entity->user->addresses as $address)
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
    @include('pdf.quotation.invoice.view')
@endsection