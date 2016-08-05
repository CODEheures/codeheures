<div class="product-title">
    <h2><i class="ion-ios-information-outline"></i>Informations produit</h2>
    <div class="btn-fake total-price-quotation-info">
        Prix HT: {{ \App\Common\FormatManager::price($product->price) }}€
    </div>
</div>
<div class="product">
    <?php if($product->id != null) {
        $method = 'put';
        $route = route('admin.product.update', ['id' => $product->id]);
        $submitText = 'modifier';
    } else {
        $method = 'post';
        $route = route('admin.product.store');
        $submitText = 'créer';
    }
     ?>
    {!! Form::model($product, ['method'=>$method, 'class' => 'form-horizontal', 'url' => $route]) !!}
        <div class="form-group">
            <span class="input input--fumi">
                {!! Form::select('reservedForUserId', $userList, null, ['class' => 'input__field input__field--fumi'. ($product->canEdit() == false ? ' form-disable':'')]) !!}
                <label for="reservedForUserId" class="input__label input__label--fumi">
                    <i class="fa fa-fw fa-lock icon icon--fumi"></i>
                    <span class="input__label-content input__label-content--fumi">Réservé pour le Client</span>
                </label>
            </span>
        </div>

        <div class="form-group">
            <span class="input input--fumi">
                {!! Form::select('type', $listEnumProductType, null, ['class' => 'input__field input__field--fumi'. ($product->canEdit() == false ? ' form-disable':'')]) !!}
                <label for="type" class="input__label input__label--fumi">
                    <i class="fa fa-fw fa-tag icon icon--fumi"></i>
                    <span class="input__label-content input__label-content--fumi">Type</span>
                </label>
            </span>
        </div>

        <div class="form-group">
           <span class="input input--fumi">
                {!! Form::select('unit', $listUnits, null, ['class' => 'input__field input__field--fumi'. ($product->canEdit() == false ? ' form-disable':'')]) !!}
                <label for="unit" class="input__label input__label--fumi">
                    <i class="fa fa-fw fa-question icon icon--fumi"></i>
                    <span class="input__label-content input__label-content--fumi">Unité</span>
                </label>
            </span>
        </div>

        <div class="form-group">
            <span class="input input--fumi">
                {!! Form::input('number','value', null, ['class' => 'input__field input__field--fumi'. ($product->canEdit() == false ? ' form-disable':''), 'min' => 0]) !!}
                <label for="value" class="input__label input__label--fumi">
                    <i class="fa fa-fw fa-plus icon icon--fumi"></i>
                    <span class="input__label-content input__label-content--fumi">Quantité</span>
                </label>
            </span>
        </div>

        <div class="form-group">
            <span class="input input--fumi">
                {!! Form::textarea('description', null, ['class' => 'input__field input__field--fumi'. ($product->canEdit() == false ? ' form-disable':''), 'placeholder' => '10h de webmastering...']) !!}
                <label for="description" class="input__label input__label--fumi">
                    <i class="fa fa-fw fa-comment-o icon icon--fumi"></i>
                    <span class="input__label-content input__label-content--fumi">Description</span>
                </label>
            </span>
        </div>

        <div class="form-group">
            <span class="input input--fumi">
                {!! Form::input('url', 'url', null, ['class' => 'input__field input__field--fumi'. ($product->canEdit() == false ? ' form-disable':''), 'placeholder' => 'http://...']) !!}
                <label for="url" class="input__label input__label--fumi">
                    <i class="fa fa-fw fa-link icon icon--fumi"></i>
                    <span class="input__label-content input__label-content--fumi">Lien Web</span>
                </label>
            </span>
        </div>

        <div class="form-group">
            <span class="input input--fumi">
                {!! Form::input('number','price', \App\Common\FormatManager::inputPrice($product->price), ['class' => 'input__field input__field--fumi'. ($product->canEdit() == false ? ' form-disable':''), 'min' => 0, 'step' => '0.01']) !!}
                <label for="price" class="input__label input__label--fumi">
                    <i class="fa fa-fw fa-euro icon icon--fumi"></i>
                    <span class="input__label-content input__label-content--fumi">Prix HT</span>
                </label>
            </span>
        </div>

        <div class="form-group">
            <span class="input input--fumi">
                {!! Form::input('number','tva', \App\Common\FormatManager::inputPrice($product->tva), ['class' => 'input__field input__field--fumi'. ($product->canEdit() == false ? ' form-disable':''), 'min' => 0, 'step' => 0.1]) !!}
                <label for="tva" class="input__label input__label--fumi">
                    <i class="fa fa-fw fa-percent icon icon--fumi"></i>
                    <span class="input__label-content input__label-content--fumi">TVA</span>
                </label>
            </span>
        </div>

        <div class="form-submit">
            <div class="submit">
                @if($product->canEdit())
                    <input type="submit" class="btn-yellow2" value="{{ $submitText }}" />
                @else
                    <input type="submit" class="btn-disable" value="{{ $submitText }}" />
                @endif
            </div>
        </div>
    {!! Form::close() !!}

    @if(!$product->canEdit())
        @if($product->lineQuotes->count() > 0)
            <p class="space-top">Ce produit a été proposé dans les dévis suivants:</p>
            <ul>
            @foreach($product->lineQuotes as $lineQuote)
            <li><a href="{{ route('admin.quotation.edit', ['id' => $lineQuote->quotation->id]) }}">Devis n° {{ $lineQuote->quotation->id }}</a></li>
            @endforeach
            </ul>
        @endif
        @if($product->purchases->count() > 0)
            <p class="space-top">Ce produit a été acheté par les clients suivants:</p>
            <ul>
            @foreach($product->purchases as $purchase)
                <li>{{ $purchase->user->name }} {{ $purchase->user->firstname }} ({{ $purchase->user->email }})</li>
            @endforeach
            </ul>
        @endif
    @endif
</div>


<div class="product-title">
    <h2><i class="ion-ios-people-outline"></i>Publication</h2>
</div>
<div class="product">
    <div class="form-submit">
        <div class="submit">
            @if($product->canEdit())
                <a href="{{ route('admin.product.delete', ['id' => $product->id]) }}" class="btn-yellow2">Supprimer</a>
            @else
                <a href="#" class="btn-disable">Supprimer</a>
            @endif
            @if(!$product->isObsolete)
                <a href="{{ route('admin.product.toObsolete', ['id' => $product->id]) }}" class="btn-yellow2">Rendre obsolete</a>
            @else
                <a href="{{ route('admin.product.toNotObsolete', ['id' => $product->id]) }}" class="btn-yellow2">Rendre non-obsolete</a>
            @endif
        </div>
    </div>
</div>