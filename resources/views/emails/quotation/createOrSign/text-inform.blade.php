@if(!$isAdmin)
@if(!$isCreate)
Vous avez signé votre devis et CODEheures vous en remercie :-)

Votre devis n°{{ $quotation->getPublicNumber() }} a bien été signé numériquement et nous vous prions de le retrouver en pièce jointe
Merci de signer manuellement celui-ci dans les 15 prochain jour afin que CODEheure poursuive les prestation prévues sur celui-ci

Vous pouvez aussi le retrouver sur votre espace client à l'adresse suivante:
{{ route('customer.quotation.showPdf', ['id' => $quotation->id]) }}

Vous pouvez suivre votre consommation globale sur votre espace client à l'adresse suivante:
{{ route('customer.monitor.index') }}

Vous pourrez suivre les consommations des prestations prévu au devis sur votre espace client à(aux) l'adresse(s) suivante(s):
@foreach($quotation->purchases as $purchase)
@if($purchase->product->type == 'time')
{{ route('purchase.show', ['id' => $purchase->id]) }}
@endif
@endforeach
@else
Vous avez un nouveau devis disponible sur CODEheures :-)

CODEheures vous à mis à disposition un nouveau devis (n°{{ $quotation->getPublicNumber() }}) sur votre espace client
Rendez-vous à l'adresse suivante pour en prendre connaissance:
{{ route('customer.quotation.index') }}
@endif
A tout de suite!
@else
@if(!$isCreate)
Un Devis a été signé numériquement par {{ $user->email }} :-)

Le devis n°{{ $quotation->getPublicNumber() }} en PJ a été signé numériquement et envoyée au client {{ $user->email }} (tel: {{ $user->phone }}):
{{ route('customer.quotation.showPdf', ['id' => $quotation->id]) }}
@else
Un Devis a été envoyé au client {{ $user->email }} :-)
Le devis n°{{ $quotation->getPublicNumber() }} a été envoyée au client {{ $user->email }}:
{{ route('admin.quotation.edit', ['id' => $quotation->id]) }}
@endif
@endif
@include('emails/footer/text')