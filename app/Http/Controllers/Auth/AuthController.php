<?php

namespace App\Http\Controllers\Auth;

use App\Address;
use App\User;
use Exception;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    private $mailer;
    private $username = 'name';
    protected $redirectPath = '/';
    protected $routeUser = 'customer.monitor.index';
    protected $routeAdmin = 'admin.monitor.index';
    protected $redirectTo = '/';
    private $isNewOauthUser = false;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(Mailer $mailer)
    {
        $this->middleware('guest', ['except' => ['getLogout', 'accountConfirm']]);
        $this->mailer = $mailer;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => array('required', 'regex:/^[A-Za-z0-9_[:space:]]{3,255}$/'),
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {


        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
        $user->save();
        $this->addAdresses($user);

        $this->setNewToken($user, $this->mailer);

        return $user;
    }

    private function addAdresses($user) {
        $invoiceAddress = new Address();
        $invoiceAddress->type = 'invoice';
        $shippingAddress = new Address();
        $shippingAddress->type = 'shipping';
        $user->save();
        $user->addresses()->saveMany([$invoiceAddress,$shippingAddress]);
    }

    public static function setNewToken($user, Mailer $mailer) {
        //Chaine random du Token
        $token = str_random(60);

        $user->confirmed = false;
        $user->confirmation_token = $token;
        $user->save();

        //Envoi du mail de confirmation
       $mailer->send(['text' => 'emails.account.text-confirm', 'html' => 'emails.account.html-confirm'],compact('user'), function($message) use($user){
            $message->to($user->email);
            $message->subject('Confirmez votre compte ' . env('APP_NAME'));
        });
    }

    public function accountConfirm($id, $token){
        try {
            $user = User::findOrFail($id);
            if ($user->confirmed == true) {
                return redirect('/')->with('info','Votre compte est déjà validé');
            } elseif ($token == $user->confirmation_token) {
                $user->confirmed = true;
                $user->confirmation_token = '';
                $user->save();
                auth()->login($user);
                return redirect('/')->with('success','Félicitation, votre compte est maintenant validé');
            } else {
                throw new ModelNotFoundException('');
            }
        } catch(ModelNotFoundException $e) {
            return redirect('/')->with('error','Le lien de confirmation est invalide');
        }
    }

    public function postRegister(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        //creation du user
        $this->create($request->all());

        return redirect('/')->with('success', 'Votre compte est créé. Merci de le valider en cliquant le lien reçu à votre adresse email.');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {

        $this->validate($request, [
            $this->loginUsername() => 'required', 'password' => 'required',
        ]);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        //----------------OLD AUTENTICATE-------------------------------------//
        //$credentials = $this->getCredentials($request);

        //if (Auth::attempt($credentials, $request->has('remember'))) {
        //    return $this->handleUserWasAuthenticated($request, $throttles);
        //}
        //----------------OLD AUTENTICATE-------------------------------------//

        $user = User::where('email', $request->get('name'))->first();

        if ($user && !$user->confirmed) {
            return redirect($this->loginPath())
                ->withInput($request->only($this->loginUsername(), 'remember'))
                ->with('info', "Veuillez d'abord confirmer votre compte");
        }

        if ($user && $user->confirmed && Hash::check($request->get('password'), $user->password)) {
            if (auth()->login($user, $request->has('remember'))) {
                return $this->handleUserWasAuthenticated($request, $throttles);
            }

            if($user->role =='admin'){
                return redirect(route($this->routeAdmin));
            }
            return redirect(route($this->routeUser));
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if ($throttles) {
            $this->incrementLoginAttempts($request);
        }

        return redirect($this->loginPath())
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors([
                $this->loginUsername() => $this->getFailedLoginMessage(),
            ]);
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
        } catch (Exception $e) {
            return redirect(route('login'));
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
                    ->with('success', 'Bienvenu sur CODEheures '. auth()->user()->name . '. Merci de votre confiance. Vous pouvez desormais profiter de votre espace client');
            } else {
                return redirect($route);
            }
        }
    }

    /**
     * Return user if exists; create and return if doesn't
     *
     * @param $facebookUser
     * @return User
     */
    private function findOrCreateUser($user, $provider)
    {
        $providers = config('providers_login');
        if(in_array($provider, $providers)){
            $keyId = $provider.'_id';
            $authUser = User::where($keyId, $user->id)->first();
            if ($authUser){
                return $authUser;
            }

            if($user->email && $user->email != '') {
                $existEmail = User::where('email', '=' , $user->email)->first();
                if($existEmail) {
                    $refOauth = $existEmail->oAuthProvider($providers);
                    if($refOauth == '') {
                        $refOauth = 'un autre utilisateur';
                    }
                    return redirect(route('login'))->with('error', 'un email identique est enregistré sur un compte ouvert par ' . $refOauth);
                }
            }

            try {
                $newUser =  User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    $keyId => $user->id,
                    'avatar' => $user->avatar,
                    'confirmed' => true
                ]);
                $this->addAdresses($newUser);
                $this->isNewOauthUser = true;
                return $newUser;
            } catch (Exception $e) {
                return redirect(route('login'))->with('error', 'une erreur est survenue pendant votre inscription. Merci de contacter l\'administrateur du site');
            }
        } else {
            return redirect(route('login'))->with('error', 'une erreur est survenue pendant votre connexion/inscription. Merci de contacter l\'administrateur du site');
        }
    }
}
