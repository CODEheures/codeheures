<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;


class SocialiteController extends Controller
{

    use RegistersUsers;
    use CreateUser;

    private $isNewOauthUser = false;
    private $request;
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->middleware('guest');
        $this->request = $request;
    }

    /**
     * Redirect the user to the Facebook authentication page.
     *
     * @return Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return Response
     */
    public function handleProviderCallback($provider)
    {
        try {
            $user = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect(route('login'))->withErrors('Probleme de connexion avec ' . $provider);
        }

        $authUser = $this->findOrCreateUser($user, $provider);
        if(is_a($authUser, RedirectResponse::class)) {
            return $authUser;
        } else {
            Auth::login($authUser, true);

            if ($authUser->role == 'admin') {
                $route = route('admin.monitor.index');
            } else {
                $route = route('customer.monitor.index');
            }

            if($this->isNewOauthUser) {
                return redirect($route)
                    ->with('success', 'Bienvenu sur CODEheures '. auth()->user()->name . '. Merci de votre confiance. Vous pouvez desormais profiter de votre espace client' );
            } else {
                return redirect($route);
            }
        }
    }
}
