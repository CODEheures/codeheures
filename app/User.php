<?php

namespace App;

use App\Notifications\ResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'confirmation_token',
        'firstName',
        'lastName',
        'enterprise',
        'siret',
        'phone',
        'confirmed',
        'facebook_id',
        'google_id',
        'twitter_id',
        'github_id',
        'linkedin_id',
        'avatar',
        'quota',
        'is_admin_valid',
        'isDemo',
        'ip',
        'new_create_by_admin'
    ];

    protected $appends = ['invoice_address', 'shipping_address'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function addresses() {
        return $this->hasMany('App\Address');
    }

    public function getInvoiceAddressAttribute() {
        foreach ($this->addresses as $address){
            if($address->type == 'invoice') { return $address; };
        }
        return null;
    }

    public function getShippingAddressAttribute() {
        foreach ($this->addresses as $address){
            if($address->type == 'shipping') { return $address; };
        }
        return null;
    }

    public function purchases() {
        return $this->hasMany('App\Purchase');
    }

    public function quotations() {
        return $this->hasMany('App\Quotation');
    }

    public function sms() {
        return $this->hasMany('App\Sms');
    }

    public function validPuchases() {
        $purchases = Purchase::where('user_id', '=', $this->id)
            ->where(function($query) {
                $query->where('payed', '=', true)
                    ->orWhere('quotation_id', '<>', 'null');
            })->orderBy('created_at', 'DESC')->get();

        return $purchases;
    }

    public function oAuthProvider($providers) {
        $refOauth = '';
        foreach ($providers as $testId) {
            $column = $testId.'_id';
            if($this->$column){
                $refOauth = $testId;
            }
        }
        return $refOauth;
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }
}
