@if($purchase->product->type == 'time')
    <div class="purchase">
        <p>
            <span class="purchase-date">Achat du {{ $purchase->created_at->formatLocalized('%A %e %B %Y') }} @if(auth()->user()->role == 'admin')par {{ $purchase->user->name }} ({{ $purchase->user->email }})@endif:</span> {{ $purchase->quantity }}x "{{ $purchase->product->description }}"
        </p>
        <table class="purchase-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Justification</th>
                    <th>Consommation</th>
                    <th>Reliquat forfait</th>
                    @if(auth()->user()->role == 'admin')
                    <th>Action</th>
                    @endif
                </tr>
            </thead>
            <tfoot>
            <tr>
                <td colspan={!! auth()->user()->role == 'admin' ? "5":"4" !!}>détails<br /><i class="ion-chevron-down"></i></td>
            </tr>
            </tfoot>
            <tbody>

            <?php $reste = (int) $purchase->product->value*$purchase->quantity; ?>
            @foreach($purchase->consommations as $consommation)
                <?php $reste =  round($reste - round($consommation->value,1),1); ?>
                <tr>
                    <td>{{ $consommation->created_at->formatLocalized('%d-%m-%Y') }}</td>
                    <td {!! auth()->user()->role == 'admin' ? null: 'width="50%"' !!}>{{ $consommation->comment }}</td>
                    <td>{{ $consommation->value }}</td>
                    <td>{{ $reste }}</td>
                    @if(auth()->user()->role == 'admin')
                        <td>
                            <a href="{{ route('admin.consommation.delete', ['id'=> $consommation->id]) }}" class="btn btn-danger">
                                <i class="ion-ios-close-outline"></i> Supprimer
                            </a>
                            <br />
                            <a href="{{ route('admin.consommation.edit', ['id'=> $consommation->id]) }}" class="btn btn-danger">
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
        <div class="reliquat-customer-info">
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
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endif
<div class="clear"></div>

@if(auth()->user()->role =='admin')
    <div class="purchase-title">
        <h2><i class="ion-plus-round"></i>Ajouter une consommation client</h2>
        <div class="reliquat-customer-info">
            Maxi: {{ $totalLeft }}h
        </div>
    </div>
    {!! Form::open(['class' => 'form-horizontal', 'url' => route('admin.consommation.store')]) !!}

    {!! Form::hidden('purchase_id', $purchase->id) !!}

    <div class="form-group">
        <span class="input input--fumi">
            {!! Form::text('value', null, ['class' => 'input__field input__field--fumi', 'placeholder' => '2.4']) !!}
            <label for="value" class="input__label input__label--fumi">
                <i class="fa fa-fw fa-user icon icon--fumi"></i>
                <span class="input__label-content input__label-content--fumi">Pointage (h)</span>
            </label>
        </span>
    </div>

    <div class="form-group">
        <span class="input input--fumi">
            {!! Form::text('comment', null, ['class' => 'input__field input__field--fumi', 'placeholder' => 'Ajout d\'un texte en page d\'accueil']) !!}
            <label for="comment" class="input__label input__label--fumi">
                <i class="fa fa-fw fa-user icon icon--fumi"></i>
                <span class="input__label-content input__label-content--fumi">Commentaire</span>
            </label>
        </span>
    </div>

    <div class="form-group">
        <span class="input input--fumi">
            {!! Form::input('date', 'created_at', Carbon\Carbon::now()->formatLocalized('%Y-%m-%d'), ['class' => 'input__field input__field--fumi', 'placeholder' => '10-11-2015']) !!}
            <label for="date" class="input__label input__label--fumi">
                <i class="fa fa-fw fa-user icon icon--fumi"></i>
                <span class="input__label-content input__label-content--fumi">Date</span>
            </label>
        </span>
    </div>


    <div class="form-submit">
        <div class="submit">
            <input type="submit" class="btn btn-yellow2" value="Ajouter" />
        </div>
    </div>

    {!! Form::close() !!}
@endif