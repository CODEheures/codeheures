<div class="quotation-title">
    <h2><i class="ion-ios-information-outline"></i>Informations devis</h2>
    <div class="btn-fake total-price-quotation-info">
        Coût total: {{ \App\Common\FormatManager::price($quotation->totalPrice()) }}€
    </div>
</div>
@include('admin.quotation.progressbar.view')
<div class="quotation">
    {!! Form::model($quotation, ['method'=> 'PUT', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data', 'url' => route('admin.quotation.update', ['id' => $quotation->id])]) !!}
        <div class="form-group">
            <span class="input input--fumi">
                {!! Form::select('user_id', $userList, null, ['class' => 'input__field input__field--fumi'. ($quotation->canEdit() == false ? ' form-disable':'')]) !!}
                <label for="user_id" class="input__label input__label--fumi">
                    <i class="fa fa-fw fa-user icon icon--fumi"></i>
                    <span class="input__label-content input__label-content--fumi">Client</span>
                </label>
            </span>
        </div>

        <div class="form-group">
            <span class="input input--fumi">
                {!! Form::input('date', 'validity', null, ['class' => 'input__field input__field--fumi'. ($quotation->canEdit() == false ? ' form-disable':''), 'placeholder' => '10-11-2015']) !!}
                <label for="validity" class="input__label input__label--fumi">
                    <i class="fa fa-fw fa-calendar icon icon--fumi"></i>
                    <span class="input__label-content input__label-content--fumi">Date de validité</span>
                </label>
            </span>
        </div>

        <div class="form-group">
            <span class="input input--fumi">
                {!! Form::input('number', 'downPercentPayment', null, ['class' => 'input__field input__field--fumi'. ($quotation->canEdit() == false ? ' form-disable':''), 'placeholder' => '20']) !!}
                <label for="downPercentPayment" class="input__label input__label--fumi">
                    <i class="fa fa-fw fa-percent icon icon--fumi"></i>
                    <span class="input__label-content input__label-content--fumi">Acompte demandé en %</span>
                </label>
            </span>
        </div>

        <div class="form-group" style="position: relative">
            <span class="input input--fumi">
                {!! Form::input('file', 'upload', null, ['accept' => 'application/pdf', 'class' => 'input__field input__field--fumi'. ($quotation->canEdit() == false ? ' form-disable':'')]) !!}
                <label for="file" class="input__label input__label--fumi">
                    <i class="fa fa-fw fa-gift icon icon--fumi"></i>
                    <span class="input__label-content input__label-content--fumi">Un fichier</span>
                </label>
            </span>
            @if($quotation->file)
                <a href="{{ route('customer.quotation.attachment', ['hashName' => $quotation->file]) }}" style="position: absolute; bottom:-1.8rem; right: 3.8rem;" target="_blank">fichier uploadé</a>
            @endif
        </div>

        <div class="form-submit">
            <div class="submit">
                @if(!$quotation->canEdit())
                    <input type="submit" class="btn-disable" value="Modifier" />
                @else
                    <input type="submit" class="btn-yellow2" value="Modifier" />
                @endif
            </div>
        </div>
    {!! Form::close() !!}
</div>

<div class="clear"></div>

<div class="quotation">
    <table class="quotation-table">
        <thead>
        <tr>
            <th>produit</th>
            <th>prix</th>
            <th>Quantité</th>
            <th>remise</th>
            <th>Prix total</th>
            <th>Action</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <td colspan="6">détails<br /><i class="ion-chevron-up"></i></td>
        </tr>
        </tfoot>
        <tbody>

        @foreach($quotation->lineQuotes as $lineQuote)
            @if($lineQuote->id == $lineQuoteId)
                {!! Form::model($lineQuote, ['method' => 'PUT', 'class' => 'form-horizontal', 'url' => route('admin.lineQuote.update', ['id' => $lineQuote->id])]) !!}
                {!! Form::hidden('quotation_id', $quotation->id) !!}
                {!! Form::hidden('product_id', $lineQuote->product->id) !!}
                <tr>
                    <td>{{ $lineQuote->product->description }}</td>
                    <td>{{ \App\Common\FormatManager::price($lineQuote->product->price) }}</td>
                    <td>{!! Form::input('number', 'quantity', null, ['class' => 'form-control'. ($quotation->canEdit() == false ? ' form-disable':''), 'placeholder' => '3']) !!}</td>
                    <td>
                        {!! Form::input('number', 'discount', \App\Common\FormatManager::inputPrice($lineQuote->discount), ['class' => 'form-control'. ($quotation->canEdit() == false ? ' form-disable':''), 'placeholder' => '20', 'step' => 0.01]) !!}
                        {!! Form::select('discount_type', $listEnumDiscountType , null, ['class' => 'form-control'. ($quotation->canEdit() == false ? ' form-disable':'')]) !!}
                    </td>
                    <td>{{ \App\Common\FormatManager::price($lineQuote->totalPriceHt()) }}</td>
                    <td>
                        @if(!$quotation->canEdit())
                            <input type="submit" class="btn-disable" value="Modifier" />
                        @else
                            <input type="submit" class="btn-yellow2" value="Modifier" />
                        @endif
                    </td>
                </tr>
                {!! Form::close() !!}
            @else
            <tr>
                <td>{{ $lineQuote->product->description }}</td>
                <td>{{ \App\Common\FormatManager::price($lineQuote->product->price) }}</td>
                <td>{{ $lineQuote->quantity }}</td>
                <td>
                    @if($lineQuote->discount > 0)-{{ \App\Common\FormatManager::price($lineQuote->discount) }}
                        @if($lineQuote->discount_type == 'percent')
                            %
                        @else
                            €
                        @endif
                    @else
                        -
                    @endif
                </td>
                <td>{{ \App\Common\FormatManager::price($lineQuote->totalPriceHt()) }}</td>
                <td>
                    @if(!$quotation->canEdit())
                    @else
                    <a href="{{ route('admin.lineQuote.delete', ['id'=> $lineQuote->id]) }}" class="btn-danger">
                        <i class="ion-ios-close-outline"></i> Supprimer
                    </a>
                    <br />
                    <a href="{{ route('admin.lineQuote.edit', ['id'=> $lineQuote->id]) }}" class="btn-danger">
                        <i class="ion-edit"></i> Modifier
                    </a>
                    @endif
                </td>
            </tr>
            @endif
        @endforeach
        </tbody>
    </table>
</div>

<div class="quotation-title">
    <h2><i class="ion-plus-round"></i>Ajouter une ligne au devis</h2>
</div>
<div class="quotation">

    {!! Form::model($newLineQuote, ['class' => 'form-horizontal', 'url' => route('admin.lineQuote.store')]) !!}

    {!! Form::hidden('quotation_id', $quotation->id) !!}

    <div class="form-group">
        <span class="input input--fumi">
            {!! Form::select('product_id', $productList, null, ['class' => 'input__field input__field--fumi'. ($quotation->canEdit() == false ? ' form-disable':'')]) !!}
            <label for="product_id" class="input__label input__label--fumi">
                <i class="fa fa-fw fa-tag icon icon--fumi"></i>
                <span class="input__label-content input__label-content--fumi">Produit</span>
            </label>
        </span>
    </div>

    <div class="form-group">
        <span class="input input--fumi">
            {!! Form::input('number', 'quantity', null, ['class' => 'input__field input__field--fumi'. ($quotation->canEdit() == false ? ' form-disable':''), 'placeholder' => '3']) !!}
            <label for="quantity" class="input__label input__label--fumi">
                <i class="fa fa-fw fa-asterisk icon icon--fumi"></i>
                <span class="input__label-content input__label-content--fumi">Quantité</span>
            </label>
        </span>
    </div>

    <div class="form-group">
        <span class="input input--fumi">
            {!! Form::input('number', 'discount', null, ['class' => 'input__field input__field--fumi'. ($quotation->canEdit() == false ? ' form-disable':''), 'placeholder' => '20']) !!}
            <label for="discount" class="input__label input__label--fumi">
                <i class="fa fa-fw fa-gift icon icon--fumi"></i>
                <span class="input__label-content input__label-content--fumi">Réduction</span>
            </label>
        </span>
    </div>

    <div class="form-group">
        <span class="input input--fumi">
            {!! Form::select('discount_type', $listEnumDiscountType , null, ['class' => 'input__field input__field--fumi'. ($quotation->canEdit() == false ? ' form-disable':'')]) !!}
            <label for="discount_type" class="input__label input__label--fumi">
                <i class="fa fa-fw fa-list icon icon--fumi"></i>
                <span class="input__label-content input__label-content--fumi">Type de réduction</span>
            </label>
        </span>
    </div>

    <div class="form-submit">
        <div class="submit">
            @if(!$quotation->canEdit())
                <input type="submit" class="btn-disable" value="Ajouter" />
            @else
                <input type="submit" class="btn-yellow2" value="Ajouter" />
            @endif
        </div>
    </div>

    {!! Form::close() !!}
</div>

<div class="quotation-title">
    <h2><i class="ion-ios-people-outline"></i>Publication</h2>
</div>
<div class="quotation">
    <div class="form-submit">
        <div class="submit">
            @if($quotation->canPublish())
                <a href="{{ route('admin.quotation.publish', ['id' => $quotation->id]) }}" class="btn-yellow2">Publier</a>
            @else
                <a href="#" class="btn-disable">Publier</a>
            @endif
            @if($quotation->canUnpublish())
                <a href="{{ route('admin.quotation.unPublish', ['id' => $quotation->id]) }}" class="btn-yellow2">Dépublier</a>
            @else
                <a href="#" class="btn-disable">Dépublier</a>
            @endif
            @if($quotation->canDelete())
                <a href="{{ route('admin.quotation.delete', ['id' => $quotation->id]) }}" class="btn-yellow2">Supprimer</a>
            @else
                <a href="#" class="btn-disable">Supprimer</a>
            @endif
            @if($quotation->canArchive())
                <a href="{{ route('admin.quotation.archive', ['id' => $quotation->id]) }}" class="btn-yellow2">Archiver</a>
            @else
                <a href="#" class="btn-disable">Archiver</a>
            @endif
            @if($quotation->canCancel())
                <a href="{{ route('admin.quotation.cancel', ['id' => $quotation->id]) }}" class="btn-yellow2">Annuler</a>
            @else
                <a href="#" class="btn-disable">Annuler</a>
            @endif
        </div>
    </div>
</div>

<div class="quotation-title">
    <h2><i class="ion-ios-calculator-outline"></i>Facturation</h2>
</div>
<div class="quotation">
@if($quotation->isOrdered)
    <table class="quotation-table">
        <thead>
        <tr>
            <th>Payment Id</th>
            <th>Type</th>
            <th>Poucentage</th>
            <th>HT</th>
            <th>TTC</th>
            <th>Acquitée?</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
            @if($quotation->haveDownPercent())
                <tr>
                    @if(!$quotation->haveDownInvoice())
                        <td colspan="7">
                            <a href="{{ route('admin.quotation.invoice.create', ['id' => $quotation->id, 'type' => 'isDown', 'percent'=>$quotation->downPercentPayment]) }}" class="btn-yellow2">Générer la facture d'acompte</a>
                        </td>
                    @else
                        <td>{{ $quotation->downInvoice->id }}</td>
                        <td>Acompte</td>
                        <td>{{ $quotation->downInvoice->percent }}</td>
                        <td>{{ \App\Common\FormatManager::price($quotation->downInvoice->amountHT) }}€</td>
                        <td>{{ \App\Common\FormatManager::price($quotation->downInvoice->amountTTC) }}€</td>
                        @if($quotation->downInvoice->isPayed)
                            <td>OUI</td>
                        @else
                            <td><a href="{{ route('invoice.validatePayment', ['type' => 'isDown', 'origin' => 'quotation', 'origin_id' => $quotation->id]) }}" class="btn-yellow">Valider paiement</a></td>
                        @endif
                        <td>
                            <a href="{{ route('invoice.get', ['type' => 'isDown', 'origin' => 'quotation', 'origin_id' => $quotation->id]) }}" >Voir</a><br />
                            <a href="{{ route('invoice.sendMail', ['type' => 'isDown', 'origin' => 'quotation', 'origin_id' => $quotation->id]) }}" >Envoyer par mail</a>
                        </td>
                    @endif
                </tr>
            @endif
            @foreach($quotation->invoices as $invoice)
                @if($invoice->isIntermediate)
                    <tr>
                        <td>{{ $invoice->id }}</td>
                        <td>Intermédiaire</td>
                        <td>{{ $invoice->percent }}</td>
                        <td>{{ \App\Common\FormatManager::price($invoice->amountHT) }}€</td>
                        <td>{{ \App\Common\FormatManager::price($invoice->amountTTC) }}€</td>
                        @if($invoice->isPayed)
                            <td>OUI</td>
                        @else
                            <td><a href="{{ route('invoice.validatePayment', ['type' => 'isIntermediate', 'origin' => 'quotation', 'origin_id' => $quotation->id, 'intermediateNumber' => $invoice->intermediateNumber]) }}" class="btn-yellow">Valider paiement</a></td>
                        @endif
                        <td>
                            <a href="{{ route('invoice.get', ['type' => 'isIntermediate', 'origin' => 'quotation', 'origin_id' => $quotation->id, 'intermediateNumber' => $invoice->intermediateNumber]) }}" >Voir</a><br />
                            <a href="{{ route('invoice.sendMail', ['type' => 'isIntermediate', 'origin' => 'quotation', 'origin_id' => $quotation->id, 'intermediateNumber' => $invoice->intermediateNumber]) }}" >Envoyer par mail</a>
                        </td>
                    </tr>
                @endif
            @endforeach
            @if($quotation->canHaveNewIntermediateInvoice())
                <tr>
                    <td colspan="5">
                        20%
                    </td>
                    <td colspan="2">
                        <a href="{{ route('admin.quotation.invoice.create', ['id' => $quotation->id, 'type' => 'isIntermediate', 'percent' => 20, 'intermediateNumber'=>$quotation->nextIntermediateInvoiceNumber()]) }}" class="btn-yellow2">Générer une facture intermédiaire</a>
                    </td>
                </tr>
            @endif
            @if($quotation->canGenerateSoldInvoice())
                <td colspan="7">
                    <a href="{{ route('admin.quotation.invoice.create', ['id' => $quotation->id, 'type' => 'isSold', 'percent'=>$quotation->soldPercent]) }}" class="btn-yellow2">Générer Facture de solde</a>
                </td>
            @elseif($quotation->haveSoldInvoice())
                <td>{{ $quotation->soldInvoice->id }}</td>
                <td>Solde</td>
                <td>{{ $quotation->soldInvoice->percent }}</td>
                <td>{{ \App\Common\FormatManager::price($quotation->soldInvoice->amountHT) }}€</td>
                <td>{{ \App\Common\FormatManager::price($quotation->soldInvoice->amountTTC) }}€</td>
                @if($quotation->soldInvoice->isPayed)
                    <td>OUI</td>
                @else
                    <td><a href="{{ route('invoice.validatePayment', ['type' => 'isSold', 'origin' => 'quotation', 'origin_id' => $quotation->id]) }}" class="btn-yellow">Valider paiement</a></td>
                @endif
                <td>
                    <a href="{{ route('invoice.get', ['type' => 'isSold', 'origin' => 'quotation', 'origin_id' => $quotation->id]) }}" >Voir</a><br />
                    <a href="{{ route('invoice.sendMail', ['type' => 'isSold', 'origin' => 'quotation', 'origin_id' => $quotation->id]) }}" >Envoyer par mail</a>
                </td>
            @endif
        </tbody>
    </table>
@endif
</div>