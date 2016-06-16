<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Contracts\Auth\Guard;

class UpdateAccountRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(Guard $auth)
    {
        return $auth->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Guard $auth)
    {
        return [
            'name' => "required|min:3|max:255|alpha_num|unique:users,name, {$auth->user()->id}",
            //'phone' => 'numeric|min:0600000000|max:0799999999',
            'phone' => array('regex:/^(?:0|\(?\+33\)?\s?|0033\s?)[1-79](?:[\.\-\s]?\d\d){4}$/'),
            'firstName' => 'max:255',
            'lastName' => 'max:255',
            'address' => 'max:38',
            'enterprise' => 'max:100|string',
            'siret' => 'size:14|alpha_num'
        ];
    }
}
