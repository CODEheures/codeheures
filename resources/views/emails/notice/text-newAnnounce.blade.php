Une nouvelle annonce de {{ $user->name }}

Validez la nouvelle annonce en visitant l'addresse suivante

    {{ route('announce.show', ['id' => $announce->id]) }}

    A tout de suite!