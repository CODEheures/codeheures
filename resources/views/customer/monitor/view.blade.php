<div class="purchase-title">
    <h2><i class="ion-ios-speedometer-outline"></i>Ma consommation</h2>
    <div class="right">
        <a href="{{ route('customer.sale.choice') }}" class="btn-yellow2"
           @if(auth()->user()->email == env('DEMO_USER_MAIL')) data-intro="Votre crédit est rechargeable en cliquant ici. Pour cela votre compte doit être validé par CODEheures" data-step="5" data-position="top" @endif
        >Recharger mon compte</a>
        <div class="btn-fake reliquat-customer-info"
             @if(auth()->user()->email == env('DEMO_USER_MAIL')) data-intro="Ici votre crédit temps restant avec lequel CODEheures peut intervenir" data-step="4" data-position="top" @endif
        >
            Crédit: {{ $totalLeft }}h
        </div>
    </div>
</div>
<nav class="prestation-get-pdf">
    <p
            @if(auth()->user()->email == env('DEMO_USER_MAIL')) data-intro="Ici la liste des temps de référence des prestations
             standards. Ce sont les temps qui servent de plafond de débit lorsque CODEheures travaille pour vous sur votre site"
            data-step="2" data-position="top" @endif><a href="{{ route('customer.prestation.pdf') }}"><i class="ion-archive"></i>Télécharger la grille des prestations standards</a></p>
</nav>

@if(!$data)
    <div class="purchase">
        <p>Aucun relevé de consommation pour l'instant!</p>
    </div>
@else
    <div class="graph-conso"  @if(auth()->user()->email == env('DEMO_USER_MAIL')) data-intro="Ici le graph de
    l'historique des consommations. Chaque consommation vous donne aussi le temps de référence maxi qui aurait
    dû être débité de votre crédit temps" data-step="3" data-position="top" @endif>
        <figure id="graphConso1"></figure>
    </div>
@endif

@foreach($purchases as $purchase)
    @if($purchase->product->type == 'time')
    <div class="purchase" @if(auth()->user()->email == env('DEMO_USER_MAIL'))data-intro="Chacun de vos achats apparait ici" data-step="6" data-position="top" @endif>
        <p>
            <span class="purchase-date">Achat du {{ $purchase->created_at->formatLocalized('%A %e %B %Y') }}:</span> {{ $purchase->quantity }}x "{{ $purchase->product->description }}"
            <a href="{{ route('purchase.show', ['id' => $purchase->id]) }}" class="purchase-number"
               @if(auth()->user()->email == env('DEMO_USER_MAIL'))data-intro="Ce lien vous donne accès au graphique de consommation de cette commande ainsi qu'à la facture" data-step="9" data-position="top" @endif>(Commande {{ $purchase->hash_key }})</a>
            @if($purchase->quotation_id)<a href="{{ route('customer.quotation.pdf', ['id'=>$purchase->quotation_id]) }}" class="quotation-number">(devis {{ $purchase->quotation->getPublicNumber() }})</a>@endif
        </p>
        <table class="purchase-table" @if(auth()->user()->email == env('DEMO_USER_MAIL')) data-intro="Le tableau synthétise les consommations CODEheures justifiées sur cette achat" data-step="7" data-position="top" @endif>
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
                    <td colspan="4">détails<br /><i class="ion-chevron-up" @if(auth()->user()->email == env('DEMO_USER_MAIL')) data-intro="En cliquant ici le tableau s'ouvre et se ferme" data-step="8" data-position="top" @endif></i></td>
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

<div class="purchase" @if(auth()->user()->email == env('DEMO_USER_MAIL')) data-intro="Vous trouverez ici la liste des achats de plugins, thèmes etc.. validés sur devis" data-step="10" data-position="top" @endif >
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