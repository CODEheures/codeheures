<div class="purchase-title">
    <h2><i class="ion-ios-information-outline"></i>Facture de solde n° {{ sprintf('%0'.env('NB_CHIFFRES_VISIBLES_NUM_FACTURE').'d', $invoice->number) }}<br />
        Achat Ref:{{ $entity->hash_key }}:</h2>
    <div class="price-quotation">
        <div class="btn-fake total-price-quotation-info">
            Coût total: {{ $payment->getTransactions()[0]->getAmount()->getTotal()  }}€ TTC
        </div>
    </div>
</div>
<div class="purchase">
    <p>Achat du {!! \Carbon\Carbon::parse($payment->getUpdateTime())->formatLocalized('%A %e %B %Y') !!}</p>
    @include('pdf.purchase.invoice.table.view')
</div>

<div class="purchase-title">
    <h2><i class="ion-ios-locked-outline"></i>Facture acquitée par paypal le {!! \Carbon\Carbon::parse($payment->getUpdateTime())->formatLocalized('%A %e %B %Y') !!}</h2>
</div>