
{!! Form::model($consommationToEdit, ['method' => 'PUT', 'class' => 'form-horizontal', 'url' => route('admin.consommation.update', ['id'=>$consommationToEdit->id])]) !!}
{!! Form::hidden('purchase_id', $purchase->id) !!}
    <div class="purchase">
        <p>
            <span class="purchase-date">Achat du {{ $purchase->created_at->formatLocalized('%A %e %B %Y') }}
                :</span> {{ $purchase->quantity }}x "{{ $purchase->product->description }}"
            @if($purchase->quotation_id)<a href="{{ route('customer.quotation.showPdf', ['id'=>$purchase->quotation_id]) }}" class="quotation-number">(devis {{ $purchase->quotation->getPublicNumber() }})</a>@endif
        </p>
        <table class="purchase-table">
            <thead>
            <tr>
                <th>Date</th>
                <th>Justification</th>
                <th>Référence</th>
                <th>Consommation</th>
                <th>Reliquat forfait</th>
                <th>Action</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <td colspan="6">détails<br /><i class="ion-chevron-up"></i></td>
            </tr>
            </tfoot>
            <tbody>
            <?php $reste = (int) $purchase->product->value*$purchase->quantity; ?>
            @foreach($consommations as $consommation)
                <?php $reste =  round($reste - round($consommation->value,2),2); ?>
                @if($consommation->id == $consommationToEdit->id)
                    <tr>
                        <?php $consommationToEdit->prestation_id != null ? $max = $consommationToEdit->prestation->duration*$consommationToEdit->ratio_prestation : $max = ''; ?>
                        <td>{!! Form::input('date', 'created_at', $consommationToEdit->created_at->formatLocalized('%Y-%m-%d'), ['class' => 'form-control', 'placeholder' => '10-11-2015']) !!}</td>
                        <td>{!! Form::text('comment', null, ['class' => 'form-control', 'placeholder' => 'Ajout d\'un texte en page d\'accueil']) !!}</td>
                        <td>{!! Form::select('prestation_id', $prestations, null, ['class' => 'input__field input__field--fumi', 'data-assist' => 'assist1']) !!} x {!! Form::number('ratio_prestation', null, ['class' => 'input__field input__field--fumi', 'placeholder' => '2.4', 'min' => '0', 'step' => '0.01', 'data-assist' => 'assist1b']) !!}</td>
                        <td>{!! Form::number('value', null, ['class' => 'form-control', 'placeholder' => '2.4', 'min' => '0', 'max' => $max, 'step' => '0.01', 'data-isAssistBy' => 'assist1']) !!}</td>
                        <td>{{ $reste }}</td>
                        <td>
                            <input type="submit" class="btn-yellow2" value="Modifier" />
                            <a href="{{ route('purchase.show', ['id' => $purchase->id]) }}" class="btn-transparent">Annuler</a>
                        </td>
                    </tr>
                @else
                    <tr>
                        <td>{{ $consommation->created_at->formatLocalized('%d-%m-%Y') }}</td>
                        <td>{{ $consommation->comment }}</td>
                        @if($consommation->prestation_id != null)
                            <td>{{ $consommation->prestation->name }} ({{ $consommation->prestation->duration }}h) x {{ $consommation->ratio_prestation }}</td>
                        @else
                            <td>-</td>
                        @endif
                        <td>{{ $consommation->value }}</td>
                        <td>{{ $reste }}</td>
                        <td></td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
    </div>
{!! Form::close() !!}

    <div class="purchase-title">
        <h2><i class="ion-ios-speedometer-outline"></i>Ma consommation</h2>
        <div class="btn-fake reliquat-customer-info">
            Crédit: {{ $reste }}h
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