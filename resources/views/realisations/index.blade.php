@extends('layouts.common')

@section('css')
    @parent
    @include('plugins.twentytwenty.css')
@endsection

@section('title')
    Création site internet | Réalisations
@endsection

@section('description')
    Réalisations de sites Internet, sites mobiles, web applications, en région de Tours, 37. Spécialiste Laravel, Vue-Js
@endsection

@section('navbar')
    @include('navbar.index', ['navOptions' => ['shrinkForce' => true, 'active' => null]])
@endsection

@section('user.action')
    <div id="skills" class="skills">
        <img src="./css/images/skills/logos1b.png" alt="compétences floutées">
        <img src="./css/images/skills/logos2.png" alt="compétences floutées">
    </div>
    <h1>Réalisations Codeheures</h1>
    <h2 class="fa fa-desktop"> Site vitrine</h2>
    <article>
        <div class="realisations">
            <div class="realisation">
                <div class="header-realisation">
                    Rythme & Danses
                </div>
                <div class="body-realisation">
                    <img src="./css/images/realisations/rythmedanses.jpg" alt="image du site rythme & danses">
                    <p>Réalisé sous wix (montage vidéos de présentation réalisé par <a href="{{ route('home') }}">CODEheures</a>)
                    </p>
                    <div class="link">
                        <a target="_blank" href="http://rythmedanses.wix.com/rythmedanses" class="btn-yellow2-invert">Voir le site</a>
                    </div>
                </div>
            </div>
            <div class="realisation">
                <div class="header-realisation">
                    Sogeres Grand-Ouest
                </div>
                <div class="body-realisation">
                    <img src="./css/images/realisations/sogeresgo.jpg" alt="image du site sogeres grand ouest">
                    <p>Réalisé sous wix et maintenu par <a href="{{ route('home') }}">CODEheures</a> pour le C.E. Sogeres Grand Ouest
                    </p>
                    <div class="link">
                        <a target="_blank" href="http://www.ce-sogeres-grandouest.fr" class="btn-yellow2-invert">Voir le site</a>
                    </div>
                </div>
            </div>
            <div class="realisation">
                <div class="header-realisation">
                    Sogeres Ile de France
                </div>
                <div class="body-realisation">
                    <img src="./css/images/realisations/sogeresidf.jpg" alt="image du site sogeres ile de france">
                    <p>Réalisé sous wix et maintenu par <a href="{{ route('home') }}">CODEheures</a> pour le C.E. Sogeres Ile de France
                    </p>
                    <div class="link">
                        <a target="_blank" href="http://www.ce-sogeres-idf.fr" class="btn-yellow2-invert">Voir le site</a>
                    </div>
                </div>
            </div>
        </div>
    </article>
    <h2 class="fa fa-paint-brush"> Intégrations</h2>
    <article>
        <div class="realisations">
            <div class="realisation">
                <div class="header-realisation">
                    P.O.E.M.
                </div>
                <div class="body-realisation">
                    <img src="./css/images/realisations/poem.jpg" alt="image du site poem">
                    <p>Intégration html/css/js complete (connexion possible avec user+mot de passe vide)
                    </p>
                    <div class="link">
                        <a target="_blank" href="http://poem.codeheures.fr" class="btn-yellow2-invert">Voir le site</a>
                        <a target="_blank" href="http://poem.codeheures.fr/back.php" class="btn-yellow2-invert">back-office</a>
                    </div>
                </div>
            </div>
            <div class="realisation">
                <div class="header-realisation">
                    Fiche Produit + Menu Responsive
                </div>
                <div class="body-realisation">
                    <img src="./css/images/realisations/ficheproduit.jpg" alt="image du site sport et nature">
                    <p>Intégration d'une fiche produit et son menu en responsive design (mobile first). Technologie Flexbox.
                    </p>
                    <div class="link">
                        <a target="_blank" href="http://ficheproduit.codeheures.fr" class="btn-yellow2-invert">Voir le site</a>
                    </div>
                </div>
            </div>
            <div class="realisation">
                <div class="header-realisation">
                    Edania
                </div>
                <div class="body-realisation">
                    <img src="./css/images/realisations/edania.jpg" alt="image du site edania">
                    <p>Intégration d'un site pour animaux. Pictos par <a href="{{ route('home') }}">CODEheures</a>.
                    </p>
                    <div class="link">
                        <a target="_blank" href="http://edania.codeheures.fr/" class="btn-yellow2-invert">Voir le site</a>
                    </div>
                </div>
            </div>
        </div>
    </article>
    <h2 class="fa fa-flask"> Tests</h2>
    <article>
        <div class="realisations">
            <div class="realisation">
                <div class="header-realisation">
                    FRIGO
                </div>
                <div class="body-realisation">
                    <img src="./css/images/realisations/frigo.jpg" alt="image du site frigo">
                    <p>Developpement html/css/js/php complete d'une application pour gerer son frigo
                    </p>
                    <div class="link">
                        <a target="_blank" href="http://frigo.codeheures.fr" class="btn-yellow2-invert">Voir l'application</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="realisations">
            <div class="realisation">
                <div class="header-realisation">
                    Site du RIDI
                </div>
                <div class="body-realisation">
                    <img src="./css/images/realisations/ridi.jpg" alt="image du site ridi">
                    <p>Developpement d'un site avec CMS DRUPAL dans le cadre d'un travail avec l'université de strasbourg
                    </p>
                    <div class="link">
                        <a target="_blank" href="http://lpatc-cms.codeheures.fr" class="btn-yellow2-invert">Voir le site</a>
                    </div>
                </div>
            </div>
        </div>
    </article>
@endsection

@section('script')
    @include('plugins.twentytwenty.scripts')
@endsection