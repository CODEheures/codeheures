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
                <li><span class="data-type">Prix HT</span>{{ \App\Common\FormatManager::price($product->price) }} €</li>
                <li><span class="data-type">TVA ({{ $product->tva }}%)</span>{{ \App\Common\FormatManager::price($product->tvaPrice()) }} €</li>
                <li><span class="data-type">Prix TTC</span>{{ \App\Common\FormatManager::price($product->priceTTC()) }} €</li>
            </ul>
        </div>
    </div>
</article>
<article>
    <div class="checkbox">
        <span>Je reconnais avoir pris connaissance des <a href="{{ route('cgv') }}" target="_blank">Conditions générales de vente</a></span>
        <div class="check-style3">
            <input type="checkbox" id="approuve" value="approuve">
            <label for="approuve"></label>
        </div>
    </div>
</article>
<article>
    <div class="payout">
        <a href="{{ route('customer.sale.payment', ['id' => $product->id]) }}" class="disable" data-paypal-button="true" title="PayPal, le réflexe sécurité pour payer en ligne">
            <img src="{{ asset('/css/images/frenchPayButton2_disable.png') }}" alt="PayPal, le réflexe sécurité pour payer en ligne" />
        </a>
    </div>
</article>
@if(auth()->user()->isDemo)
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