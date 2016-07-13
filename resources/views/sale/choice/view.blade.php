<article>
    {!! Form::open(['class' => 'form-horizontal form-prices', 'url' => route('customer.sale.recapitulation')]) !!}
    <div class="prices">
        <div class="price">
            <div class="header-price">
                One Shot
            </div>
            <div class="body-price">
                <div class="description-price">
                    <p><strong>1 heure</strong> de crédit CODEheure</p>
                    <p>Idéal pour une demande ponctuelle sans prévision de consommation ultérieur</p>
                </div>
                <div class="price-price">59<span class="money">€</span></div>
                <label for="product-choice1" class="btn-yellow2-invert">
                    <input type= "radio" name="product-choice" id="product-choice1" value="1" />
                    Choisir cette offre
                </label>
            </div>
        </div>
        <div class="price">
            <div class="header-price">
                Regular
            </div>
            <div class="body-price">
                <div class="description-price">
                    <p><strong>5 heures</strong> de crédit CODEheure</p>
                    <p>Idéal pour un site vitrine vivant tel q'une association, un CE</p>
                </div>
                <div class="price-price">269<span class="money">€</span></div>
                <label for="product-choice5" class="btn-yellow2-invert">
                    <input type= "radio" name="product-choice" id="product-choice5" value="5" />
                    Choisir cette offre
                </label>
            </div>
        </div>
        <div class="price">
            <div class="header-price">
                Usual
            </div>
            <div class="body-price">
                <div class="description-price">
                    <p><strong>10 heures</strong> de crédit CODEheure</p>
                    <p>Idéal pour un site e-commerce, une application, ou pour de la modération sociale</p>
                </div>
                <div class="price-price">499<span class="money">€</span></div>
                <label for="product-choice10" class="btn-yellow2-invert">
                    <input type= "radio" name="product-choice" id="product-choice10" value="10" />
                    Choisir cette offre
                </label>
            </div>
        </div>
        <div class="price">
            <div class="header-price">
                Intensive
            </div>
            <div class="body-price">
                <div class="description-price">
                    <p><strong>50 heures</strong> de crédit CODEheure</p>
                    <p>Idéal pour un site e-commerce, une application, ou pour de la modération sociale</p>
                </div>
                <div class="price-price">2399<span class="money">€</span></div>
                <label for="product-choice50" class="btn-yellow2-invert">
                    <input type= "radio" name="product-choice" id="product-choice50" value="50" />
                    Choisir cette offre
                </label>
            </div>
        </div>
    </div>
    <div class="form-submit">
        <div class="submit">
            <button type="submit" class="btn-yellow2-invert" aria-disabled="true">Verifier ma commande<i class="fa fa-arrow-circle-o-right"></i></button>
        </div>
    </div>
    {!! Form::close() !!}
    <p class="space-top"></p>
</article>