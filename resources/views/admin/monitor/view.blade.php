<div class="purchase-title">
    <h2><i class="ion-ios-speedometer-outline"></i>Suivi d'activité globale</h2>
</div>

@if(!$data)
    <div class="purchase">
        <p>Aucune relevé de consommation pour l'instant!</p>
    </div>
@else
    <div class="graph-conso">
        <figure id="graphConso1"></figure>
    </div>
@endif

<div class="purchase-title">
    <h2><i class="ion-ios-list-outline"></i>Commandes clients</h2>
</div>

<div class="purchase">
@if(count($purchases)>0)
    <table>
        <tbody>
@foreach($purchases as $purchase)
    <?php $reste = (int) $purchase->product->value*$purchase->quantity; ?>
    @foreach($purchase->consommations as $consommation)
        <?php $reste =  round($reste - round($consommation->value,2),2); ?>
    @endforeach
    <tr>
        <td class="admin">
            <i class="ion-minus-round"></i><a href="{{ route('purchase.show', ['id' => $purchase->id]) }}" class="purchase-number">N°{{ $purchase->hash_key }}</a><span class="purchase-date"> du {{ $purchase->created_at->formatLocalized('%d-%m-%Y') }}:</span> "{{ $purchase->product->description }}" par {{ $purchase->user->name }} ({{ $purchase->user->email }})
            <span class="reliquat {!! $reste > 0 ? 'positive':null !!}">Reliquat: {{ $reste }}</span>
        </td>
    </tr>
@endforeach
        </tbody>
    </table>
@else
    <p>Aucune commande client...</p>
@endif
</div>

<div class="customer-title">
    <h2><i class="ion-ios-people-outline"></i>Liste clients</h2>
    <nav class="product-title">
        <p><a href="{{ route('admin.customer.create') }}"><i class="ion-ios-plus-outline"></i>Ajouter un client</a></p>
    </nav>
</div>
<div class="product">
    @if(count($customersList)>0)
        <table>
            <thead>
            <tr>
                <th>Nom d'utilisateur</th>
                <th>Email</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Société</th>
                <th>Téléphone</th>
                <th>actif ?</th>
                <th>Quota</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($customersList as $customer)
                <tr>
                    <td>
                        {{ $customer->name }}
                    </td>
                    <td>
                        {{ $customer->email }}
                    </td>
                    <td>
                        {{ $customer->firstName }}
                    </td>
                    <td>
                        {{ $customer->lastName }}
                    </td>
                    <td>
                        {{ $customer->enterprise }}
                    </td>
                    <td>
                        {{ $customer->phone }}
                    </td>
                    <td>
                        @include('admin.monitor.isActiveIcon.view')
                    </td>
                    <td>
                        {{ $customer->quota }}
                    </td>
                    <td class="quota">
                        <a href="{{ route('admin.customer.edit', ['id'=> $customer->id]) }}" class="btn-danger">
                            <i class="ion-edit"></i> Editer
                        </a>
                        @if(!$customer->is_admin_valid)
                        <a href="{{ route('admin.customer.active', ['id'=> $customer->id]) }}" class="btn-danger">
                            <i class="ion-ios-close-outline"></i> Activer
                        </a>
                        @else
                        <a href="{{ route('admin.customer.desactive', ['id'=> $customer->id]) }}" class="btn-danger">
                            <i class="ion-ios-close-outline"></i> Desactiver
                        </a>
                        {!! Form::open(['method' => 'PUT', 'class' => 'form-horizontal', 'url' => route('admin.customer.updateQuota', ['id'=>$customer->id])]) !!}
                            <p data-isAssistBy="assist2">Nouveau quota</p>
                            <input type="range" name="quota" class="form-control" min="0" max="50" step="1" value="{{ $customer->quota }}" data-assist="assist2">
                            <input type="submit" class="btn-yellow2" value="changer quota">
                        {!! Form::close() !!}
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <p>Aucun client pour le moment...</p>
    @endif
</div>