<img src="{{  asset('css/images/codeheures.svg') }}" width="300px" height="auto">
<h1>Vous avez un message</h1>

<ol>
@forelse($vars as $var)
    <li>{{ $var }}</li>
@empty
    <li>Aucune variable</li>
@endforelse
</ol>
@include('emails/footer/html')