<nav class="navbar @yield('navbar_class_option')">
    <div class="container">
        <a href="{{ route('home') }}" class="navbar-logo animated bounceInLeft"><img src="{{ asset('/images/codeheures.svg') }}"/></a>
        <div class="hamburger"><i class="ion-navicon-round"></i></div>
        <div class="navbar-menu">
            @yield('links')
        </div>
    </div>
</nav>