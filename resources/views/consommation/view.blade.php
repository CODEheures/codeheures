
{!! Form::model($consommationToEdit, ['method' => 'PUT', 'class' => 'form-horizontal', 'url' => route('admin.consommation.update', ['id'=>$consommationToEdit->id])]) !!}
{!! Form::hidden('purchase_id', $purchase->id) !!}
    <div class="purchase">
        <p>
            <span class="purchase-date">Achat du {{ $purchase->created_at->formatLocalized('%A %e %B %Y') }}:</span> {{ $purchase->quantity }}x "
        </p>
        <table class="purchase-table">
            <thead>
            <tr>
                <th>Date</th>
                <th>Justification</th>
                <th>Consommation</th>
                <th>Reliquat forfait</th>
                <th>Action</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <td colspan="5">détails<br /><i class="ion-chevron-down"></i></td>
            </tr>
            </tfoot>
            <tbody>

            <?php $reste = (int) $purchase->product->value*$purchase->quantity; ?>
            @foreach($consommations as $consommation)
                <?php $reste =  round($reste - round($consommation->value,1),1); ?>
                @if($consommation->id == $consommationToEdit->id)
                    <tr>
                        <td>{!! Form::input('date', 'created_at', $consommationToEdit->created_at->formatLocalized('%Y-%m-%d'), ['class' => 'form-control', 'placeholder' => '10-11-2015']) !!}</td>
                        <td>{!! Form::text('comment', null, ['class' => 'form-control', 'placeholder' => 'Ajout d\'un texte en page d\'accueil']) !!}</td>
                        <td>{!! Form::text('value', null, ['class' => 'form-control', 'placeholder' => '2.4']) !!}</td>
                        <td>{{ $reste }}</td>
                        <td>
                            <input type="submit" class="btn-yellow2" value="Modifier" />
                        </td>
                    </tr>
                @else
                    <tr>
                        <td>{{ $consommation->created_at->formatLocalized('%d-%m-%Y') }}</td>
                        <td>{{ $consommation->comment }}</td>
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
        <div class="reliquat-customer-info">
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

<div class="clear"></div>