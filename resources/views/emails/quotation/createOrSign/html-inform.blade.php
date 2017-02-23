<img src="{{  asset('/images/codeheures.svg') }}" width="300px" height="auto">
@if(!$isAdmin)
    @if(!$isCreate)
        <h3>Vous avez signé votre devis et CODEheures vous en remercie :-)</h3>

        <p>Votre devis n°{{ $quotation->getPublicNumber() }} a bien été signé numériquement et nous vous prions de le retrouver en pièce jointe</p>
        <p>Merci de signer manuellement celui-ci dans les 15 prochain jour afin que CODEheure poursuive les prestation prévues sur celui-ci</p>

        <p>Vous pouvez aussi le retrouver sur votre espace client à l'adresse suivante:<br />
        <a href="{{ route('customer.quotation.showPdf', ['id' => $quotation->id]) }}" style="color: #3880aa;">Votre devis</a></p>

        <p>Vous pouvez suivre votre consommation globale sur votre espace client à l'adresse suivante:<br />
        <a href="{{ route('customer.monitor.index') }}" style="color: #3880aa;">Espace client</a></p>

        <p>Vous pourrez suivre les consommations des prestations prévu au devis sur votre espace client à(aux) l'adresse(s) suivante(s):<br />
        @foreach($quotation->purchases as $purchase)
        @if($purchase->product->type == 'time')
        <a href="{{ route('purchase.show', ['id' => $purchase->id]) }}" style="color: #3880aa;">Vos Prestations prévus au devis</a></p>
        @endif
        @endforeach

    @elseif($isCreate && $user->new_create_by_admin)
        <h3>Vous avez un nouveau devis disponible sur CODEheures :-)</h3>

        <p>CODEheures vous à mis à disposition un nouveau devis (n°{{ $quotation->getPublicNumber() }}) sur votre nouvel espace client dédié</p>
        <p>Rendez-vous à l'adresse suivante pour en prendre connaissance:
            <a href="{{ route('process2.accountConfirm', ['userId' => $user->id, 'token' => $user->confirmation_token]) }}" style="color: #3880aa;">Vos devis CODEHeures sur votre espace client</a></p>
    @else
        <h3>Vous avez un nouveau devis disponible sur CODEheures :-)</h3>

        <p>CODEheures vous à mis à disposition un nouveau devis (n°{{ $quotation->getPublicNumber() }}) sur votre espace client </p>
        <p>Rendez-vous à l'adresse suivante pour en prendre connaissance:
            <a href="{{ route('customer.quotation.index') }}" style="color: #3880aa;">Vos devis CODEHeures sur votre espace client</a></p>
    @endif
    <p>A tout de suite!</p>
@else
    @if(!$isCreate)
        <h3>Un Devis a été signé numériquement par {{ $user->email }} :-)</h3>

        <p>Le devis n°{{ $quotation->getPublicNumber() }} en PJ a été signé numériquement et envoyée au client {{ $user->email }} (tel: {{ $user->phone }}):<br />
        <a href="{{ route('customer.quotation.showPdf', ['id' => $quotation->id]) }}" style="color: #3880aa;">Votre devis</a></p>
    @else
        <h3>Un Devis a été envoyé au client {{ $user->email }} :-)</h3>
        <p>Le devis n°{{ $quotation->getPublicNumber() }} a été envoyée au client {{ $user->email }}:<br />
            <a href="{{ route('admin.quotation.edit', ['id' => $quotation->id]) }}" style="color: #3880aa;">Le devis ici</a></p>
    @endif
@endif
@include('emails/footer/html')