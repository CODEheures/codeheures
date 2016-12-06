<div class="quotation-title">
    <h2>@if($invoice->isDown) Facture d'acompte @elseif($invoice->isIntermediate) Facture intermédiaire ({{ $invoice->intermediateNumber }}) @else Facture de solde @endif n° {{ sprintf('%0'.env('NB_CHIFFRES_VISIBLES_NUM_FACTURE').'d', $invoice->number) }} <br />Selon devis N°{{ $entity->getPublicNumber() }}:</h2>
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
            <p class="ttc">{{ \App\Common\FormatManager::price($entity->totalPrice(true)) }}€</p>
        </div>
    </div>

    @foreach($entity->invoices as $previousInvoice)
        @if($previousInvoice->id != $invoice->id)
            <p class="downPercentPayment">@if($previousInvoice->isDown)Acompte déjà aquitée  @elseif($previousInvoice->isIntermediate) Facture intermédiaire ({{ $previousInvoice->intermediateNumber }}) déjà aquitée @endif :{{ $previousInvoice->percent }}%</p>
            <div class="quotation-total">
                <div class="quotation-total-title">
                    <p class="ht">Acompte HT</p>
                    <p class="tva">Acompte TVA</p>
                    <p class="ttc">Acompte TTC</p>
                </div>
                <div class="quotation-total-value">
                    <p class="ht">{{ \App\Common\FormatManager::price($previousInvoice->amountHT) }} €</p>
                    <p class="tva">{{ \App\Common\FormatManager::price($previousInvoice->amountTTC - $previousInvoice->amountHT) }} €</p>
                    <p class="ttc">{{ \App\Common\FormatManager::price($previousInvoice->amountTTC) }} €</p>
                </div>
            </div>
        @endif
    @endforeach

    <p class="downPercentPayment">@if($invoice->isDown) Acompte {{ $invoice->percent }}% @elseif($invoice->isIntermediate) Facture intermédiaire ({{ $invoice->intermediateNumber }}) {{ $invoice->percent }}%@else Solde @endif à régler </p>
    <div class="quotation-total">
        <div class="quotation-total-title">
            <p class="ht">Total HT</p>
            <p class="tva">Total TVA</p>
            <p class="ttc">Total TTC</p>
        </div>
        <div class="quotation-total-value">
            <p class="ht">{{ \App\Common\FormatManager::price($invoice->amountHT) }} €</p>
            <p class="tva">{{ \App\Common\FormatManager::price($invoice->amountTTC - $invoice->amountHT) }} €</p>
            <p class="ttc">{{ \App\Common\FormatManager::price($invoice->amountTTC) }} €</p>
        </div>
    </div>
    @include('legal.invoice.mentions')
</div>