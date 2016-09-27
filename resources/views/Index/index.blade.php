@extends('default')

@section('title')
    CODEheures | Accueil
@endsection

@section('css')
    @parent
    @include('plugins.inputEffect.css')
    @include('plugins.twentytwenty.css')
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
                    <div class="info">Démarrage dans:<div class="clock-down"></div></div>
                    <h2 class="presentation">
                        Ma philosophie: Vous proposer des outils de suivi et
                        <strong><a href="#prestations">reporter les heures</a></strong> non utilisées.
                    </h2>
                    <p>
                        Programmeur WEB indépendant, j'interviens pour toute création et maintenance de site web et
                        d'application mobile. <a href="{{ route('demo') }}" class="">Visitez l'espace client
                            de démonstration</a> et découvrer l'outil de suivi de vos investissements.
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

        <div class="tunnel" id="prestations">
            <!-- section générale -->
            <section>
                <h1><span>Un espace client</span>
                    <small>pour un suivi de vos investissements</small>
                </h1>
                <div class="video">
                    <div id="yt0"></div>
                </div>
                <footer>
                    <p>
                        Que vos besoins en webmastering soient ponctuels ou récurrents, vous bénéficierez d'un système de
                        suivi de votre consommation horaire. Accedez à la démonstration en visitant l'espace client de
                        démonstration.
                    </p>
                    <p class="exit">
                        <a href="{{ route('demo') }}" class="btn-yellow2">Espace client de démonstration & tarifs</a>
                        <a href="{{ route('realisations') }}" class="btn-yellow2">Voir les réalisations</a>
                    </p>
                </footer>
                <h2 class="fa fa-quote-left home">Combien coûte un site web?</h2>
                <div class="collapse">
                    <p>
                        Bonne question! <br/>
                        Saviez-vous qu'un bon webmaster ne code que 30% de son temps? Le reste du temps etant consacré à la
                        formation, la veille technologique, mais aussi à la gestion, à la prospection, à la relation
                        client...<br/>
                        <br/>Alors soyons bref, et concis. Comptez:
                    </p>
                    <ul class="circle">
                        <li>
                            Entre 1000€ et 2500€ pour site vitrine simple
                        </li>
                        <li>
                            Entre 2500€ et 8000€ (voir plus) pour un site e-commerce, une application web personnalisée, ou une application mobile simple
                        </li>
                        <li>
                            60€/heure pour toute intervention de mise à jour, maintenance
                        </li>
                    </ul>
                    <p>
                        Tout dépend du degré de personnalisation.<br />
                        <strong>C'est un investisement relativement important mais incontournable et très rentable.</strong>
                    </p>
                    <p class="center">
                <span class="solution">
                    Pour cela <a href="/" title="site codeheures.fr" class="a-invert">CODEheures.fr</a>
                    vous offre une solution innovante : <strong>le report des heures non utilisées</strong>
                </span>
                    </p>
                </div>
            </section>

            <!-- section integration -->
            <section>
                <h2 class="fa fa-quote-left home">Création de sites web et applications mobiles</h2>
                <div class="collapse">
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
                    <p class="center">
                <span class="solution">
                    <a href="/" title="site codeheures.fr" class="a-invert">CODEheures.fr</a>
                    ce sont des devis avec: <strong>report des heures non utilisées</strong></span>
                    </p>
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
                </div>
            </section>

            <!-- section webmastering -->
            <section>
                <h2 class="fa fa-quote-left home">Maintenance</h2>
                <div class="collapse">
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
                        </aside>
                    </article>

                    <p class="center">
                <span class="solution">
                    <a href="/" title="site codeheures.fr" class="a-invert">CODEheures.fr</a>
                    des tarifs pré-établis: <strong>pour une maîtrise de votre budget</strong></span>
                    </p>
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
                </div>
            </section>
        </div>


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
    <div id="skills" class="skills">
        <img src="./css/images/skills/logos1d.png" alt="compétences floutées">
        <img src="./css/images/skills/logos2.png" alt="compétences floutées">
    </div>
@endsection

@section('footer')
    @parent
    @include('footer.common')
@endsection

@section('script')
    @parent
    @include('plugins.countdown.scripts')
    @include('plugins.twentytwenty.scripts')
    @include('plugins.youtube.scripts')
@endsection