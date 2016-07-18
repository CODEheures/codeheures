@extends('auth.common')

@section('form')
<div class="form-title">
    <h1>Se connecter</h1>
    <a href="{{ route('register') }}" class="btn-yellow2">Inscription</a>
</div>
{!! Form::open(['class' => 'form-horizontal', 'url' => route('login.post')]) !!}

    <div class="form-group">
        <span class="input input--fumi">
            {!! Form::text('name', null, ['class' => 'input__field input__field--fumi', 'placeholder' => 'jacksp24@bl.pl']) !!}
            <label for="name" class="input__label input__label--fumi">
                <i class="fa fa-fw fa-user icon icon--fumi"></i>
                <span class="input__label-content input__label-content--fumi">email</span>
            </label>
        </span>
    </div>

    <div class="form-group password">
        <span class="input input--fumi">
            {!! Form::password('password', ['class' => 'input__field input__field--fumi', 'placeholder' => '********']) !!}
            <label for="name" class="input__label input__label--fumi">
                <i class="fa fa-fw fa-user icon icon--fumi"></i>
                <span class="input__label-content input__label-content--fumi">Mot de passe</span>
            </label>
        </span>
        <a href="{{ route('reset.request') }}">mot de passe oublié ?</a>
    </div>

    <div class="form-submit">
        <div class="submit">
            <input type="submit" class="btn-yellow2" value="Connexion" />
        </div>
        <div class="checkbox">
            <span>Se souvenir de moi</span>
            <div class="check-style3">
                {!! Form::checkbox('check',1, null, ['id'=>'remember']) !!}
                <label for="remember"></label>
            </div>
        </div>
        <div class="submit social">
            <a href="{{ route('social.login', ['provider' => 'facebook']) }}" class="btn-facebook-login">Se connecter avec Facebook</a>
            <a href="{{ route('social.login', ['provider' => 'google']) }}" class="btn-google-login">Se connecter avec Google</a>
            <a href="{{ route('social.login', ['provider' => 'twitter']) }}" class="btn-twitter-login">Se connecter avec Twitter</a>
            <a href="{{ route('social.login', ['provider' => 'github']) }}" class="btn-github-login">Se connecter avec Github</a>
        </div>
    </div>
{!! Form::close() !!}
@endsection