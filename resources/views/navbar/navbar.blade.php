<nav class="navbar @yield('navbar_class_option')">
    <div class="container">
        <a href="{{ route('home') }}" class="navbar-logo animated bounceInLeft"><img src="{{ asset('css/images/codeheures.svg') }}"/></a>
        <div class="hamburger invisible"><i class="ion-navicon-round"></i></div>
        <div class="navbar-menu">
            @yield('links')
            @if(auth()->check())
                <a href="{{ route('logout') }}">Déconnexion</a>
            @endif
        </div>
    </div>
</nav>