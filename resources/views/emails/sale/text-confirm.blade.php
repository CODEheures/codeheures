@if(!$isAdmin)
Merci pour votre achat sur CODEheures :-)

Votre achat sur CODEheures est confirmé

Vous pouvez suivre votre consommation globale sur votre espace client à l'adresse suivante:
{{ route('customer.monitor.index') }}

Vous pouvez suivre la consommation de cet achat sur votre espace client à l'adresse suivante:
{{ route('purchase.show', ['id' => $purchase->id]) }}

Vous pouvez récupere votre facture en format PDF en pièce jointe de ce mail et à tout moment sur l'consommation sur votre espace client à l'adresse suivante:
{{ route('invoice.get', ['type' => 'isSold', 'origin' => 'purchase','origin_id' => $purchase->id]) }}

A tout de suite!
@else
Une facture a été envoyé à {{ $user->email }} :-)

La facture n°{{ $invoice->number }} en PJ a été envoyée au client {{ $user->email }}:
La facture est aussi ici: route('invoice.get', ['type' => $type, 'origin' => 'quotation', 'origin_id' => $quotation->id]) }}
@endif