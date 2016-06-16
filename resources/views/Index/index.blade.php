@extends('default')

@section('title')
CODEheures | Accueil
@endsection

@section('css')
    @parent
    @include('plugins.inputEffect.css')
@endsection

@section('navbar')
    @include('navbar.index')
@endsection

@section('header')

    <header id="accueil">
        <div class="bg-cover">
            <div class="header-content container">
                <h1><span class="code">CODE</span><span class="heures">heures</span> - SITES WEB</h1>
                <h2 class="presentation">Ma philosophie: proposer des tarifs plafonnés et <strong>vous recréditer</strong> si je fais mieux.</h2>
                <p>Programmeur WEB indépendant, j'interviens pour toute création et maintenance de site web et d'application mobile. <br />
                    <a href="{{ route('demo') }}" class="">Visitez l'espace client de démonstration</a> et retrouvez-y tous mes tarifs en forfaits plafonnés.</p>
                <div class="header-btn">
                    <a href="#prestations" class="btn btn-transparent">En savoir plus</a>
                    <a href="#contact" class="btn btn-yellow">Me contacter</a>
                </div>
            </div>
            <div class="scroll-down">
                <a href="#prestations"><i class="ion-chevron-down"></i></a>
            </div>
        </div>
    </header>
@endsection

@section('main')
    <div class="main container" id="main">
        <!-- section générale -->
        <section id="generale">
            <h1>Prestations et </h1>
            <article>
                <div class="card">
                    <img src="{{ asset('css/images/card2.png') }}" alt="mon image">
                    <div class="card_description">
                        <p>
                            mises à jour<br />
                            dépannages<br />
                            modération<br/>
                        </p>
                        <a class="btn btn-transparent" href="{{ route('demo') }}">En savoir plus</a>
                    </div>
                </div>
            </article>

            <article>
                <div class="digest">
                    <ul>
                        <li><hr/></li>
                        <li><i class="ion-ios-compose-outline"> </i><span>Le contenu de votre site a besoin d'être mis à jour?</span></li>
                        <li><hr/></li>
                        <li><i class="ion-ios-settings"> </i><span>Votre site web présente un problème de fonctionnement?</span></li>
                        <li><hr/></li>
                        <li><i class="ion-ios-people-outline"> </i><span>Vous souhaitez déléguer la modération de votre site web ou de vos pages sociales?</span></li>
                        <li><hr/></li>
                    </ul>
                    <div class="clear"></div>
                </div>
            </article>
            <div class="clear"></div>
            <footer>
                <p>
                    Que vos besoins en webmastering soient ponctuels ou récurrents, vous bénéficierez d'un système de suivi de votre consommation horaire. Accedez à la démonstration en visitant l'espace client de démonstration.
                </p>
                <a href="{{ route('demo') }}" class="btn btn-yellow2">Espace client de démonstration & tarifs</a>
            </footer>
        </section>

        <!-- section webmastering -->
        <section id="prestations">
            <h1>Maintenance site web: reportez vos heures non consommées</h1>
            <article>
                <div class="card">
                    <img src="{{ asset('css/images/card2.png') }}" alt="mon image">
                    <div class="card_description">
                        <p>
                            mises à jour<br />
                            dépannages<br />
                            modération<br/>
                        </p>
                        <a class="btn btn-transparent" href="{{ route('demo') }}">En savoir plus</a>
                    </div>
                </div>
            </article>

            <article>
                <div class="digest">
                    <ul>
                        <li><hr/></li>
                        <li><i class="ion-ios-compose-outline"> </i><span>Le contenu de votre site a besoin d'être mis à jour?</span></li>
                        <li><hr/></li>
                        <li><i class="ion-ios-settings"> </i><span>Votre site web présente un problème de fonctionnement?</span></li>
                        <li><hr/></li>
                        <li><i class="ion-ios-people-outline"> </i><span>Vous souhaitez déléguer la modération de votre site web ou de vos pages sociales?</span></li>
                        <li><hr/></li>
                    </ul>
                    <div class="clear"></div>
                </div>
            </article>
            <div class="clear"></div>
            <footer>
                <p>
                    Que vos besoins en webmastering soient ponctuels ou récurrents, vous bénéficierez d'un système de suivi de votre consommation horaire. Accedez à la démonstration en visitant l'espace client de démonstration.
                </p>
                <a href="{{ route('demo') }}" class="btn btn-yellow2">Espace client de démonstration & tarifs</a>
            </footer>
        </section>


        <!-- section integration -->
        <section>
            <h1>Intégrations Sites Web</h1>
            <article class="cards">
                <div class="card">
                    <img src="{{ asset('css/images/card1.png') }}" alt="mon image">
                    <div class="card_description">
                        <p>
                            vitrine<br />
                            e-commerce<br />
                            professionnel<br />
                        </p>
                        <a class="btn btn-transparent" href="#">En savoir plus</a>
                    </div>
                </div>
            </article>
            <article class="digests">
                <div class="digest">
                    <ul>
                        <li><hr/></li>
                        <li><i class="ion-ios-lightbulb-outline"> </i><span>vous avez une idée de site web, mais vous ne possedez pas les compétences requises pour sa réalisation?</span></li>
                        <li><hr/></li>
                        <li><i class="ion-ios-color-wand-outline"> </i><span>Vous possedez un site que vous souhaitez moderniser?</span></li>
                        <li><hr/></li>
                        <li><i class="ion-ios-gear-outline"> </i><span>Vous souhaitez ajouter de nouvelles fonctionnalités?</span></li>
                        <li><hr/></li>
                    </ul>
                    <div class="clear"></div>
                </div>
            </article>
            <div class="clear"></div>
            <footer>
                <p>
                    Professionnels, associations, comité d'entreprise, chaque cas est unique et les technologies disponibles sont nombreuses. Il convient donc d'adapter la réponse à chaque demande. Pour en savoir plus visitez le "lab" CODEheures.
                </p>
                <a href="#" class="btn btn-yellow2">Visitez le lab CODEheures</a>
            </footer>
        </section>

        <!-- section formulaire -->
        <section id="contact">
            <h1>Me contacter</h1>
            <p>
                Vous souhaitez des renseignements sur les prestations, un devis ou un avis sur un besoin en webmastering?
                <br /> Laissez-moi votre message avec votre adresse mail et eventuellement un numéro de téléphone par lequel je pourrai vous recontacter.
                <br />
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
    @include('plugins.inputEffect.scripts')
@endsection