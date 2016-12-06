<img src="{{  asset('css/images/codeheures.svg') }}" width="300px" height="auto">
@if(!$isAdmin)
<h3>Merci pour votre achat sur CODEheures :-)</h3>

<p>Votre achat sur CODEheures est confirmé</p>

<p>Vous pouvez suivre votre consommation globale sur votre espace client à l'adresse suivante:<br />
<a href="{{ route('customer.monitor.index') }}" style="color: #3880aa;">Espace client</a></p>

<p>Vous pouvez suivre la consommation de cet achat sur votre espace client à l'adresse suivante:<br />
<a href="{{ route('purchase.show', ['id' => $purchase->id]) }}" style="color: #3880aa;">Votre Achat de ce jour</a></p>

<p>Vous pouvez récuperer votre facture en format PDF en pièce jointe de ce mail et à tout moment sur l'consommation sur votre espace client à l'adresse suivante:<br />
<a href="{{ route('invoice.get', ['type' => 'isSold', 'origin' => 'purchase','origin_id' => $purchase->id]) }}" style="color: #3880aa;">Votre facture</a></p>

<p>A tout de suite!</p>
@else
    <h3>Une facture pour un nouvel achat direct a été envoyé à {{ $user->email }} :-)</h3>

    <p>La facture n°{{ $invoice->number }} en PJ a été envoyée au client {{ $user->email }}:<br />
        <a href="{{ route('invoice.get', ['type' => 'isSold', 'origin' => 'purchase','origin_id' => $purchase->id]) }}" style="color: #3880aa;">Voir la facture</a></p>
@endif
@include('emails/footer/html')