<img src="{{  asset('css/images/codeheures.svg') }}" width="300px" height="auto">
<h3>Félicitation {{ $user->name }}!</h3>

<p>Votre compte est créé.
Pour finaliser votre inscription merci de cliquer le lien suivant:

<a href="{{ route('account.confirm', ['id' => $user->id, 'token' => $user->confirmation_token]) }}" style="color: #3880aa;">lien de confirmation</a>

A tout de suite!</p>
@include('emails/footer/html')