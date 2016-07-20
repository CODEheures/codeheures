@if(count($quotations)>0)
    @foreach($quotations as $quotation)
        <?php $totalPrice = $totalPrices[$quotation->id];
         $totalTva = $totalTvas[$quotation->id] ?>
        <div class="quotation-title">
            <div class="left">
                <h2><i class="ion-ios-information-outline"></i>Devis N°{{ $quotation->getPublicNumber() }}:</h2>
                @if($quotation->canPurchase())
                    <div class="cart-quotation">
                        <a href="{{ route('customer.quotation.order', ['id' => $quotation->id]) }}"
                           title="En cliquant, vous pourrez lire les conditions du présent devis et vous recevrez
                           un sms avec un code de confirmation à utiliser à la prochaine étape pour signer ce devis"
                           class="btn-yellow2" @if(auth()->user()->email == env('DEMO_USER_MAIL') && $quotation==$quotations[0])
                           data-intro="Vous pouvez signer numeriquement ce devis par SMS en recevant un code à confirmer
                           en page suivante. La version de demonstration ici présente ne vous engagera evidement
                           en rien si vous souhaitez tester, les données du devis n'etant pas valides"
                           data-step="3" data-position="bottom" @endif
                        >
                            <i class="ion-edit"></i>Signer ce devis
                        </a>
                    </div>
                @endif
                @if($quotation->canRefuse())
                    <div class="refuse-quotation">
                        <a href="{{ route('customer.quotation.refuse', ['id' => $quotation->id]) }}"
                           title="En cliquant, vous refuserez definitivement à ce devis" class="btn-transparent"
                           @if(auth()->user()->email == env('DEMO_USER_MAIL') && $quotation==$quotations[0])
                           data-intro="Un clic ici et votre devis est définitivement refusé"
                           data-step="4" data-position="bottom"  @endif
                        >
                            <i class="ion-trash-a"></i>Refuser ce devis
                        </a>
                    </div>
                @endif
            </div>
            <div class="price-quotation">
                <div class="btn-fake total-price-quotation-info">
                    Coût total: {{ number_format($totalPrice+$totalTva,2,'.',' ') }}€
                </div>
            </div>
        </div>
        <nav class="quotation-get-pdf">
            <p @if(auth()->user()->email == env('DEMO_USER_MAIL') && $quotation==$quotations[0]) data-intro="Vous pouvez le télécharger ici en PDF pour le consulter"
               data-step="2" data-position="bottom"  @endif
            ><a href="{{ route('customer.quotation.pdf', ['id' => $quotation->id]) }}"><i class="ion-archive"></i>Télécharger ce devis</a></p>
        </nav>
        <div class="quotation" @if(auth()->user()->email == env('DEMO_USER_MAIL') && $quotation==$quotations[0]) data-intro="Voici le détail de votre devis"
             data-step="1" data-position="bottom"  @endif>
            @if($quotation->canPurchase())
            <p>
                <span class="quotation-date"> valable jusqu'au {{ \Carbon\Carbon::parse($quotation->validity)->formatLocalized('%A %e %B %Y') }}:</span>
            </p>
            @elseif($quotation->isOrdered)
            <p>
                <span class="quotation-date"> devis signé le {{ \Carbon\Carbon::parse($quotation->orderDate)->formatLocalized('%A %e %B %Y') }}:</span>
            </p>
            @endif
            @include('customer.quotation.table.view')
        </div>
    @endforeach
@else
<div class="quotation">
    <p>Aucun devis à valider...</p>
</div>
@endif