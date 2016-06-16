<div class="product-title">
    <h2><i class="ion-ios-information-outline"></i>Informations produit</h2>
    <div class="total-price-quotation-info">
        Prix HT: {{ $product->price }}€
    </div>
</div>
<div class="product">
    {!! Form::model($product, ['method'=>'put', 'class' => 'form-horizontal', 'url' => route('admin.product.update', ['id' => $product->id])]) !!}
        <div class="form-group">
            {!! Form::label('reservedForUserId', 'Réservé pour le Client') !!}
            {!! Form::select('reservedForUserId', $userList, null, ['class' => 'form-control'. ($product->canEdit() == false ? ' form-disable':'')]) !!}
        </div>

        <div class="form-group">
            {!! Form::label('type', 'Type') !!}
            {!! Form::select('type', $listEnumProductType, null, ['class' => 'form-control'. ($product->canEdit() == false ? ' form-disable':'')]) !!}
        </div>

        <div class="form-group">
            {!! Form::label('unit', 'Type') !!}
            {!! Form::select('unit', $listUnits, null, ['class' => 'form-control'. ($product->canEdit() == false ? ' form-disable':'')]) !!}
        </div>

        <div class="form-group">
            {!! Form::label('value', 'Valeur') !!}
            {!! Form::input('number','value', null, ['class' => 'form-control'. ($product->canEdit() == false ? ' form-disable':''), 'min' => 0]) !!}
        </div>

        <div class="form-group">
            {!! Form::label('description', 'Description') !!}
            {!! Form::textarea('description', null, ['class' => 'form-control'. ($product->canEdit() == false ? ' form-disable':''), 'placeholder' => '10h de webmastering...']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('price', 'Prix HT') !!}
            {!! Form::input('number','price', null, ['class' => 'form-control'. ($product->canEdit() == false ? ' form-disable':''), 'min' => 0]) !!}
        </div>

        <div class="form-group">
            {!! Form::label('tva', 'TVA') !!}
            {!! Form::input('number','tva', null, ['class' => 'form-control'. ($product->canEdit() == false ? ' form-disable':''), 'min' => 0, 'step' => 0.1]) !!}
        </div>

        <div class="form-group">
            <div class="submit">
                @if($product->canEdit())
                    <input type="submit" class="btn btn-yellow2" value="Modifier" />
                @else
                    <input type="submit" class="btn btn-disable" value="Modifier" />
                @endif
            </div>
        </div>
    {!! Form::close() !!}

    @if(!$product->canEdit())
        <p>Ce produit a été proposé dans les dévis suivants:</p>
        <ul>
        @foreach($product->lineQuote as $lineQuote)
        <li><a href="{{ route('admin.quotation.edit', ['id' => $lineQuote->quotation->id]) }}">Devis n° {{ $lineQuote->quotation->id }}</a></li>
        @endforeach
    @endif
    </ul>
</div>

<div class="clear"></div>

<div class="product-title">
    <h2><i class="ion-ios-people-outline"></i>Publication</h2>
</div>
<div class="product">
    @if($product->canEdit())
        <a href="{{ route('admin.product.delete', ['id' => $product->id]) }}" class="btn btn-yellow2">Supprimer</a>
    @else
        <a href="#" class="btn btn-disable">Supprimer</a>
    @endif
    @if(!$product->isObsolete)
        <a href="{{ route('admin.product.toObsolete', ['id' => $product->id]) }}" class="btn btn-yellow2">Rendre obsolete</a>
    @else
        <a href="{{ route('admin.product.toNotObsolete', ['id' => $product->id]) }}" class="btn btn-yellow2">Rendre non-obsolete</a>
    @endif
</div>