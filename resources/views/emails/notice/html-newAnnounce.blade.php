<h3>Une nouvelle annonce de {{ $user->name }}!</h3>

<p>Validez la nouvelle annonce en visitant le lien suivant

<a href="{{ route('announce.show', ['id' => $announce->id]) }}">lien de validation</a>

A tout de suite!</p>