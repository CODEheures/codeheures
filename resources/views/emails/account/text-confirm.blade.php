Félicitation {{ $user->name }}!

Votre compte est créé.
Pour finaliser votre inscription merci de cliquer le lien suivant:

{{ route('account.confirm', ['id' => $user->id, 'token' => $user->confirmation_token]) }}

A tout de suite!