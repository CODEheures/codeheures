@extends('layouts.pdf')

@section('user.action')

    <div class="prestation-title">
        <h2 class="indication">Prestations standards</h2>
    </div>
    <div class="prestation">
        <div class="prestation-cgv">
            <p>Codeheure propose une liste de prestations standards. Si votre besoin est inscrit dans cette liste cela signifie que:</p>
            <ul class="disc">
                <li>CODEheures vous débitera au maximum le temps correspondant à la prestation</li>
                <li>Si le temps de réalisation est plus long que le temps correspondant CODEheures prendra à sa charge le dépassement</li>
                <li>Si le temps de réalisation est plus court que le temps correspondant CODEheures reportera le reliquat pour une prochaine prestation</li>
            </ul>
        </div>
    </div>
    <div class="prestation-title">
        <h2>Grille des prestations standards</h2>
    </div>
    <div class="prestation">
        <table class="prestation-table">
            <thead>
            <tr>
                <th>Prestation</th>
                <th>Durée [en heure(s)]</th>
            </tr>
            </thead>
            <tbody>
            @foreach($prestations as $prestation)
                <tr>
                    <td>
                        <span class="prestation-name">{{ $prestation->name }}</span><br />
                        <span class="prestation-description">{{ $prestation->description }}</span><br />
                        @if(isset($prestation->url) && $prestation->url != '')
                            <span class="prestation-link">Voir le lien suivant: <a href="{{ $prestation->url }}">{{ $prestation->url }}</a></span>
                        @endif
                    </td>
                    <td>{{ $prestation->duration }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <p class="modification">
            Toute révision ou modification de ce barême est communiqué automatiquement au client par mail.
            En outre, selon les Conditions générales de ventes (disponibles à l'adresse
            http://codeheures.fr/conditions-generales-de-ventes), tout client possédant un crédit d'heure garde la
            possibilité de se faire rembourser celui-ci sans délai et sans condition au prix d'achat sur simple
            demande par mail.
        </p>
    </div>
@endsection