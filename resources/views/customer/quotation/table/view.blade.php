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
    @if(!isset($isPdf) || !$isPdf)
    <tfoot>
    <tr>
        <td colspan="6">détails<br /><i class="ion-chevron-down"></i></td>
    </tr>
    </tfoot>
    <tbody>
    @endif
    @foreach($quotation->lineQuotes as $lineQuote)
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
<p class="tva-info">TVA non applicable, article 293B du code général des impôts. Ce devis contient {{ count($quotation->lineQuotes) }} lignes.</p>
<div class="quotation-total">
    <div class="quotation-total-title">
        <p class="ht">Total HT</p>
        <p class="tva">Total TVA</p>
        <p class="ttc">Total TTC</p>
    </div>
    <div class="quotation-total-value">
        <p class="ht">{{ number_format($totalPrice,2,'.',' ') }}€</p>
        <p class="tva">{{ number_format($totalTva,2,'.',' ') }}€</p>
        <p class="ttc">{{ number_format($totalPrice+$totalTva,2,'.',' ') }}€</p>
    </div>
</div>