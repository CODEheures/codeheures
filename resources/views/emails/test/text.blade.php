Vous avez un message
==============================================
@forelse($vars as $var)
    {{ $var }}
@empty
    Aucune variable
@endforelse