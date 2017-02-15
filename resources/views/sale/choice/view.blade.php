<article>
    {!! Form::open(['class' => 'form-horizontal form-prices', 'url' => route('customer.sale.recapitulation')]) !!}
    <div class="prices">
        @foreach($productsList as $product)
        <div class="price">
            <div class="header-price">
                @if($product->value == 1)
                    One Shot
                @elseif($product->value == 5)
                    Regular
                @elseif($product->value == 10)
                    Usual
                @elseif($product->value == 50)
                    Intensive
                @endif
            </div>
            <div class="body-price">
                <div class="description-price">
                    @if($product->value == 1)
                        <p><strong>{{ $product->value }} heure</strong> de crédit CODEheure</p>
                        <p>Idéal pour une demande ponctuelle sans prévision de consommation ultérieure</p>
                    @elseif($product->value == 5)
                        <p><strong>{{ $product->value }} heures</strong> de crédit CODEheure</p>
                        <p>Idéal pour un site vitrine vivant tel qu'une association, un comité d'entreprise</p>
                    @elseif($product->value == 10)
                        <p><strong>{{ $product->value }} heures</strong> de crédit CODEheure</p>
                        <p>Idéal pour une boutique en ligne, une application, ou pour de la modération sociale</p>
                    @elseif($product->value == 50)
                        <p><strong>{{ $product->value }} heures</strong> de crédit CODEheure</p>
                        <p>Idéal pour les grands comptes qui présentent des besoins en développement tout au long de l'année</p>
                    @endif
                </div>
                <div class="price-price">
                    {{ \App\Common\FormatManager::price($product->priceTTC()) }}<span class="money">€</span>
                </div>
                <p class="tva">prix TTC TVA = {{ \App\Common\FormatManager::price($product->tvaPrice()) }}€</p>
                <p class="tva">TVA non applicable, article 293B du code général des impôts.</p>
                @if(auth()->user()->is_admin_valid && auth()->user()->quota >= $totalLeft+$product->value)
                <label for="product-id{{$product->id}}" class="btn-yellow2-invert">
                    <input type= "radio" name="product-id" id="product-id{{$product->id}}" value="{{$product->id}}" />
                    Choisir cette offre
                </label>
                @endif
            </div>
            @if(!auth()->user()->is_admin_valid)
            <div class="disable">
                <p>Votre compte est inéligilble à cette offre pour le moment</p>
            </div>
            @endif
            @if(auth()->user()->is_admin_valid && auth()->user()->quota < $totalLeft+$product->value)
                <div class="disable">
                    <p>Votre plafond de crédit serait dépassé :-)</p>
                </div>
            @endif
        </div>
        @endforeach
    </div>
    <div class="form-submit">
        <div class="submit right">
            <button type="submit" class="btn-yellow2-invert" aria-disabled="true">Verifier ma commande<i class="fa fa-arrow-circle-o-right"></i></button>
        </div>
    </div>
    {!! Form::close() !!}
</article>
<article>
    <p class="space-top">Les offres ci dessus permettent de bénéficier de l'accès aux prestations standards.<br />
    <a href="{{ route('customer.prestation.pdf') }}"><i class="ion-archive"></i>Télécharger la grille des prestations standards</a>
    </p>
</article>