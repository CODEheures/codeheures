<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordRequest;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function sendResetResponse($response)
    {
        return redirect(route('home'))
            ->with('success', 'Votre mot de passe est réinitialisé');
    }

    public function resetTwo(PasswordRequest $request)
    {
        try {
            $user = User::findOrFail($request->userId);
            if ($user && $request->token == $user->confirmation_token) {
                $user->confirmed = true;
                $user->confirmation_token = '';
                $user->new_create_by_admin = false;
                $user->password = bcrypt($request->password);
                $user->save();
                auth()->login($user);
                return redirect(route('customer.quotation.index'))->with('success', 'Bienvenue sur CODEheures! Votre devis est disponible ci-dessous.');
            } else {
                throw new ModelNotFoundException('');
            }
        } catch(ModelNotFoundException $e) {
            return redirect(route('home'))->with('error', trans('Le lien de confirmation est invalide'));
        }
    }
}
