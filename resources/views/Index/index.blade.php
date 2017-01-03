@extends('default')

@section('title')
    <title>Création de sites internet et sites mobiles à Tours</title>
@endsection

@section('description')
    <meta name="description" content="Développeur indépendant pour la création de sites internet, sites mobiles, applications web, en région de Tours, 37.">
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
                    <h1>CREATIONS DE SITES INTERNET</h1>
                    {{--<div class="info">Démarrage dans:<div class="clock-down"></div></div>--}}
                    <p class="presentation">
                        Les avantages de l'offre <a href="{{ route('home') }}" class="a-invert">CODEheures</a>:
                        <strong><a href="#prestations">Le report des heures</a></strong> non utilisées.
                    </p>
                    <h2 class="important">
                        Developpeur WEB indépendant, j'interviens pour toute création et maintenance de site internet et
                        d'application internet mobile. Sous traitance pour les agence web. Spécialiste <a href="https://laravel.com">Laravel</a> - <a href="https://vuejs.org">VueJS</a>
                    </h2>
                    <div class="header-btn">
                        <a href="#prestations" class="btn-transparent">En savoir plus</a>
                        <a href="{{ route('demo') }}" class="btn-yellow">Tester l'espace client</a>
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
                <h2 class="fa fa-quote-left home">Combien coûte un site internet?</h2>
                <div class="collapse">
                    <p>
                        Bonne question! <br/>
                        Saviez-vous qu'un bon créateur de sites internet ne code que 30% de son temps? Le reste du temps etant consacré à la
                        formation, la veille technologique, mais aussi à la gestion, à la prospection, à la relation
                        client...<br/>
                        <br/>Alors soyons bref, et concis. Comptez:
                    </p>
                    <ul class="circle">
                        <li>
                            Entre 1000€ et 2500€ pour la création d'un site vitrine simple
                        </li>
                        <li>
                            Entre 2500€ et 8000€ (voir plus) pour le developpement d'un site e-commerce ou d'une application internet mobile personnalisée
                        </li>
                        <li>
                            60€/heure pour toute intervention de mise à jour, débugage ou maintenance de site internet, application web mobile, de base de données...
                        </li>
                    </ul>
                    <p>
                        Tout dépend du degré de personnalisation.<br />
                        <strong>La création d'un site internet est un investisement relativement important mais incontournable et très rentable.</strong>
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
                <h2 class="fa fa-quote-left home">Création de sites internet et applications mobiles</h2>
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
                                <li><i class="ion-ios-lightbulb-outline"> </i><span>vous avez une idée de création de site internet, mais vous ne possedez pas les compétences requises pour sa réalisation?</span>
                                </li>
                                <li>
                                    <hr/>
                                </li>
                                <li><i class="ion-ios-color-wand-outline"> </i><span>Vous possedez un site internet que vous souhaitez moderniser?</span>
                                </li>
                                <li>
                                    <hr/>
                                </li>
                                <li><i class="ion-ios-gear-outline"> </i><span>Vous souhaitez ajouter de nouvelles fonctionnalités à votre site internet?</span>
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
                <h2 class="fa fa-quote-left home">Maintenance de votre site internet</h2>
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
                                <li><i class="ion-ios-compose-outline"> </i><span>Le contenu de votre site internet a besoin d'être mis à jour?</span>
                                </li>
                                <li>
                                    <hr/>
                                </li>
                                <li><i class="ion-ios-settings"> </i><span>Votre site internet présente un problème de fonctionnement?</span>
                                </li>
                                <li>
                                    <hr/>
                                </li>
                                <li><i class="ion-ios-people-outline"> </i><span>Vous souhaitez déléguer la modération de votre site internet ou de vos pages sociales?</span>
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
    @include('plugins.intersectionObserver.scripts')
    {{--@include('plugins.countdown.scripts')--}}
    @include('plugins.twentytwenty.scripts')
    @include('plugins.youtube.scripts')
@endsection