<table class="quotation-table">
    <thead>
    <tr>
        <th>Produit</th>
        <th>Prix HT</th>
        <th>Quantité</th>
        <th>Remise</th>
        <th>TVA</th>
        <th>Total TTC ligne</th>
    </tr>
    </thead>
    <tbody>
    @foreach($entity->lineQuotes as $lineQuote)
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
            <td>{{ \App\Common\FormatManager::price($lineQuote->tvaPercent()) }}%</td>
            <td>{{ \App\Common\FormatManager::price($lineQuote->totalPriceTTC()) }}€</td>
        </tr>
    @endforeach
    </tbody>
</table>
<p class="tva-info">TVA non applicable, article 293B du code général des impôts. Ce devis contient {{ count($entity->lineQuotes) }} lignes.</p>