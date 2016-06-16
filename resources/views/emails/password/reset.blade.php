<!-- resources/views/emails/password.blade.php -->

Ouvrir ce lien pour réinitialiser votre mot de passe: {{ route('reset.email', ['token' => $token]) }}