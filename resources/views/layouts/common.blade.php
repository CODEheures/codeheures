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