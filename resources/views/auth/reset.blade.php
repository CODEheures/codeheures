@extends('auth.common')

@section('form')
<div class="form-title">
    <h1>Réinitialisation de votre mot de passe</h1>
</div>
{!! Form::open(['class' => 'form-horizontal', 'url' => route('reset.finish')]) !!}

    <input type="hidden" name="token" value="{{ $token }}">

    <div class="form-group">
            <span class="input input--fumi">
                {!! Form::email('email', null, ['class' => 'input__field input__field--fumi', 'placeholder' => 'jack.sparrow@pearl.bl']) !!}
                <label for="email" class="input__label input__label--fumi">
                    <i class="fa fa-fw fa-envelope icon icon--fumi"></i>
                    <span class="input__label-content input__label-content--fumi">Email</span>
                </label>
            </span>
    </div>

    <div class="form-group">
            <span class="input input--fumi">
                {!! Form::password('password', ['class' => 'input__field input__field--fumi','placeholder' => '********']) !!}
                <label for="password" class="input__label input__label--fumi">
                    <i class="fa fa-fw fa-envelope icon icon--fumi"></i>
                    <span class="input__label-content input__label-content--fumi">Mot de passe</span>
                </label>
            </span>
    </div>

    <div class="form-group">
            <span class="input input--fumi">
                {!! Form::password('password_confirmation', ['class' => 'input__field input__field--fumi','placeholder' => '********']) !!}
                <label for="password_confirmation" class="input__label input__label--fumi">
                    <i class="fa fa-fw fa-envelope icon icon--fumi"></i>
                    <span class="input__label-content input__label-content--fumi">Confirmation mot de passe</span>
                </label>
            </span>
    </div>

    <div class="form-submit">
        <div class="submit">
            <input type="submit" class="btn-yellow2" value="S'inscrire" />
        </div>
    </div>
{!! Form::close() !!}
@endsection