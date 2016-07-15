<img src="{{  asset('css/images/codeheures.svg') }}" width="300px" height="auto">
<h3>Merci pour votre achat sur CODEheures :-)</h3>

<p>Votre achat sur CODEheures est confirmé</p>

<p>Vous pouvez suivre votre consommation globale sur votre espace client à l'adresse suivante:<br />
<a href="{{ route('customer.monitor.index') }}" style="color: #3880aa;">Espace client</a></p>

<p>Vous pouvez suivre la consommation de cet achat sur votre espace client à l'adresse suivante:<br />
<a href="{{ route('purchase.show', ['id' => $purchase->id]) }}" style="color: #3880aa;">Votre Achat de ce jour</a></p>

<p>Vous pouvez récuperer votre facture en format PDF en pièce jointe de ce mail et à tout moment sur l'consommation sur votre espace client à l'adresse suivante:<br />
<a href="{{ route('customer.billing', ['id' => $purchase->id]) }}" style="color: #3880aa;">Votre facture</a></p>

<p>A tout de suite!</p>