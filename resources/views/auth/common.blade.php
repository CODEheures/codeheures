@extends('default')

@section('title')
    CODEheures | Espace Client
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