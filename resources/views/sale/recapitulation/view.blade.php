<article>
    <div class="check-data">
        <div class="data-user">
            <p>Vos données personnelles</p>
            <ul class="disc">
                @if(auth()->user()->enterprise)
                    <li><span class="data-type">Entreprise:</span>{{ auth()->user()->enterprise }} </li>
                @endif
                @if(auth()->user()->lastName)
                    <li><span class="data-type">Nom:</span>{{ auth()->user()->lastName }} </li>
                @endif
                @if(auth()->user()->firstName)
                    <li><span class="data-type">Prénom:</span>{{ auth()->user()->firstName }} </li>
                @endif
                <li><span class="data-type">Email:</span>{{ auth()->user()->email }} </li>
            </ul>
        </div>
        <div class="data-product">
            <p>Votre achat</p>
            <ul class="disc">
                <li><span class="data-type">Désignation:</span>{{ $product->description }} </li>
                <li><span class="data-type">Prix HT</span>{{ number_format($product->price,2,',',' ') }} €</li>
                <li><span class="data-type">TVA ({{ $product->tva }}%)</span>{{ number_format(round(($product->price*$product->tva),2),2,',',' ') }} €</li>
                <li><span class="data-type">Prix TTC</span>{{ number_format(round(($product->price + round(($product->price*$product->tva),2)),2),2,',',' ') }} €</li>
            </ul>
        </div>
    </div>
</article>
<article>
    <div class="payout">
        <a href="{{ route('customer.sale.payment', ['id' => $product->id]) }}" data-paypal-button="true" title="PayPal, le réflexe sécurité pour payer en ligne">
            <img src="{{ asset('/css/images/frenchPayButton2.png') }}" alt="PayPal, le réflexe sécurité pour payer en ligne" />
        </a>
    </div>
</article>
@if(auth()->user()->email == env('DEMO_USER_MAIL'))
<article>
    <div class="payout">
        <p>
            Vous êtes sur une page de test et vous pouvez continuer le test en payant sur paypal avec le compte de test suivant:
        </p>
        <ul>
            <li>user: demo1@codeheures.fr</li>
            <li>mot de passe: paypaltest+</li>
        </ul>
    </div>
</article>
@endif