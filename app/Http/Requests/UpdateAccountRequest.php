<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAccountRequest extends FormRequest
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
            'email' => "email|max:255|unique:users,email, {$auth->user()->id}",
            'name' => array('required', 'regex:/^[A-Za-z0-9_[:space:]]{3,255}$/'),
            //'phone' => 'numeric|min:0600000000|max:0799999999',
            'phone' => array('regex:/^(?:0|\(?\+33\)?\s?|0033\s?)[1-79](?:[\.\-\s]?\d\d){4}$/'),
            'firstName' => 'max:255',
            'lastName' => 'max:255',
            'address' => 'max:38',
            'enterprise' => 'nullable|max:100|string',
            'siret' => 'nullable|size:14|alpha_num'
        ];
    }
}
