<table class="purchase-table">
    <thead>
    <tr>
        <th>Produit</th>
        <th>Prix TTC</th>
        <th>Quantité</th>
        <th>Total TVA</th>
        <th>Total TTC ligne</th>
    </tr>
    </thead>
    <tbody>
    {!! $totalTVA = 0 !!}
    @foreach($payment->getTransactions()[0]->getItemList()->getItems() as $item)
        {!! $totalTVA = $totalTVA + $item->getTax()*$item->getQuantity() !!}
        <tr>
            <td>{{ $item->getName() }}</td>
            <td>{{ $item->getPrice() }}€</td>
            <td>{{ $item->getQuantity() }}</td>
            <td>{{ number_format($item->getTax()*$item->getQuantity(),2,'.',' ') }}€</td>
            <td>{{ number_format($item->getPrice()*$item->getQuantity(),2,'.',' ') }}€</td>
        </tr>
    @endforeach
    </tbody>
</table>
<p class="tva-info">TVA non applicable, article 293B du code général des impôts. Cette facture contient {{ count($payment->getTransactions()[0]->getItemList()->getItems()) }} lignes.</p>
<div class="purchase-total">
    <div class="purchase-total-title">
        <p class="ht">Total HT</p>
        <p class="tva">Total TVA</p>
        <p class="ttc">Total TTC</p>
    </div>
    <div class="quotation-total-value">
        <p class="ht">{{ number_format($payment->getTransactions()[0]->getAmount()->getTotal()-$totalTVA,2,'.',' ') }}€</p>
        <p class="tva">{{ number_format($totalTVA,2,'.',' ') }}€</p>
        <p class="ttc">{{ number_format($payment->getTransactions()[0]->getAmount()->getTotal(),2,'.',' ') }}€</p>
    </div>
</div>