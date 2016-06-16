<h3>Félicitation {{ $user->name }}!</h3>

<p>Votre compte est créé.
Pour finaliser votre inscription merci de cliquer le lien suivant:

<a href="{{ route('account.confirm', ['id' => $user->id, 'token' => $user->confirmation_token]) }}">lien de confirmation</a>

A tout de suite!</p>