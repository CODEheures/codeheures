<nav class="navbar @yield('navbar_class_option')">
    <div class="container">
        <a href="{{ route('home') }}" class="navbar-logo animated bounceInLeft"><img src="{{ asset('/images/codeheures.svg') }}"/></a>
        <div class="hamburger"><i class="ion-navicon-round"></i></div>
        <div class="navbar-menu">
            @yield('links')
            @if(auth()->check())
                <a href="{{ route('logout') }}" aria-selected="false"
                   onclick="event.preventDefault(); document.getElementById('logout-form1').submit();">Déconnexion<div class="activeplus"></div></a>
            @endif
        </div>
        <form id="logout-form1" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
    </div>
</nav>