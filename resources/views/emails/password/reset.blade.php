<!-- resources/views/emails/password.blade.php -->
<img src="{{  asset('css/images/codeheures.svg') }}" width="300px" height="auto">
<h1>{{ env('APP_NAME') }} : vous avez demandé la réinitialisation de votre mot de passe.</h1>
<p>Ouvrir ce lien pour réinitialiser votre mot de passe: <a href="{{ route('reset.email', ['token' => $token]) }}">{{ route('reset.email', ['token' => $token]) }}</a></p>
@include('emails/footer/html')