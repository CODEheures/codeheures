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
            <td>{{ number_format($lineQuote->product->price,2,'.',' ') }}€</td>
            <td>{{ $lineQuote->quantity }}</td>
            <td>
                @if($lineQuote->discount > 0)-{{ $lineQuote->discount }}
                @if($lineQuote->discount_type == 'percent')
                    %
                @else
                    €
                @endif
                @else
                    -
                @endif
            </td>
            <td>{{ $lineQuote->product->tva }}%</td>
            @if($lineQuote->discount > 0 && $lineQuote->discount_type == 'devise')
                <td>{{ number_format(($lineQuote->product->price*$lineQuote->quantity - $lineQuote->discount)+
                        ($lineQuote->product->price*$lineQuote->quantity - $lineQuote->discount)*$lineQuote->product->tva/100,2,'.',' ')}}€</td>
            @elseif($lineQuote->discount > 0 && $lineQuote->discount_type == 'percent')
                <td>{{ number_format(($lineQuote->product->price*$lineQuote->quantity*(1-$lineQuote->discount/100))+
                        ($lineQuote->product->price*$lineQuote->quantity*(1-$lineQuote->discount/100))*$lineQuote->product->tva/100,2,'.',' ')}}€</td>
            @else
                <td>{{ number_format(($lineQuote->product->price*$lineQuote->quantity)+
                         ($lineQuote->product->price*$lineQuote->quantity)*$lineQuote->product->tva/100,2,'.',' ')}}€</td>
            @endif
        </tr>
    @endforeach
    </tbody>
</table>
<p class="tva-info">TVA non applicable, article 293B du code général des impôts. Ce devis contient {{ count($entity->lineQuotes) }} lignes.</p>