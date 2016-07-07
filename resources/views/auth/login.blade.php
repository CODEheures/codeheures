@extends('auth.common')

@section('form')
<div class="form-title">
    <h1>Se connecter</h1>
    <a href="{{ route('register') }}" class="btn-yellow2">Inscription</a>
</div>
{!! Form::open(['class' => 'form-horizontal', 'url' => route('login.post')]) !!}

    <div class="form-group">
        <span class="input input--fumi">
            {!! Form::text('name', null, ['class' => 'input__field input__field--fumi', 'placeholder' => 'jacksp24']) !!}
            <label for="name" class="input__label input__label--fumi">
                <i class="fa fa-fw fa-user icon icon--fumi"></i>
                <span class="input__label-content input__label-content--fumi">Pseudo ou email</span>
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
    </div>
{!! Form::close() !!}
@endsection