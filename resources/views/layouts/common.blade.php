@extends('default')

@section('css')@endsection

@section('title')
    <title>Création de sites internet et sites mobiles | Espace Client</title>
@endsection

@section('description')
    <meta name="description" content="Developpeur indépendant pour la création de sites Internet, sites mobiles, web applications, en région de Tours, 37.">
@endsection

@section('navbar')@endsection


@section('main')
    <div class="main container" id="main">
        <!-- section formulaire -->
        @if(auth()->check() && auth()->user()->isDemo)
        <a href="{{ route('customer.demoToRegister') }}" class="registration"><i class="ion-person-add"></i>S'inscrire sur {{ env('APP_NAME') }}</a>
        @endif
        @if(auth()->check() && auth()->user()->role == 'admin')
            <a href="{{ route('admin.resetDemo') }}" class="registration"><i class="ion-loop"></i>Reset du compte démo</a>
        @endif
        <section id="user">
            @yield('user.action')
        </section>
    </div>
@endsection

@section('footer')
    @parent
    @include('footer.common')
@endsection

@section('script')@endsection