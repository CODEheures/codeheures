@extends('layouts.common')

@section('meta-index')
    <meta name="robots" content="noindex">
@endsection

@section('css')
    @parent
@endsection

@section('title')
    <title>Conditions générales de vente | CODEheures développeur sites internet</title>
@endsection

@section('description')
    <meta name="description" content="Developpeur freelance pour la création de sites web, sites mobiles, applications internet, en région de Tours, 37.">
@endsection

@section('navbar')
    @include('navbar.index', ['navOptions' => ['shrinkForce' => true, 'active' => null]])
@endsection

@section('user.action')
    <h1>Conditions Générales de ventes</h1>
    <div class="cgv">
        <h2 class="fa"><i class="fa fa-square-o"></i> Article 1: Contrat de vente</h2>
        <ol>
            <li>
                Le prestataire CODEheures (Sylvain Gagnot - CODEheures EIRL) désigne la personne physique qui propose ses services au
                client contre rémunérations.<br/>
                Le client désigne la personne physique et morale qui bénéficie des services du prestataire.
            </li>
            <li>
                Le client faisant appel aux services de CODEheures reconnaît avoir pris connaissance et accepter
                sans réserve les conditions générales de vente suivantes, ainsi que les mises en garde concernant les
                lois de la propriété intellectuelle. L'acceptation du devis ou l'achat direct de crédit(s) horaire
                sont soumis à l'acceptation des présentes conditions.
            </li>
        </ol>
        <h2 class="fa"><i class="fa fa-square-o"></i> Article 2: Types de prestations</h2>
        <ol>
            <li>
                Les prestations sur devis: <br/>
                CODEheure établi un devis pour toute prestation. Ce devis mentionnera:
                <ul>
                    <li>
                        La désignation de la prestation et son tarif.
                    </li>
                    <li>
                        Un document de référence joint détaillant la prestation, les achats effectués par CODEheures au nom du client, les achats
                        que le client doit faire lui-même, les délais, les technologies choisies, et tout autre information jugées utile
                    </li>
                </ul>
            </li>
        </ol>
        <h2 class="fa"><i class="fa fa-square-o"></i> Article 3: Cahier des charges</h2>
        <ol>
            <li>
                Si le client fournit un cahier des charges pour la prestation de service, le devis sera effectué en
                fonction
                de celui-ci. Le prestataire se conforme au cahier des charges pour la réalisation de la prestation.
            </li>
            <li>
                Si aucun cahier des charges n'est fourni avant le début de la commande, ou si il ne comporte pas assez
                d'éléments explicites pour sa réalisation, la prestation est laissée à la libre interprétation du
                prestataire
                CODEheures.
                Si toutefois dans ce cas de figure, le client en refuse l'interprétation et la conception, la prestation
                effectuée sera due par le client et toute nouvelle prestation fera l'objet d'un nouveau devis.
            </li>
        </ol>
        <h2 class="fa"><i class="fa fa-square-o"></i> Article 4: Tarifs et prestations</h2>
        <ol>
            <li>
                Les prix stipulés sur le devis sont valables un mois à partir de la date d'émission de celui-ci. Ceux-ci
                restent fermes et non révisables à la commande si celle-ci intervient durant ce délai.
            </li>
            <li>
                Toute prestation ne figurant pas sur la commande fera l'objet d'un nouveau devis.
            </li>
        </ol>
        <h2 class="fa"><i class="fa fa-square-o"></i> Article 5: Délai de paiement</h2>
        <ol>
            <li>
                Sauf modification du délai de livraison en commun accord entre les deux parties, le solde du règlement
                de la facture doit se faire, au plus tard, 30 jours à compter de la date figurant sur ladite facture.
            </li>
            <li>
                Tout retard de paiement entrainera, à titre de pénalité de retard, l'application d'un intérêt égal à
                celui appliqué par la Banque Centrale Européenne à son opération de refinancement la plus récente,
                majoré de 10 points de pourcentage. (Soit 10,25 % (0,25 + 10) depuis le 13 novembre 2013). Une indemnité
                forfaitaire de 40 € est due au créancier pour frais de recouvrement, à l'occasion de tout retard de
                paiement (L. 441-6, I, 12).
            </li>
            <li>
                Le paiement sera effectué par chèque ou virement bancaire à l'adresse énoncée sur la facture.
            </li>
        </ol>
        <h2 class="fa"><i class="fa fa-square-o"></i> Article 6: Délai de livraison</h2>
        <ol>
            <li>
                Les délais de réalisations dépendant de l’efficacité des organismes sollicités ainsi que de la bonne volonté
                du client ne sont donnés qu’à titre indicatif. Aucune pénalité de retard ne peut être exigée par le client.
            </li>
        </ol>
        <h2 class="fa"><i class="fa fa-square-o"></i> Article 7: Modification de commande</h2>
        <ol>
            <li>
                Si le client souhaite une modification de sa commande, celui-ci s'engage à indiquer de façon claire et
                précise par email ou courrier les modifications qu'il souhaite pour sa commande.
            </li>
            <li>
                Prise en charge de la modification: un nouveau devis est emis et le fonctionnement est le même que pour
                un devis initial.
            </li>
        </ol>
        <h2 class="fa"><i class="fa fa-square-o"></i> Article 8: Propriété intellectuelle</h2>
        <ol>
            <li>
                Toutes créations et réalisations demeure la propriété entière et exclusive du prestataire CODEheures
                tant que la totalité des factures émises par le prestataire n'ont pas été honorées. Ceci inclut les
                avenants au contrat, les retards de paiement et autres frais induits par ladite commande.
            </li>
            <li>
                Le client devra s'acquitter du règlement de la facture de la commande pour devenir propriétaire des
                droits de diffusions cédés par le prestataire et pour la durée illimitée.
            </li>
        </ol>
        <h2 class="fa"><i class="fa fa-square-o"></i> Article 9: Cessions de droits</h2>
        <ol>
            <li>
                Selon l'article L.121-1 à L.121-9 du Code français de la propriété intellectuelle, il est défini que le
                droit moral d'une création (comprenant droit de divulgation, droit au respect de l'œuvre et droit au
                retrait) est attaché à son créateur de manière perpétuelle et imprescriptible.
            </li>
            <li>
                Ainsi ne sont cédés au diffuseur que les droits patrimoniaux correspondant à l'intitulé défini par le
                champ «cession de droits de représentation et de reproduction» et énoncés sur le présent contrat.
            </li>
            <li>
                Selon l'article L.121-1: Toute représentation ou reproduction intégrale ou partielle faite sans le
                consentement de l'auteur ou de ses ayants droit ou ayants cause est illicite. Il en est de même pour la
                traduction, l'adaptation ou la transformation, l'arrangement ou la reproduction par un art ou un procédé
                quelconque.
            </li>
        </ol>
        <h2 class="fa"><i class="fa fa-square-o"></i> Article 10: Mentions commerciales et droit de publicité</h2>
        <ol>
            <li>
                Le prestataire se réserve le droit d'ajouter un lien commercial CODEheures sur les sites web créés.
            </li>
        </ol>
        <h2 class="fa"><i class="fa fa-square-o"></i> Article 11: Litiges</h2>
        <ol>
            <li>
                La responsabilité du prestataire ne pourra être mise en cause si la non-exécution de la
                prestation découle d'un cas de force majeure.
            </li>
            <li>
                Tout litige relatif à l'interprétation et à l'exécution des présentes conditions générales de vente est
                soumis au droit français. &Agrave; défaut de conciliation amiable, le litige pourra être porté devant un
                tribunal compétent.
            </li>
        </ol>
    </div>
@endsection

@section('script')@endsection