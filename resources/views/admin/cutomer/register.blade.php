@extends('auth.common')

@section('form')
<div class="form-title">
    <h1>Inscrire un client</h1>
</div>

{!! Form::open(['class' => 'form-horizontal', 'url' => route('admin.customer.create')]) !!}

    <div class="form-group">
        <span class="input input--fumi">
            {!! Form::text('name', null, ['class' => 'input__field input__field--fumi', 'placeholder' => 'jacksp24']) !!}
            <label for="name" class="input__label input__label--fumi">
                <i class="fa fa-fw fa-user icon icon--fumi"></i>
                <span class="input__label-content input__label-content--fumi">Nom d'utilisateur</span>
            </label>
        </span>
    </div>

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

    <div class="form-group">
            <span class="input input--fumi">
                {!! Form::text('phone', (auth()->user()->phone != null  ? '0'.auth()->user()->phone:null), ['class' => 'input__field input__field--fumi', 'placeholder' => 'Ex.: 0611223344']) !!}
                <label for="phone" class="input__label input__label--fumi">
                    <i class="fa fa-fw fa-mobile icon icon--fumi"></i>
                    <span class="input__label-content input__label-content--fumi">Numero de mobile</span>
                </label>
            </span>
    </div>

    <div class="form-group">
            <span class="input input--fumi">
                {!! Form::text('lastName', null, ['class' => 'input__field input__field--fumi', 'placeholder' => 'Ex.: dupont']) !!}
                <label for="lastName" class="input__label input__label--fumi">
                    <i class="fa fa-fw fa-tag icon icon--fumi"></i>
                    <span class="input__label-content input__label-content--fumi">Nom</span>
                </label>
            </span>
    </div>

    <div class="form-group">
                <span class="input input--fumi">
                    {!! Form::text('firstName', null, ['class' => 'input__field input__field--fumi', 'placeholder' => 'Ex.: sylvain']) !!}
                    <label for="firstName" class="input__label input__label--fumi">
                        <i class="fa fa-fw fa-tag icon icon--fumi"></i>
                        <span class="input__label-content input__label-content--fumi">Prénom</span>
                    </label>
                </span>
    </div>

    <div class="form-group">
            <span class="input input--fumi">
                {!! Form::text('enterprise', null, ['class' => 'input__field input__field--fumi', 'placeholder' => 'Ex.: SAS CODEheures']) !!}
                <label for="enterprise" class="input__label input__label--fumi">
                    <i class="fa fa-fw fa-industry icon icon--fumi"></i>
                    <span class="input__label-content input__label-content--fumi">Entreprise</span>
                </label>
            </span>
    </div>

    <div class="form-group">
            <span class="input input--fumi">
                {!! Form::text('siret', null, ['class' => 'input__field input__field--fumi', 'placeholder' => 'Ex.: 73282932000074']) !!}
                <label for="siret" class="input__label input__label--fumi">
                    <i class="fa fa-fw fa-info icon icon--fumi"></i>
                    <span class="input__label-content input__label-content--fumi">Siret</span>
                </label>
            </span>
    </div>

    <div class="form-group"></div>

    <div class="form-title">
        <p>Adresse de facturation</p>
    </div>
    <div class="form-group"></div>

    <div class="form-group">
                <span class="input input--fumi">
                    {!! Form::text('address', null, ['class' => 'input__field input__field--fumi', 'placeholder' => 'Ex.: 1 avenue des champs elysées']) !!}
                    <label for="address" class="input__label input__label--fumi">
                        <i class="fa fa-fw fa-street-view icon icon--fumi"></i>
                        <span class="input__label-content input__label-content--fumi">Adresse</span>
                    </label>
                </span>
    </div>

    <div class="form-group">
                <span class="input input--fumi">
                    {!! Form::text('complement', null, ['class' => 'input__field input__field--fumi', 'placeholder' => 'Ex.: BP 75006']) !!}
                    <label for="complement" class="input__label input__label--fumi">
                        <i class="fa fa-fw fa-plus icon icon--fumi"></i>
                        <span class="input__label-content input__label-content--fumi">Complément</span>
                    </label>
                </span>
    </div>

    <div class="form-group">
                <span class="input input--fumi">
                    {!! Form::text('zipCode', null, ['class' => 'input__field input__field--fumi', 'placeholder' => 'Ex.: 75006']) !!}
                    <label for="zipCode" class="input__label input__label--fumi">
                        <i class="fa fa-fw fa-map-marker icon icon--fumi"></i>
                        <span class="input__label-content input__label-content--fumi">Code postal</span>
                    </label>
                </span>
    </div>

    <div class="form-group">
                <span class="input input--fumi">
                    {!! Form::text('town', null, ['class' => 'input__field input__field--fumi', 'placeholder' => 'Ex.: Paris cedex 09']) !!}
                    <label for="town" class="input__label input__label--fumi">
                        <i class="fa fa-fw fa-map-signs icon icon--fumi"></i>
                        <span class="input__label-content input__label-content--fumi">Ville</span>
                    </label>
                </span>
    </div>

    <div class="form-submit">
        <div class="submit">
            <input type="submit" class="btn-yellow2" value="Inscrire" />
        </div>
    </div>

{!! Form::close() !!}
@endsection