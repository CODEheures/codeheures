<div class="purchase-title">
    <h2><i class="ion-ios-speedometer-outline"></i>Ma consommation</h2>
    <div class="right">
        <a href="{{ route('customer.sale.choice') }}" class="btn-yellow2">Recharger mon compte</a>
        <div class="btn-fake reliquat-customer-info">
            Crédit: {{ $totalLeft }}h
        </div>
    </div>
</div>
<nav class="prestation-get-pdf">
    <p><a href="{{ route('customer.prestation.pdf') }}"><i class="ion-archive"></i>Télécharger la grille des prestations standards</a></p>
</nav>

@if(!$data)
    <div class="purchase">
        <p>Aucun relevé de consommation pour l'instant!</p>
    </div>
@else
    <div class="graph-conso">
        <figure id="graphConso1"></figure>
    </div>
@endif

@foreach($purchases as $purchase)
    @if($purchase->product->type == 'time')
    <div class="purchase">
        <p>
            <span class="purchase-date">Achat du {{ $purchase->created_at->formatLocalized('%A %e %B %Y') }}:</span> {{ $purchase->quantity }}x "{{ $purchase->product->description }}"
            <a href="{{ route('purchase.show', ['id' => $purchase->id]) }}" class="purchase-number">(Commande {{ $purchase->hash_key }})</a>
            @if($purchase->quotation_id)<a href="{{ route('customer.quotation.pdf', ['id'=>$purchase->quotation_id]) }}" class="quotation-number">(devis {{ $purchase->quotation->getPublicNumber() }})</a>@endif
        </p>
        <table class="purchase-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Justification</th>
                    <th>Consommation</th>
                    <th>Reliquat forfait</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <td colspan="4">détails<br /><i class="ion-chevron-up"></i></td>
                </tr>
            </tfoot>
            <tbody>

            <?php $reste = (int) $purchase->product->value*$purchase->quantity; ?>
            @foreach($purchase->consommations as $consommation)
                <?php $reste =  round($reste - round($consommation->value,2),2); ?>
                <tr>
                    <td>{{ $consommation->created_at->formatLocalized('%d-%m-%Y') }}</td>
                    <td width="50%">{{ $consommation->comment }}</td>
                    <td>{{ $consommation->value }}</td>
                    <td>{{ $reste }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @endif
@endforeach

<div class="purchase-title">
    <h2><i class="ion-ios-settings"></i>Mes achats de Plugins et Thèmes</h2>
</div>

<?php $purchaseNotTimeExist = false ?>
@foreach($purchases as $purchase)
    @if($purchase->product->type != 'time')
        <?php $purchaseNotTimeExist = true ?>
    @endif
@endforeach

<div class="purchase">
@if($purchaseNotTimeExist)

        <table>
            <tbody>
    @foreach($purchases as $purchase)
            @if($purchase->product->type != 'time')
                <tr>
                    <td class="presta-perso">
                        <i class="ion-minus-round"></i>
                        <span class="purchase-date">Achat du {{ $purchase->created_at->formatLocalized('%A %e %B %Y') }}:</span> "{{ $purchase->product->description }}"
                        <a href="{{ route('purchase.show', ['id' => $purchase->id]) }}" class="purchase-number">(Commande {{ $purchase->hash_key }})</a>
                        @if($purchase->quotation_id)<a href="{{ route('customer.quotation.pdf', ['id'=>$purchase->quotation_id]) }}" class="quotation-number">(devis {{ $purchase->quotation->getPublicNumber() }})</a>@endif
                    </td>
                </tr>
            @endif
    @endforeach
            </tbody>
        </table>

@else
    <p>Aucune prestation personnalisée dans vos commandes</p>
@endif
</div>