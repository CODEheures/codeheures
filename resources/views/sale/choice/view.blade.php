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
                        <p>Idéal pour une demande ponctuelle sans prévision de consommation ultérieur</p>
                    @elseif($product->value == 5)
                        <p><strong>{{ $product->value }} heures</strong> de crédit CODEheure</p>
                        <p>Idéal pour un site vitrine vivant tel q'une association, un Comité d'entreprise</p>
                    @elseif($product->value == 10)
                        <p><strong>{{ $product->value }} heures</strong> de crédit CODEheure</p>
                        <p>Idéal pour une boutique en ligne, une application, ou pour de la modération sociale</p>
                    @elseif($product->value == 50)
                        <p><strong>{{ $product->value }} heures</strong> de crédit CODEheure</p>
                        <p>Idéal pour les grands comptes qui présentent des besoins en developpement tout au long de l'année</p>
                    @endif
                </div>
                <div class="price-price">
                    {{ round(($product->price + round(($product->price*$product->tva/100),2)),2) }}<span class="money">€</span>
                </div>
                <p class="tva">prix TTC TVA = {{ round(($product->price*$product->tva/100),2) }}€</p>
                <p class="tva">TVA non applicable, article 293B du code général des impôts.</p>
                <label for="product-id{{$product->id}}" class="btn-yellow2-invert">
                    <input type= "radio" name="product-id" id="product-id{{$product->id}}" value="{{$product->id}}" />
                    Choisir cette offre
                </label>
            </div>
        </div>
        @endforeach
    </div>
    <div class="form-submit">
        <div class="submit">
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