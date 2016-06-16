@extends('auth.common')

@section('form')
<div class="form-title">
    <h1>Réinitialisation du mot de passe</h1>
    <p>Un nouveau mot de passe vous sera renvoyé sur votre email</p>
</div>

{!! Form::open(['class' => 'form-horizontal', 'url' => route('reset.post')]) !!}

    <div class="form-group">
        <span class="input input--fumi">
            {!! Form::email('email', null, ['class' => 'input__field input__field--fumi', 'placeholder'=>'jack.sparrow@pearl.bl']) !!}
            <label for="email" class="input__label input__label--fumi">
                <i class="fa fa-fw fa-envelope icon icon--fumi"></i>
                <span class="input__label-content input__label-content--fumi">Email</span>
            </label>
        </span>
    </div>

    <div class="form-submit">
        <div class="submit">
            <input type="submit" class="btn btn-yellow2" value="Réinitialiser" />
        </div>
    </div>
{!! Form::close() !!}
@endsection