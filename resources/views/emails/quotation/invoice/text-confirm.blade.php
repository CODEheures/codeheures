@if($type == 'isDown')
Merci pour votre achat sur CODEheures :-)

Votre devis a bien été reçu signé et nous vous prions de trouver en pièce jointe la facture correspondant à l'acompte demandé
Merci de proceder au paiement de celui-ci dans les delais indiqués afin d'initier la prestation prévue sur celui-ci
@elseif($quotation->haveDownPercent())
La prestation de votre devis est achevée :-)

La prestation concernant votre devis n°{{ $quotation->getPublicNumber() }} est achevée (devis disponible ici: {{ route('customer.quotation.pdf', ['id' => $quotation->id]) }})
Merci de proceder au paiement de celui-ci dans les delais indiqués afin d'obtenir tous les droits prévus aux conditions de celui-ci
@else
Merci pour votre achat sur CODEheures :-)

Votre devis a bien été reçu signé et nous vous prions de trouver en pièce jointe la facture correspondant à celui-ci
Merci de proceder au paiement de celui-ci dans les delais indiqués afin d'initier la prestation prévue sur celui-ci
@endif
Vous pouvez suivre votre consommation globale sur votre espace client à l'adresse suivante:
{{ route('customer.monitor.index') }}

Vous pouvez suivre les consommations des achats prévu au devis sur votre espace client à(aux) l'adresse(s) suivante(s):
@foreach($quotation->purchases as $purchase)
@if($purchase->product->type == 'time')
{{ route('purchase.show', ['id' => $purchase->id]) }}
@endif
@endforeach

Vous pouvez récuperer votre facture en format PDF en pièce jointe de ce mail et à tout moment sur l'consommation sur votre espace client à l'adresse suivante:
{{ route('invoice.get', ['type' => $type, 'origin' => 'quotation','origin_id' => $quotation->id]) }}

A tout de suite!