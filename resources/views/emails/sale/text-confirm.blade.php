Merci pour votre achat sur CODEheures :-)

Votre achat sur CODEheures est confirmé

Vous pouvez suivre votre consommation globale sur votre espace client à l'adresse suivante:
{{ route('customer.monitor.index') }}

Vous pouvez suivre la consommation de cet achat sur votre espace client à l'adresse suivante:
{{ route('purchase.show', ['id' => $purchase->id]) }}

Vous pouvez récupere votre facture en format PDF en pièce jointe de ce mail et à tout moment sur l'consommation sur votre espace client à l'adresse suivante:
{{ route('customer.billing', ['id' => $purchase->id]) }}

<p>A tout de suite!</p>