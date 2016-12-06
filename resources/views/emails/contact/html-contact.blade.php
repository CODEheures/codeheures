<img src="{{  asset('css/images/codeheures.svg') }}" width="300px" height="auto">
<h3>{{ $data['email'] }} vous a laissé le message suivant:</h3>

<p>{{ $data['content'] }}</p>
@include('emails/footer/html')