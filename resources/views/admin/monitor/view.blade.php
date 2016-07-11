<div class="purchase-title">
    <h2><i class="ion-ios-speedometer-outline"></i>Suivi d'activité globale</h2>
</div>

@if(!$data)
    <div class="purchase">
        <p>Aucune relevé de consommation pour l'instant!</p>
    </div>
@else
    <div class="graph-conso">
        <figure id="graphConso1"></figure>
    </div>
@endif

<div class="purchase-title">
    <h2><i class="ion-ios-list-outline"></i>Commandes clients</h2>
</div>

<div class="purchase">
@if(count($purchases)>0)
    <table>
        <tbody>
@foreach($purchases as $purchase)
    <?php $reste = (int) $purchase->product->value*$purchase->quantity; ?>
    @foreach($purchase->consommations as $consommation)
        <?php $reste =  round($reste - round($consommation->value,2),2); ?>
    @endforeach
    <tr>
        <td class="admin">
            <i class="ion-minus-round"></i><a href="{{ route('purchase.show', ['id' => $purchase->id]) }}" class="purchase-number">N°{{ $purchase->hash_key }}</a><span class="purchase-date"> du {{ $purchase->created_at->formatLocalized('%d-%m-%Y') }}:</span> "{{ $purchase->product->description }}" par {{ $purchase->user->name }} ({{ $purchase->user->email }})
            <span class="reliquat {!! $reste > 0 ? 'positive':null !!}">Reliquat: {{ $reste }}</span>
        </td>
    </tr>
@endforeach
        </tbody>
    </table>
@else
    <p>Aucune commande client...</p>
@endif
</div>