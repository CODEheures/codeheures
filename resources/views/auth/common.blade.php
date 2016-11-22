@extends('default')

@section('meta-index')
    <meta name="robots" content="nofollow">
@endsection

@section('title')
    Création de sites web | Espace Client
@endsection

@section('description')
    Inscrivez-vous pour bénéficier de tous les avantages lors de la création ou de la maintenance de votre site internet.
@endsection

@section('css')
    @parent
    @include('plugins.inputEffect.css')
@endsection

@section('navbar')
    @include('navbar.index', ['navOptions' => ['shrinkForce' => true, 'active' => 'customer']])
@endsection


@section('main')
    <div class="main container" id="main">
        <!-- section formulaire -->
        <section id="client">
               @yield('form')
        </section>
    </div>
@endsection

@section('footer')
    @parent
    @include('footer.common')
@endsection

@section('script')
    @parent

@endsection