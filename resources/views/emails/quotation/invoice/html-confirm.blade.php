<img src="{{  asset('/images/codeheures.svg') }}" width="300px" height="auto">
@if(!$isAdmin)
    @if($type == 'isDown')
    <h3>Merci pour votre achat sur CODEheures :-)</h3>

    <p>Votre devis a bien été reçu signé et nous vous prions de trouver en pièce jointe la facture correspondant à l'acompte demandé</p>
    <p>Merci de proceder au paiement de celui-ci dans les delais indiqués afin d'initier la prestation prévue sur celui-ci</p>
    @elseif($type== 'isSold')
    <h3>La prestation de votre devis est achevée :-)</h3>

    <p>La prestation concernant <a href="{{ route('customer.quotation.showPdf', ['id' => $quotation->id]) }}">votre devis n°{{ $quotation->getPublicNumber() }}</a> est achevée</p>
    <p>Merci de proceder au paiement de celui-ci dans les delais indiqués afin d'obtenir tous les droits prévus aux conditions de celui-ci</p>
    @elseif($type== 'isIntermediate')
        <h3>La prestation de votre devis progresse :-)</h3>

        <p>La prestation concernant <a href="{{ route('customer.quotation.showPdf', ['id' => $quotation->id]) }}">votre devis n°{{ $quotation->getPublicNumber() }}</a> progresse</p>
        <p>Comme convenu entre nous, vous pouvez proceder au paiement intermédiaire de celui-ci suivant la facture ci-jointe. En vous en remerçiant par avance.</p>
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
    @if(!$invoice->isIntermediate)
        <a href="{{ route('invoice.get', ['type' => $type, 'origin' => 'quotation', 'origin_id' => $quotation->id]) }}" style="color: #3880aa;">Votre facture</a>
    @else
        <a href="{{ route('invoice.get', ['type' => $type, 'origin' => 'quotation', 'origin_id' => $quotation->id, 'intermediateNumber'=>$invoice->intermediateNumber]) }}" style="color: #3880aa;">Votre facture</a>
    @endif
    </p>
    <p>A tout de suite!</p>
@else
    <h3>Une facture a été envoyé à {{ $user->email }} :-)</h3>

    <p>La facture n° {{ $invoice->number }} en PJ a été envoyée au client {{ $user->email }}:<br />
        @if(!$invoice->isIntermediate)
            <a href="{{ route('invoice.get', ['type' => $type, 'origin' => 'quotation', 'origin_id' => $quotation->id]) }}" style="color: #3880aa;">Voir la facture</a>
        @else
            <a href="{{ route('invoice.get', ['type' => $type, 'origin' => 'quotation', 'origin_id' => $quotation->id, 'intermediateNumber'=>$invoice->intermediateNumber]) }}" style="color: #3880aa;">Voir la facture</a>
        @endif
@endif
@include('emails/footer/html')