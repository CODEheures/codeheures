<div class="quotation-title">
    <h2>@if($invoice->isDown) Facture d'acompte @else Facture de solde @endif n° {{ sprintf('%0'.env('NB_CHIFFRES_VISIBLES_NUM_FACTURE').'d', $invoice->number) }} <br />Selon devis N°{{ $entity->getPublicNumber() }}:</h2>
</div>
<div class="quotation">
    <p class="order-validity">
        <span class="quotation-date"> Rappel du devis signé le {{ \Carbon\Carbon::parse($entity->orderDate)->formatLocalized('%A %e %B %Y') }}:</span>
    </p>
    @include('pdf.quotation.invoice.table.view')
    <div class="quotation-total">
        <div class="quotation-total-title">
            <p class="ttc">Total TTC</p>
        </div>
        <div class="quotation-total-value">
            <p class="ttc">{{ number_format($totalPrice+$totalTva,2,'.',' ') }}€</p>
        </div>
    </div>
    @if($invoice->isDown || ($invoice->isSold && $haveDown))
        <p class="downPercentPayment">Acompte @if($invoice->isDown)demandé @else déjà versé @endif {{ $entity->downPercentPayment }}%</p>
        <div class="quotation-total">
            <div class="quotation-total-title">
                <p class="ht">Acompte HT</p>
                <p class="tva">Acompte TVA</p>
                <p class="ttc">Acompte TTC</p>
            </div>
            <div class="quotation-total-value">
                <p class="ht">{{ number_format($totalPrice*$entity->downPercentPayment/100,2,'.',' ') }} €</p>
                <p class="tva">{{ number_format($totalTva*$entity->downPercentPayment/100,2,'.',' ') }} €</p>
                <p class="ttc">{{ number_format($totalPrice*$entity->downPercentPayment/100+$totalTva*$entity->downPercentPayment/100,2,'.',' ') }} €</p>
            </div>
        </div>
    @endif
    @if($invoice->isSold)
        <p class="downPercentPayment">Solde à régler </p>
        <div class="quotation-total">
            <div class="quotation-total-title">
                <p class="ht">Total HT</p>
                <p class="tva">Total TVA</p>
                <p class="ttc">Total TTC</p>
            </div>

            <div class="quotation-total-value">
                <p class="ht">@if($haveDown) {{ number_format($totalPrice - $totalPrice*$entity->downPercentPayment/100,2,'.',' ') }} @else {{ number_format($totalPrice,2,'.',' ') }} @endif €</p>
                <p class="tva">@if($haveDown) {{ number_format($totalTva - $totalTva*$entity->downPercentPayment/100,2,'.',' ') }} @else {{ number_format($totalTva,2,'.',' ') }} @endif €</p>
                <p class="ttc">@if($haveDown) {{ number_format($totalPrice - $totalPrice*$entity->downPercentPayment/100+ $totalTva - $totalTva*$entity->downPercentPayment/100,2,'.',' ') }} @else {{ number_format($totalPrice+$totalTva,2,'.',' ') }} @endif €</p>
            </div>
        </div>
    @endif
    @include('legal.invoice.mentions')
</div>