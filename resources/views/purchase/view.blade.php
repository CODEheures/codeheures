@if($purchase->product->type == 'time')
    <div class="purchase">
        <div class="purchase-title">
            <h2><i class="ion-ios-information-outline"></i>Commande N°{{ $purchase->hash_key }}:</h2>
        </div>
        @if($purchase->havePaypalInvoice())
        <nav class="purchase-get-invoice-pdf">
            <p><a href="{{ route('invoice.get', ['type' => 'isSold', 'origin' => 'purchase','origin_id' => $purchase->id]) }}"><i class="ion-archive"></i>Télécharger la facture</a></p>
        </nav>
        @else
        @endif
        <p>
            <span class="purchase-date">Achat du {{ $purchase->created_at->formatLocalized('%A %e %B %Y') }}
                @if(auth()->user()->role == 'admin')par {{ $purchase->user->name }} ({{ $purchase->user->email }})@endif
                :</span> {{ $purchase->quantity }}x "{{ $purchase->product->description }}"
                @if($purchase->quotation_id)<a href="{{ route('customer.quotation.pdf', ['id'=>$purchase->quotation_id]) }}" class="quotation-number">(devis {{ $purchase->quotation->getPublicNumber() }})</a>@endif
        </p>
        <table class="purchase-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Justification</th>
                    <th>Référence</th>
                    <th>Consommation</th>
                    <th>Reliquat forfait</th>
                    @if(auth()->user()->role == 'admin')
                    <th>Action</th>
                    @endif
                </tr>
            </thead>
            <tfoot>
            <tr>
                <td colspan={!! auth()->user()->role == 'admin' ? "6":"5" !!}>détails<br /><i class="ion-chevron-up"></i></td>
            </tr>
            </tfoot>
            <tbody>

            <?php $reste = (int) $purchase->product->value*$purchase->quantity; ?>
            @foreach($purchase->consommations as $consommation)
                <?php $reste =  round($reste - round($consommation->value,2),2); ?>
                <tr>
                    <td>{{ $consommation->created_at->formatLocalized('%d-%m-%Y') }}</td>
                    <td {!! auth()->user()->role == 'admin' ? null: 'width="40%"' !!}>{{ $consommation->comment }}</td>
                    @if($consommation->prestation_id != null)
                        <td>{{ $consommation->prestation->name }} ({{ $consommation->prestation->duration }}h) x {{ $consommation->ratio_prestation }}</td>
                    @else
                        <td>-</td>
                    @endif
                    <td>{{ $consommation->value }}</td>
                    <td>{{ $reste }}</td>
                    @if(auth()->user()->role == 'admin')
                        <td>
                            <a href="{{ route('admin.consommation.delete', ['id'=> $consommation->id]) }}" class="btn-danger">
                                <i class="ion-ios-close-outline"></i> Supprimer
                            </a>
                            <br />
                            <a href="{{ route('admin.consommation.edit', ['id'=> $consommation->id]) }}" class="btn-danger">
                                <i class="ion-edit"></i> Modifier
                            </a>
                        </td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="purchase-title">
        <h2><i class="ion-ios-speedometer-outline"></i>Ma consommation</h2>
        <div class="btn-fake reliquat-customer-info">
            Crédit: {{ $totalLeft }}h
        </div>
    </div>

    @if(count($purchase->consommations)==0)
        <div class="purchase">
            <p>Aucun relevé de consommation pour l'instant!</p>
        </div>
    @else
        <div class="graph-conso">
            <figure id="graphConso1"></figure>
        </div>
    @endif

@else
    <div class="purchase-title">
        <h2><i class="ion-ios-settings"></i>Prestations personnalisées</h2>
    </div>

    <div class="purchase">
        <table>
            <tbody>
                <tr>
                    <td class="presta-perso">
                        <i class="ion-minus-round"></i>
                        <span class="purchase-date">Achat du {{ $purchase->created_at->formatLocalized('%A %e %B %Y') }}:</span> "{{ $purchase->product->description }}"
                        @if($purchase->quotation_id)<a href="{{ route('customer.quotation.pdf', ['id'=>$purchase->quotation_id]) }}" class="quotation-number">(devis {{ $purchase->quotation->getPublicNumber() }})</a>@endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endif

@if(auth()->user()->role =='admin')
    <div class="purchase-title">
        <h2><i class="ion-plus-round"></i>Ajouter une consommation client</h2>
        <div class="btn-fake reliquat-customer-info">
            Maxi: {{ $totalLeft }}@if($purchase->product->type=='time')h @else unité(s) @endif
        </div>
    </div>
    {!! Form::open(['class' => 'form-horizontal', 'url' => route('admin.consommation.store')]) !!}

    {!! Form::hidden('purchase_id', $purchase->id) !!}

    @if($purchase->product->type=='time')
    <div class="form-group">
            <span class="input input--fumi">
                {!! Form::select('prestation_id', $prestations, null, ['class' => 'input__field input__field--fumi', 'data-assist' => 'assist1']) !!}
                <label for="prestation_id" class="input__label input__label--fumi">
                    <i class="fa fa-fw fa-link icon icon--fumi"></i>
                    <span class="input__label-content input__label-content--fumi">Prestation de référence</span>
                </label>
            </span>
    </div>
    <div class="form-group">
        <span class="input input--fumi">
            {!! Form::number('ratio_prestation', null, ['class' => 'input__field input__field--fumi', 'placeholder' => '2.4', 'min' => '0', 'step' => '0.01', 'data-assist' => 'assist1b']) !!}
            <label for="ratio_prestation" class="input__label input__label--fumi">
                <i class="fa fa-fw fa-calculator icon icon--fumi"></i>
                <span class="input__label-content input__label-content--fumi">Quantité de la prestation de référence</span>
            </label>
        </span>
    </div>
    @endif

    <div class="form-group">
        <span class="input input--fumi">
            {!! Form::number('value', null, ['class' => 'input__field input__field--fumi', 'placeholder' => '2.4', 'min' => '0', 'step' => '0.01', 'data-isAssistBy' => 'assist1']) !!}
            <label for="value" class="input__label input__label--fumi">
                <i class="fa fa-fw fa-clock-o icon icon--fumi"></i>
                <span class="input__label-content input__label-content--fumi">Pointage @if($purchase->product->type=='time')(h) @else() (unités) @endif</span>
            </label>
        </span>
    </div>

    <div class="form-group">
        <span class="input input--fumi">
            {!! Form::text('comment', null, ['class' => 'input__field input__field--fumi', 'placeholder' => 'Ajout d\'un texte de justification']) !!}
            <label for="comment" class="input__label input__label--fumi">
                <i class="fa fa-fw fa-bullhorn icon icon--fumi"></i>
                <span class="input__label-content input__label-content--fumi">Commentaire</span>
            </label>
        </span>
    </div>

    <div class="form-group">
        <span class="input input--fumi">
            {!! Form::input('date', 'created_at', Carbon\Carbon::now()->formatLocalized('%Y-%m-%d'), ['class' => 'input__field input__field--fumi', 'placeholder' => '10-11-2015']) !!}
            <label for="date" class="input__label input__label--fumi">
                <i class="fa fa-fw fa-calendar-o icon icon--fumi"></i>
                <span class="input__label-content input__label-content--fumi">Date</span>
            </label>
        </span>
    </div>


    <div class="form-submit">
        <div class="submit">
            <input type="submit" class="btn-yellow2" value="Ajouter" />
        </div>
    </div>

    {!! Form::close() !!}
@endif