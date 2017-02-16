<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="{{ \Illuminate\Support\Facades\App::getLocale() }}" lang="{{ \Illuminate\Support\Facades\App::getLocale() }}">
<head>
    <meta charset="UTF-8">
    <link rel="canonical" href="{{ \Illuminate\Support\Facades\Request::getFacadeRoot()->url() }}" >
    @yield('title')
    @yield('description')
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    @yield('meta-index')
    <link href="https://plus.google.com/103779204092913658859" rel="publisher" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="google-site-verification" content="SOhQHlo2EkGzHyFGOdWB3ih7ydb7CdaRg92y606qEkU" >
    <meta property="og:site_name" content="CODEheures">
    <meta property="og:title" content="Développeur WEB indépendant">
    <meta property="og:description" content="Avec CODEheures je vous propose des Devis et Tarifs intégrant une solution de report des heures non utilisées.">
    <meta property="og:image" content="{{ asset('/images/codeheures_thumbnail.jpg') }}">
    <meta property="og:url" content="{{ route('home') }}">
    <meta property="og:type" content="website">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon-32x32.png') }}" sizes="32x32">
    <link rel="icon" type="image/png" href="{{ asset('favicon-16x16.png') }}" sizes="16x16">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <link rel="mask-icon" href="{{ asset('safari-pinned-tab.svg') }}" color="#da713b">
    <meta name="theme-color" content="#ffffff">
    @yield('css')
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,800,400,600|Arvo:700|Flamenco:300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="{{ mix('css/ionicons.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ mix('css/font-awesome.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ mix('css/vendor.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ mix('css/app.css') }}">
    <script>
        window.destockShareVar={
            'serviceWorkerScope': '/sw.js',
        };
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register(destockShareVar.serviceWorkerScope).then(function(reg) {
                if(reg.installing) {} else if(reg.waiting) {} else if(reg.active) {}
            });
        } else {}
    </script>
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
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-47714622-2', 'auto');
        ga('send', 'pageview');

    </script>
    <script src="{{ mix('js/app.js') }}"></script>
    @yield('script')
</body>
</html>
