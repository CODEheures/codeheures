<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="">
    <meta name="author" content="CODEheures | Sylvain Gagnot">
    <meta property="og:site_name" content="CODEheures"/>
    <meta property="og:title" content="Développeur WEB indépendant"/>
    <meta property="og:description" content="CODEheures propose une solution innovante: les Devis et Tarifs BackTime. Vos heures non consommées seront reportées."/>
    <meta property="og:image" content="{{ asset('css/images/codeheures_thumbnail.jpg') }}">
    <meta property="og:url" content="{{ route('home') }}">
    <meta property="og:type" content="website"/>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon-32x32.png') }}" sizes="32x32">
    <link rel="icon" type="image/png" href="{{ asset('favicon-16x16.png') }}" sizes="16x16">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <link rel="mask-icon" href="{{ asset('safari-pinned-tab.svg') }}" color="#da713b">
    <meta name="theme-color" content="#ffffff">
    <title>@yield('title')</title>
    @yield('css')
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,800,400,600|Arvo:700|Flamenco:300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.min.css') }}">
</head>
<body>

@yield('navbar')


@include('flash')
@include('error')


@yield('header')

@yield('main')
    <div class="cookie_container"></div>
    <footer>
        @yield('footer')
    </footer>
    <script src="{{ asset('js/jquery-3.1.0.min.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="{{ asset('js/cookieconsent.min.js') }}"></script>
    <script src="{{ asset('js/css.min.js') }}"></script>
    @yield('script')
</body>
</html>
