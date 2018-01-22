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
                <img id="lowResBackgound" style="display: none;" src="{{ asset('/images/2_low.jpg') }}" alt="">
                <img id="higtResBackgound" style="display: none;" src="{{ asset('/images/2.jpg') }}" alt="">
                <div class="header-content">
                    <h1>créations de sites internet</h1>
                    {{--<div class="info">Démarrage dans:<div class="clock-down"></div></div>--}}
                    <h2 class="important">
                        Développeur WEB freelance, spécialiste <a href="https://laravel.com" title="création de sites internet avec backend laravel" target="_blank">Laravel</a> et <a href="https://vuejs.org" title="développement de sites web avec frontend vuejs" target="_blank">VueJS</a>
                    </h2>
                    <p>Création et maintenance de sites internets. Sous-traitance pour les agences web.</p>
                    <div class="header-btn">
                        <a href="https://docs.google.com/forms/d/e/1FAIpQLScrk8x-0RMkt4xzhFYC0jiwbU_YNYElWBiosjyyItr7Nrb1BA/viewform" class="btn-transparent" title="devis pour votre création de sites internet développés avec laravel et vuejs à Tours" target="_blank">Demander un devis en 3mn</a>
                        <a href="{{ route('realisations') }}" class="btn-yellow" title="webmaster sites internets">Réalisations</a>
                    </div>
                </div>
                <div class="scroll-down">
                    <a href="#prestations" title="site développés avec laravel et vuejs à Tours"><span>En savoir plus</span><i class="ion-chevron-down"></i></a>
                </div>
            </div>
        </div>
    </header>
@endsection

@section('main')
    <div class="main container" id="main">

        <div class="tunnel" id="prestations">
            <!-- section générale -->
            {{--<section>--}}
                {{--<h2><span>Développeur de sites internet</span></h2>--}}
                {{--<div class="video">--}}
                    {{--<div id="yt0"></div>--}}
                {{--</div>--}}
                {{--<footer>--}}
                    {{--<p>--}}
                        {{--Que vous ayez besoin d'un développeur web pour la création d'un site vitrine, pour de la maintenance--}}
                        {{--ou une mise à jour sur une application web, pour de l'administration de nom de domaine ou--}}
                        {{--d'hebergement cliquez ci-dessous et demandez un devis en répondant à quelques questions en--}}
                        {{--moins de 3minutes.--}}
                    {{--</p>--}}
                    {{--<p class="exit">--}}
                        {{--<a href="{{ route('demo') }}" class="btn-yellow2" title="application web professionnelle de suivi client">Espace client de démonstration & tarifs</a>--}}
                        {{--<a href="https://docs.google.com/forms/d/e/1FAIpQLScrk8x-0RMkt4xzhFYC0jiwbU_YNYElWBiosjyyItr7Nrb1BA/viewform" class="btn-yellow2" title="obtenir un devis pour votre création de site internet" target="_blank">Demander un devis en 3mn</a>--}}
                    {{--</p>--}}
                {{--</footer>--}}
            {{--</section>--}}

            <!-- section integration -->
            <section>
                <h3 class="fa fa-quote-left home">Création de sites internet vitrine, commerce ou pro</h3>
                <div class="collapse">
                    <article class="cards">
                        <div class="card">
                            <img src="{{ asset('/images/card1.png') }}" alt="Développeur web internet avec laravel et vuejs à Tours 37">
                            <div class="card_description">
                                <p>
                                    vitrine<br/>
                                    e-commerce<br/>
                                    professionnel<br/>
                                </p>
                                <a href="{{ route('realisations') }}" class="btn-transparent" title="sites internet développés avec laravel et vuejs à Tours">Voir les réalisations</a>
                            </div>
                        </div>
                        <aside class="digest">
                            <ul>
                                <li>
                                    <hr/>
                                </li>
                                <li><i class="ion-ios-lightbulb-outline"> </i><span>vous avez une idée de création de site internet, mais vous ne possédez pas les compétences requises pour sa réalisation?</span>
                                </li>
                                <li>
                                    <hr/>
                                </li>
                                <li><i class="ion-ios-color-wand-outline"> </i><span>Vous possédez un site internet que vous souhaitez moderniser?</span>
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
                    <a href="/" title="site codeheures.fr. Agence web pour le développement de sites internet et sites mobiles à Tours 37." class="a-invert">CODEheures.fr</a>
                    c'est un savoir faire et des compétences <strong>au service du client</strong></span>
                    </p>
                    <h4>Mes priorités pour vous</h4>
                    <ul class="advantage argument">
                        <li>
                            <div class="top">
                                <i class="fa fa-2x fa-balance-scale"></i>
                                <p>Un juste prix calculé au plus proche de votre besoin.
                                </p>
                            </div>
                        </li>
                        <li>
                            <div class="top">
                                <i class="fa fa-2x fa-rocket"></i>
                                <p>Un démarrage rapide du projet axé sur l'obtention concrète.
                                </p>
                            </div>
                        </li>
                        <li>
                            <div class="top">
                                <i class="fa fa-2x fa-magic"></i>
                                <p>Une transformation de vos idées la plus précise possible en apparence, efficacité et ergonomie
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>
                <p class="center">
                    <a href="https://docs.google.com/forms/d/e/1FAIpQLScrk8x-0RMkt4xzhFYC0jiwbU_YNYElWBiosjyyItr7Nrb1BA/viewform" class="btn-yellow2" title="devis pour votre création de sites internet développés avec laravel et vuejs à Tours" target="_blank">Demander un devis en 3mn</a>
                </p>
            </section>

            <!-- section webmastering -->
            <section>
                <h3 class="fa fa-quote-left home">Maintenance de votre site internet</h3>
                <div class="collapse">
                    <article>
                        <div class="card">
                            <img src="{{ asset('/images/card2.png') }}" alt="maintenance de sites web php javascript et réseaux sociaux">
                            <div class="card_description">
                                <p>
                                    mises à jour<br/>
                                    dépannages<br/>
                                    modération<br/>
                                </p>
                                <!-- TODO revoir lien -->
                                <a href="https://docs.google.com/forms/d/e/1FAIpQLScrk8x-0RMkt4xzhFYC0jiwbU_YNYElWBiosjyyItr7Nrb1BA/viewform" class="btn-transparent" title="obtenir un devis pour votre création de site internet" target="_blank">Devis en 3mn</a>
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
                    <a href="/" title="codeheures.fr, developpeur freelance de sites internet, ecommerces et sites mobiles" class="a-invert">CODEheures.fr</a>
                    des prestations ponctuelles ou récurrentes en webmastering</span>
                    </p>
                    <h4>Mes priorités pour vous</h4>
                    <ul class="advantage argument">
                        <li>
                            <div class="top">
                                <i class="fa fa-2x fa-support"></i>
                                <p>Un support de qualité, rapide et efficace.</p>
                            </div>
                        </li>
                        <li>
                            <div class="top">
                                <i class="fa fa-2x fa-lock"></i>
                                <p>La confidentialité et la mise en sécurité de vos données</p>
                            </div>
                        </li>
                        <li>
                            <div class="top">
                                <i class="fa fa-2x fa-graduation-cap"></i>
                                <p>Une transmission totale des savoirs en cas de mutation du service</p>
                            </div>
                        </li>
                    </ul>
                </div>
                <p class="center">
                    <a href="https://docs.google.com/forms/d/e/1FAIpQLScrk8x-0RMkt4xzhFYC0jiwbU_YNYElWBiosjyyItr7Nrb1BA/viewform" class="btn-yellow2" title="devis pour votre création de sites internet développés avec laravel et vuejs à Tours" target="_blank">Demander un devis en 3mn</a>
                </p>
            </section>
        </div>

        <!-- Prix -->
        <section>
            <h3 class="fa fa-quote-left home">Combien coûte un site internet?</h3>
            <div class="collapse">
                <p>
                    Bonne question! <br/>
                    Un développeur de sites internet ne code que 30% de son temps. Le reste du temps est consacré à la
                    formation, la veille technologique, mais aussi à la gestion, à la prospection, à la relation
                    client...<br/>
                    <br/>Vous pouvez chiffrer le coût d'un site web:
                </p>
                <ul class="circle">
                    <li>
                        Entre 1000€ et 2500€ pour la création d'un site web vitrine simple
                    </li>
                    <li>
                        Entre 2500€ et 8000€ (voir plus) pour le développement d'un site e-commerce ou d'une application internet mobile personnalisée
                    </li>
                </ul>
                <p>
                    Cela dépend bien entendu du degré de personnalisation et de la compléxité du projet.<br />
                    <strong>La création d'un site internet est un investissement relativement important mais incontournable et très rentable.</strong>
                </p>
                <p class="center">
                <span class="solution">
                    Pour cela <a href="/" title="site codeheures.fr. Réalisation de sites web à Tours 37." class="a-invert">CODEheures.fr</a>
                    peut vous proposer plusieurs type de solutions.
                </span>
                </p>
                <p class="center">
                    <a href="https://docs.google.com/forms/d/e/1FAIpQLScrk8x-0RMkt4xzhFYC0jiwbU_YNYElWBiosjyyItr7Nrb1BA/viewform" class="btn-yellow2" title="devis pour votre création de sites internet développés avec laravel et vuejs à Tours" target="_blank">Demander un devis en 3mn</a>
                </p>
            </div>
        </section>
        <!-- section formulaire -->
        <section id="contact">
            <h3>Me contacter</h3>
            <p>
                Vous souhaitez des renseignements sur les prestations, un devis ou un avis sur un besoin en
                webmastering?
                <br/> Laissez-moi votre message avec votre adresse mail et éventuellement un numéro de téléphone par
                lequel je pourrai vous recontacter.
                <br/>
            </p>
            @include('contact.form')
        </section>
    </div>
    <div id="skills" class="skills">
        <img src=".//images/skills/logos1d.png" alt="développeur web à tours laravel vuejs">
        <img src=".//images/skills/logos2.png" alt="creation site internet à tours avec laravel vuejs">
    </div>
@endsection

@section('footer')
    @parent
    @include('footer.common')
@endsection

@section('script')
    @parent
    @include('plugins.intersectionObserver.scripts')
    @include('plugins.twentytwenty.scripts')
    @include('plugins.youtube.scripts')
@endsection