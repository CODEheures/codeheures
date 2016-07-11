<div class="pdfHeader">
    <div class="logo">
        <a href="{{ route('home') }}" class="navbar-logo ">
            <img src="{{ asset('css/images/codeheures.svg') }}"/>
        </a>
    </div>

    @if(isset($quotation))
    <p class="navbar-menu">
        <a href="{{ route('customer.quotation.order', ['id' => $quotation->id]) }}">Devis n°{{ $quotation->getPublicNumber() }}<br/><span class="created_at">Fait le {{ $quotation->created_at->formatLocalized('%A %e %B %Y') }}</span></a>
    </p>
    @elseif(isset($prestations))
    <p class="navbar-menu">
        <a href="{{ route('cgv') }}">Prestations Standards<br/><span class="created_at">Edition du {{ \Carbon\Carbon::now()->formatLocalized('%A %e %B %Y') }}</span></a>
    </p>
    @endif
</div>