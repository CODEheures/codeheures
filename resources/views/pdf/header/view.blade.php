<div class="pdfHeader">
    <div class="logo">
        <a href="{{ route('home') }}" class="navbar-logo ">
            <img src="{{ asset('css/images/codeheures.svg') }}"/>
        </a>
    </div>

    @if(isset($quotation))
    <p class="navbar-menu">
        Devis n°{{ $quotation->getPublicNumber() }}<br/>
            <span class="created_at">Fait le {{ $quotation->created_at->formatLocalized('%A %e %B %Y') }}</span>
    </p>
    @elseif(isset($invoice) && $invoice->origin == 'quotation')
        <p class="navbar-menu">
            <a href="{{ route('customer.quotation.order', ['id' => $invoice->quotation_id]) }}">@if($invoice->isDown) Facture d'acompte @else Facture de solde @endif n°{{ $invoice->number }} selon Devis n°{{ $invoice->quotation->getPublicNumber() }}<br/>
                <span class="created_at">Emise le {{ \Carbon\Carbon::now()->formatLocalized('%A %e %B %Y') }}</span></a>
        </p>
    @elseif(isset($invoice) && $invoice->origin == 'purchase')
        <p class="navbar-menu">
            <a href="{{ route('purchase.show', ['id' => $invoice->purchase_id]) }}">Facture de solde n°{{ $invoice->number }} pour Achat REF {{ $invoice->purchase->hash_key }}<br/>
                <span class="created_at">Emise le {{ \Carbon\Carbon::now()->formatLocalized('%A %e %B %Y') }}</span></a>
        </p>
    @elseif(isset($prestations))
    <p class="navbar-menu">
        <a href="{{ route('cgv') }}">Prestations Standards<br/><span class="created_at">Edition du {{ \Carbon\Carbon::now()->formatLocalized('%A %e %B %Y') }}</span></a>
    </p>
    @endif
</div>