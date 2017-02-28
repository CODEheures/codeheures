<?php
/**
 * Created by PhpStorm.
 * User: Papoun
 * Date: 04/10/2016
 * Time: 10:12
 */

namespace App\Http\Controllers\Auth;


use App\Address;
use App\Notifications\SendToken;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

trait CreateUser {


    public static function setNewToken($user) {
        //Chaine random du Token
        $token = str_random(60);

        $user->confirmed = false;
        $user->confirmation_token = $token;
        $user->save();

        self::sendToken($user);
    }

    public static function sendToken($user) {
        //Envoi du mail de confirmation
        $user->notify(new SendToken());
    }

    public function resendToken(){
        $user = auth()->user();
        if(!$user->confirmed) {
            self::sendToken($user);
        }
        return redirect()->back()->with('info', 'Le lien de confirmation de votre email vous a été renvoyé');
    }

    public function accountConfirm($id, $token){
        try {
            $user = User::findOrFail($id);
            if ($user->confirmed == true) {
                return redirect(route('home'))->with('info','Votre compte est déjà validé');
            } elseif ($token == $user->confirmation_token) {
                $user->confirmed = true;
                $user->confirmation_token = '';
                $user->save();
                auth()->login($user);
                return redirect(route('home'))->with('success', 'Félicitation, votre compte est maintenant validé');
            } else {
                throw new ModelNotFoundException('');
            }
        } catch(ModelNotFoundException $e) {
            return redirect(route('home'))->with('error', trans('Le lien de confirmation est invalide'));
        }
    }

    public function accountConfirmTwo($userId, $token){

        try {
            $user = User::findOrFail($userId);
            if($user->confirmed){
                return redirect(route('customer.quotation.index'));
            }
            if ($token == $user->confirmation_token) {
                $isProcessTwo = true;
                return view('auth.reset', compact('userId', 'token', 'isProcessTwo'));
            } else {
                throw new ModelNotFoundException('');
            }
        } catch(ModelNotFoundException $e) {
            return redirect(route('home'))->with('error', trans('Le lien de confirmation est invalide'));
        }
    }

    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
        $user->save();

        $this->addAdresses($user);

        self::setNewToken($user);

        return $user;
    }

    private function addAdresses(User $user) {
        $invoiceAddress = new Address();
        $invoiceAddress->type = 'invoice';
        $shippingAddress = new Address();
        $shippingAddress->type = 'shipping';
        $user->addresses()->saveMany([$invoiceAddress,$shippingAddress]);
    }

    protected function findOrCreateUser($user, $provider)
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
            } catch (\Exception $e) {
                return redirect(route('login'))->with('error', 'une erreur est survenue pendant votre inscription. Merci de contacter l\'administrateur du site');
            }
        } else {
            return redirect(route('login'))->with('error', 'une erreur est survenue pendant votre connexion/inscription. Merci de contacter l\'administrateur du site');
        }
    }
}