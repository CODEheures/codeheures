<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

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
        'avatar',
        'quota',
        'is_admin_valid'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function addresses() {
        return $this->hasMany('App\Address');
    }

    public function purchases() {
        return $this->hasMany('App\Purchase');
    }

    public function quotations() {
        return $this->hasMany('App\Quotation');
    }

    public function validPuchases() {
        $purchases = Purchase::where('user_id', '=', $this->id)
            ->where(function($query) {
                $query->where('payed', '=', true)
                    ->orWhere('quotation_id', '<>', 'null');
            })->orderBy('created_at', 'DESC')->get();

        return $purchases;
    }
}
