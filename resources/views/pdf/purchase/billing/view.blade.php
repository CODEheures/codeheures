<div class="purchase-title">
    <h2><i class="ion-ios-information-outline"></i>Facture Ref:{{ $purchase->hash_key }}:</h2>
    <div class="price-quotation">
        <div class="btn-fake total-price-quotation-info">
            Coût total: {{ $payment->getTransactions()[0]->getAmount()->getTotal()  }}€ TTC
        </div>
    </div>
</div>
<div class="purchase">
    @include('pdf.purchase.billing.table.view')
</div>

<div class="purchase-title">
    <h2><i class="ion-ios-locked-outline"></i>Facture réglée le {!! \Carbon\Carbon::parse($payment->getUpdateTime())->formatLocalized('%A %e %B %Y') !!}</h2>
</div>