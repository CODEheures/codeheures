<img src="{{  asset('css/images/codeheures.svg') }}" width="300px" height="auto">
@if($type == 'isDown')
<h3>Merci pour votre achat sur CODEheures :-)</h3>

<p>Votre devis a bien été reçu signé et nous vous prions de trouver en pièce jointe la facture correspondant à l'acompte demandé</p>
<p>Merci de proceder au paiement de celui-ci dans les delais indiqués afin d'initier la prestation prévue sur celui-ci</p>
@elseif($quotation->haveDownPercent())
<h3>La prestation de votre devis est achevée :-)</h3>

<p>La prestation concernant <a href="{{ route('customer.quotation.pdf', ['id' => $quotation->id]) }}">votre devis n°{{ $quotation->getPublicNumber() }}</a> est achevée</p>
<p>Merci de proceder au paiement de celui-ci dans les delais indiqués afin d'obtenir tous les droits prévus aux conditions de celui-ci</p>
@else
<h3>Merci pour votre achat sur CODEheures :-)</h3>

<p>Votre devis a bien été reçu signé et nous vous prions de trouver en pièce jointe la facture correspondant à celui-ci</p>
<p>Merci de proceder au paiement de celui-ci dans les delais indiqués afin d'initier la prestation prévue sur celui-ci</p>
@endif
<p>Vous pouvez suivre votre consommation globale sur votre espace client à l'adresse suivante:<br />
<a href="{{ route('customer.monitor.index') }}" style="color: #3880aa;">Espace client</a></p>

<p>Vous pouvez suivre les consommations des achats prévu au devis sur votre espace client à(aux) l'adresse(s) suivante(s):<br />
@foreach($quotation->purchases as $purchase)
@if($purchase->product->type == 'time')
<a href="{{ route('purchase.show', ['id' => $purchase->id]) }}" style="color: #3880aa;">Votre Achat de ce jour</a></p>
@endif
@endforeach

<p>Vous pouvez récuperer votre facture en format PDF en pièce jointe de ce mail et à tout moment sur l'consommation sur votre espace client à l'adresse suivante:<br />
<a href="{{ route('invoice.get', ['type' => $type, 'origin' => 'quotation', 'origin_id' => $quotation->id]) }}" style="color: #3880aa;">Votre facture</a></p>

<p>A tout de suite!</p>