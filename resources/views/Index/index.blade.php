@extends('default')

@section('title')
    CODEheures | Accueil
@endsection

@section('css')
    @parent
    @include('plugins.inputEffect.css')
@endsection

@section('navbar')
    @include('navbar.index', ['navOptions' => ['shrinkForce' => false, 'active' => 'home']])
@endsection

@section('header')
    <header id="accueil">
        <div class="bg-cover">
            <div class="container">
                <div class="header-content">
                    <h1><span class="code">CODE</span><span class="heures">heures</span> - SITES WEB</h1>
                    <h2 class="presentation">
                        Ma philosophie: proposer des tarifs/devis accréditifs en
                        <strong><a href="#prestations">reportant les heures</a></strong> non consommées.
                    </h2>
                    <p>
                        Programmeur WEB indépendant, j'interviens pour toute création et maintenance de site web et
                        d'application mobile. <a href="{{ route('demo') }}" class="">Visitez l'espace client
                            de démonstration</a> et retrouvez-y tous les tarifs accréditifs.
                    </p>
                    <div class="header-btn">
                        <a href="#prestations" class="btn-transparent">En savoir plus</a>
                        <a href="#contact" class="btn-yellow">Me contacter</a>
                    </div>
                </div>
                <div class="scroll-down">
                    <a href="#prestations"><i class="ion-chevron-down"></i></a>
                </div>
            </div>
        </div>
    </header>
@endsection

@section('main')
    <div class="main container" id="main">
        <!-- section générale -->
        <section id="prestations">
            <h1><span>Tarifs & Devis accréditifs</span>
                <small>pour une meilleure maîtrise de votre budget</small>
            </h1>
            <h2 class="fa fa-quote-left">Combien coûte un site web?</h2>
            <p>
                Bonne question! <br/>
                Saviez-vous qu'un bon webmaster ne code que 30% de son temps? Le reste du temps etant consacré à la
                formation, la veille technologique, mais aussi à la gestion, à la prospection, à la relation
                client...<br/>
                <br/>Alors soyons bref, et concis. Comptez à partir de:
            </p>
            <ul class="circle">
                <li>
                    1200€ pour site vitrine simple sans intervention d'un graphiste
                </li>
                <li>
                    4000€ pour un site e-commerce, une application web personnalisée, ou une application mobile simple
                </li>
                <li>
                    60€/heure pour toute intervention de mise à jour, maintenance
                </li>
            </ul>
            <p>
                <strong>C'est un investisement relativement important mais incontournable et très rentable.</strong>
            </p>
            <p class="center">
                <span class="solution">
                    Pour cela <a href="/" title="site codeheures.fr" class="a-invert">CODEheures.fr</a>
                    vous offre une solution innovante et gagnant/gagnant: <strong>les tarifs et devis accréditif</strong>
                </span>
            </p>
        </section>

        <!-- section webmastering -->
        <section>
            <h2 class="fa fa-quote-left">Qu'est-ce que le tarif accréditif?</h2>
            <h3>Maintenance site web: reportez vos heures non consommées</h3>
            <article>
                <div class="card">
                    <img src="{{ asset('css/images/card2.png') }}" alt="mon image">
                    <div class="card_description">
                        <p>
                            mises à jour<br/>
                            dépannages<br/>
                            modération<br/>
                        </p>
                        <a class="btn-transparent" href="{{ route('demo') }}">En savoir plus</a>
                    </div>
                </div>
                <aside class="digest">
                    <ul>
                        <li>
                            <hr/>
                        </li>
                        <li><i class="ion-ios-compose-outline"> </i><span>Le contenu de votre site a besoin d'être mis à jour?</span>
                        </li>
                        <li>
                            <hr/>
                        </li>
                        <li><i class="ion-ios-settings"> </i><span>Votre site web présente un problème de fonctionnement?</span>
                        </li>
                        <li>
                            <hr/>
                        </li>
                        <li><i class="ion-ios-people-outline"> </i><span>Vous souhaitez déléguer la modération de votre site web ou de vos pages sociales?</span>
                        </li>
                        <li>
                            <hr/>
                        </li>
                    </ul>
                    <div class="clear"></div>
                </aside>
            </article>
            <h4 class="space-top">Le principe du tarif accréditif se base sur 2 priorités</h4>
            <ol class="argument">
                <li>
                    Il est inutile et improductif de fournir un devis pour toutes les prestations récurrentes.
                </li>
                <li>
                    Le client doit être facturé au plus proche de la réalité du temps passé pour la prestation.
                </li>
            </ol>

            <p class="center">
                <span class="solution">
                    <a href="/" title="site codeheures.fr" class="a-invert">CODEheures.fr</a>
                    répond à ces 2 priorités par un mécanisme innovant: <strong>le tarif accréditif</strong></span>
            </p>
            <h4>Une grille de temps pré-établis + un report des minutes</h4>
            <ol class="argument">
                <li>
                    <strong>Une grille de temps pré-établis</strong> (=temps facturé) pour les prestations récurrentes. Exemple:
                    <div class="table">
                        <table class="grille-example">
                            <thead>
                            <tr>
                                <th>Prestation</th>
                                <th>Temps pré-établi</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Changer une image sur le site</td>
                                <td>20mn</td>
                            </tr>
                            <tr>
                                <td>Publier un article sur le site avec texte fourni</td>
                                <td>40mn</td>
                            </tr>
                            <tr>
                                <td>Mise à jour fiche produit</td>
                                <td>10mn</td>
                            </tr>
                            <tr>
                                <td>...</td>
                                <td>...</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </li>
                <li>
                    <strong>Un report des minutes</strong> lorsque le temps passé réel est inférieur au temps pré-établi. Exemple:
                    <div class="table">
                        <table class="report-example">
                            <thead>
                            <tr>
                                <th>Prestation</th>
                                <th>Temps pré-établi (=temps facturé)</th>
                                <th>Temps réalisé</th>
                                <th>Minutes reportées</th>
                                <th>à votre avantage</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Changer une image sur le site</td>
                                <td>20mn</td>
                                <td class="lost">32mn</td>
                                <td class="win">0mn</td>
                                <td class="win">12mn</td>
                            </tr>
                            <tr>
                                <td>Changer une image sur le site</td>
                                <td>20mn</td>
                                <td class="">12mn</td>
                                <td class="win">8mn</td>
                                <td class="win">8mn</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <p>Afin de rester transparent je mets à disposition sur <a
                                href="{{ route('customer.monitor.index')}}" title="espace client" class="a-invert">votre
                            compte client</a>:</p>
                    <ul class="circle">
                        <li>
                            La grille des temps pré-établis
                        </li>
                        <li>
                            Un graphique des consommations horaires facturées
                        </li>
                    </ul>
                </li>
            </ol>
            <h4>Vos avantages</h4>
            <ul class="advantage argument">
                <li>
                    <div class="top">
                        <i class="fa fa-2x fa-eur"></i>
                        <p>Vous connaissez à l'avance l'investissement maximal et maîtrisez completement votre budget.<br/>
                            La grille des temps pré-établis definit un plafond maximum consommé pour l'action engagée.</p>
                    </div>
                </li>
                <li>
                    <div class="top">
                        <i class="fa fa-2x fa-line-chart"></i>
                        <p>La grille des temps pré-établis est construite sur l'expérience moyenne d'un site.<br/>
                            Du simple fait que plus j'interviens sur votre site, plus grande est l'efficacité,
                            et votre fidélité vous amenera au fil du temps à voir le report des minutes important et
                            recurrent
                        </p>
                    </div>
                </li>
                <li>
                    <div class="top">
                        <i class="fa fa-2x fa-reply"></i>
                        <p>En cas d'insatisfaction ou de n'importe quelle autre cause, la possibilité sur simple demande
                            par mail de vous faire rembourser sans délai et sans condition le crédit d'heures restant
                            au prix d'achat.
                        </p>
                    </div>
                </li>
            </ul>
            <footer>
                <p>
                    Que vos besoins en webmastering soient ponctuels ou récurrents, vous bénéficierez d'un système de
                    suivi de votre consommation horaire. Accedez à la démonstration en visitant l'espace client de
                    démonstration.
                </p>
                <a href="{{ route('demo') }}" class="btn-yellow2">Espace client de démonstration & tarifs</a>
            </footer>
        </section>


        <!-- section integration -->
        <section>
            <h2 class="fa fa-quote-left">Qu'est-ce que le devis accréditif?</h2>
            <h3>Création de site web: un devis accréditif qui vous offre des heures de maintenance</h3>
            <article class="cards">
                <div class="card">
                    <img src="{{ asset('css/images/card1.png') }}" alt="mon image">
                    <div class="card_description">
                        <p>
                            vitrine<br/>
                            e-commerce<br/>
                            professionnel<br/>
                        </p>
                        <a class="btn-transparent" href="#">En savoir plus</a>
                    </div>
                </div>
                <aside class="digest">
                    <ul>
                        <li>
                            <hr/>
                        </li>
                        <li><i class="ion-ios-lightbulb-outline"> </i><span>vous avez une idée de site web, mais vous ne possedez pas les compétences requises pour sa réalisation?</span>
                        </li>
                        <li>
                            <hr/>
                        </li>
                        <li><i class="ion-ios-color-wand-outline"> </i><span>Vous possedez un site que vous souhaitez moderniser?</span>
                        </li>
                        <li>
                            <hr/>
                        </li>
                        <li><i class="ion-ios-gear-outline"> </i><span>Vous souhaitez ajouter de nouvelles fonctionnalités?</span>
                        </li>
                        <li>
                            <hr/>
                        </li>
                    </ul>
                    <div class="clear"></div>
                </aside>
            </article>
            <h4 class="space-top">Le principe du devis accréditif se base sur 2 constats</h4>
            <ol class="argument">
                <li>
                    Il est très difficile (pour ne pas dire impossible) de jauger au plus juste l'expression d'un besoin
                    dans le domaine du web. Le probleme etant que l'erreur de chiffrage peut aller dans les 2 sens.
                </li>
                <li>
                    Le webmaster va palier ce defaut soit en exagerant le tarif, soit en dépensant un temps inconsidéré
                    à la réalisation du devis qui se repercutera sur le tarif.
                </li>
            </ol>
            <p class="center">
                <span class="solution">
                    <a href="/" title="site codeheures.fr" class="a-invert">CODEheures.fr</a>
                    répond à ces 2 constats par un mécanisme innovant: <strong>le devis accréditif</strong></span>
            </p>
            <h4>Un devis en 2 sections + une transformation des heures non consommées en maintenance</h4>
            <ol class="argument">
                <li>
                    <strong>Le devis est établi en 2 sections</strong> pour une totale transparence:
                    <ul class="circle">
                        <li>les achats (maquettes, templates, plugs-ins, nom de domaine, hebergement...)</li>
                        <li>Un temps de travail estimé sur la base du besoin</li>
                    </ul>
                    <div class="clear"></div>
                </li>
                <li>
                    <strong>Le reliquat d'heures est transformé en heures de maintenance</strong> lorsque le developpement
                    du site se termine sans avoir consommer toutes les heures.
                    Afin de rester transparent je mets à disposition sur
                    <a href="{{ route('customer.monitor.index')}}" title="espace client" class="a-invert">
                        votre compte client</a>
                     un graphique des temps de developpement du site.
                </li>
            </ol>
            <h4>Vos avantages</h4>
            <ul class="advantage argument">
                <li>
                    <div class="top">
                        <i class="fa fa-2x fa-clock-o rot90"></i>
                        <p>
                            Vous avez l'assurance que la totalité du temps de travail estimé dans le devis sera converti.

                        </p>
                    </div>
                    <ul class="circle">
                        <li>Soit le temps de travail est surestimé et vous bénéficierai d'un report en heures de maintenance</li>
                        <li>Soit le temps de travail est sous-estimé et <a href="/" title="site codeheures.fr" class="a-invert">CODEheures.fr</a>
                            prendra à sa charge ce dépassement. </li>
                    </ul>
                </li>
                <li>
                    <div class="top">
                        <i class="fa fa-2x fa-rocket"></i>
                        <p>Un démarrage plus rapide du projet axé sur l'obtention concrète. Le temps gagné à l'élaboration
                            du devis est bénéfique pour le démarrage.
                        </p>
                    </div>
                </li>
                <li>
                    <div class="top">
                        <i class="fa fa-2x fa-magic"></i>
                        <p>La possibilité de transformer l'éventuel reliquat des heures en fonctionnalités,
                            en plug-ins, template supplémentaire...
                        </p>
                    </div>
                </li>
                <li>
                    <div class="top">
                        <i class="fa fa-2x fa-reply"></i>
                        <p>En cas d'insatisfaction ou de n'importe quelle autre cause, la possibilité sur simple demande
                            par mail de vous faire rembourser sans délai et sans condition le crédit d'heures restant
                            au prix d'achat.
                        </p>
                    </div>
                </li>
            </ul>
            <footer>
                <p>
                    Professionnels, associations, comité d'entreprise, chaque cas est unique et les technologies
                    disponibles sont nombreuses. Il convient donc d'adapter la réponse à chaque demande. Pour en savoir
                    plus visitez le "lab" CODEheures.
                </p>
                <a href="#" class="btn-yellow2">Voir les réalisations</a>
            </footer>
        </section>

        <!-- section formulaire -->
        <section id="contact">
            <h2>Me contacter</h2>
            <p>
                Vous souhaitez des renseignements sur les prestations, un devis ou un avis sur un besoin en
                webmastering?
                <br/> Laissez-moi votre message avec votre adresse mail et eventuellement un numéro de téléphone par
                lequel je pourrai vous recontacter.
                <br/>
            </p>
            @include('contact.form')
        </section>
    </div>
@endsection

@section('footer')
    @parent
    @include('footer.common')
@endsection

@section('script')
    @parent

@endsection