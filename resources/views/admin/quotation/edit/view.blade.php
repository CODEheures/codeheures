<div class="quotation-title">
    <h2><i class="ion-ios-information-outline"></i>Informations devis</h2>
    <div class="total-price-quotation-info">
        Coût total: {{ $totalPrice }}€
    </div>
</div>
@include('admin.quotation.progressbar.view')
<div class="quotation">
    {!! Form::model($quotation, ['method'=>'put', 'class' => 'form-horizontal', 'url' => route('admin.quotation.update', ['id' => $quotation->id])]) !!}
        <div class="form-group">
            {!! Form::label('user_id', 'Client') !!}
            {!! Form::select('user_id', $userList, null, ['class' => 'form-control'. ($quotation->canEdit() == false ? ' form-disable':'')]) !!}
        </div>

        <div class="form-group">
            {!! Form::label('validity', 'Date de validité') !!}
            {!! Form::input('date', 'validity', null, ['class' => 'form-control'. ($quotation->canEdit() == false ? ' form-disable':''), 'placeholder' => '10-11-2015']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('downPercentPayment', 'Acompte demandé en %') !!}
            {!! Form::input('number', 'downPercentPayment', null, ['class' => 'form-control'. ($quotation->canEdit() == false ? ' form-disable':''), 'placeholder' => '20']) !!}
        </div>

        <div class="form-group">
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
            <td colspan="6">détails<br /><i class="ion-chevron-down"></i></td>
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
                    <td>{{ $lineQuote->product->price }}</td>
                    <td>{!! Form::input('number', 'quantity', null, ['class' => 'form-control'. ($quotation->canEdit() == false ? ' form-disable':''), 'placeholder' => '3']) !!}</td>
                    <td>
                        {!! Form::input('number', 'discount', null, ['class' => 'form-control'. ($quotation->canEdit() == false ? ' form-disable':''), 'placeholder' => '20']) !!}
                        {!! Form::select('discount_type', $listEnumDiscountType , null, ['class' => 'form-control'. ($quotation->canEdit() == false ? ' form-disable':'')]) !!}
                    </td>
                    @if($lineQuote->discount > 0 && $lineQuote->discount_type == 'devise')
                        <td>{{ $lineQuote->product->price*$lineQuote->quantity - $lineQuote->discount}}</td>
                    @elseif($lineQuote->discount > 0 && $lineQuote->discount_type == 'percent')
                        <td>{{ $lineQuote->product->price*$lineQuote->quantity*(1-$lineQuote->discount/100)}}</td>
                    @else
                        <td>{{ $lineQuote->product->price*$lineQuote->quantity }}</td>
                    @endif
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
                <td>{{ $lineQuote->product->price }}</td>
                <td>{{ $lineQuote->quantity }}</td>
                <td>
                    @if($lineQuote->discount > 0)-{{ $lineQuote->discount }}
                        @if($lineQuote->discount_type == 'percent')
                            %
                        @else
                            €
                        @endif
                    @else
                        -
                    @endif
                </td>
                @if($lineQuote->discount > 0 && $lineQuote->discount_type == 'devise')
                    <td>{{ $lineQuote->product->price*$lineQuote->quantity - $lineQuote->discount}}</td>
                @elseif($lineQuote->discount > 0 && $lineQuote->discount_type == 'percent')
                    <td>{{ $lineQuote->product->price*$lineQuote->quantity*(1-$lineQuote->discount/100)}}</td>
                @else
                    <td>{{ $lineQuote->product->price*$lineQuote->quantity }}</td>
                @endif
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

<div class="clear"></div>

<div class="quotation-title">
    <h2><i class="ion-plus-round"></i>Ajouter une ligne au devis</h2>
</div>
<div class="quotation">

    {!! Form::model($newLineQuote, ['class' => 'form-horizontal', 'url' => route('admin.lineQuote.store')]) !!}

    {!! Form::hidden('quotation_id', $quotation->id) !!}

    <div class="form-group">
        {!! Form::label('product_id', 'Client') !!}
        {!! Form::select('product_id', $productList, null, ['class' => 'form-control'. ($quotation->canEdit() == false ? ' form-disable':'')]) !!}
    </div>

    <div class="form-group">
        {!! Form::label('quantity', 'Quantité') !!}
        {!! Form::input('number', 'quantity', null, ['class' => 'form-control'. ($quotation->canEdit() == false ? ' form-disable':''), 'placeholder' => '3']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('discount', 'Réduction') !!}
        {!! Form::input('number', 'discount', null, ['class' => 'form-control'. ($quotation->canEdit() == false ? ' form-disable':''), 'placeholder' => '20']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('discount_type', 'Type de réduction') !!}
        {!! Form::select('discount_type', $listEnumDiscountType , null, ['class' => 'form-control'. ($quotation->canEdit() == false ? ' form-disable':'')]) !!}
    </div>

    <div class="form-group">
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

<div class="clear"></div>

<div class="quotation-title">
    <h2><i class="ion-ios-people-outline"></i>Publication</h2>
</div>
<div class="quotation">
        @if($quotation->canPublish())
            <a href="{{ route('admin.quotation.publish', ['id' => $quotation->id]) }}" class="btn-yellow2">Publier</a>
        @else
            <a href="{{ route('admin.quotation.publish', ['id' => $quotation->id]) }}" class="btn-disable">Publier</a>
        @endif
        @if($quotation->canUnpublish())
            <a href="{{ route('admin.quotation.unPublish', ['id' => $quotation->id]) }}" class="btn-yellow2">Dépublier</a>
        @else
            <a href="{{ route('admin.quotation.unPublish', ['id' => $quotation->id]) }}" class="btn-disable">Dépublier</a>
        @endif
        @if($quotation->canDelete())
            <a href="{{ route('admin.quotation.delete', ['id' => $quotation->id]) }}" class="btn-yellow2">Supprimer</a>
        @else
            <a href="{{ route('admin.quotation.delete', ['id' => $quotation->id]) }}" class="btn-disable">Supprimer</a>
        @endif
        @if($quotation->canArchive())
            <a href="{{ route('admin.quotation.archive', ['id' => $quotation->id]) }}" class="btn-yellow2">Archiver</a>
        @else
            <a href="{{ route('admin.quotation.archive', ['id' => $quotation->id]) }}" class="btn-disable">Archiver</a>
        @endif
</div>