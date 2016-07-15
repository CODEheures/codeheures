<!-- resources/views/emails/password.blade.php -->
{{ env('APP_NAME') }} : vous avez demandé la réinitialisation de votre mot de passe.
Ouvrir ce lien pour réinitialiser votre mot de passe: {{ route('reset.email', ['token' => $token]) }}