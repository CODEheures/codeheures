<table class="quotation-table">
    <thead>
    <tr>
        <th>Produit</th>
        <th style="min-width: 11rem; width: 110px;" class="pdfprice">Prix HT</th>
        <th>Quantité</th>
        <th>Remise</th>
        <th style="min-width: 11rem; width: 110px;" class="pdfprice">Total Ht</th>
        <th>TVA</th>
        <th style="min-width: 11rem; width: 110px;" class="pdfprice">Total TTC ligne</th>
    </tr>
    </thead>
    @if(!isset($isPdf) || !$isPdf)
    <tfoot>
    <tr>
        <td colspan="7">détails<br /><i class="ion-chevron-up"></i></td>
    </tr>
    </tfoot>
    @endif
    <tbody>
    @foreach($quotation->lineQuotes as $lineQuote)
        <tr>
            <td>{{ $lineQuote->product->description }}</td>
            <td>{{ \App\Common\FormatManager::price($lineQuote->product->price) }}€</td>
            <td>{{ $lineQuote->quantity }}</td>
            <td>
                @if($lineQuote->discount > 0)-{{ \App\Common\FormatManager::price($lineQuote->discount) }}
                    @if($lineQuote->discount_type == 'percent')
                        %
                    @else
                        €
                    @endif
                @else
                    -
                @endif
            </td>
            <td>{{ \App\Common\FormatManager::price($lineQuote->totalPriceHt()) }}€</td>
            <td>{{ \App\Common\FormatManager::price($lineQuote->tvaPercent()) }}%</td>
            <td>{{ \App\Common\FormatManager::price($lineQuote->totalPriceTTC()) }}€</td>
        </tr>
    @endforeach
    </tbody>
</table>
<p class="tva-info">TVA non applicable, article 293B du code général des impôts. Ce devis contient {{ count($quotation->lineQuotes) }} lignes.</p>
<div class="quotation-total">
    <div class="quotation-total-title">
        <p class="ht">Total HT</p>
        <p class="tva">Total TVA</p>
        <p class="ttc">Total TTC</p>
    </div>
    <div class="quotation-total-value">
        <p class="ht">{{ \App\Common\FormatManager::price($quotation->totalPrice()) }}€</p>
        <p class="tva">{{ \App\Common\FormatManager::price($quotation->totalPrice(true)-$quotation->totalPrice()) }}€</p>
        <p class="ttc">{{ \App\Common\FormatManager::price($quotation->totalPrice(true)) }}€</p>
    </div>
</div>