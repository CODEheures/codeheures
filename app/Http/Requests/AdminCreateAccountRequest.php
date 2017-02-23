<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Http\FormRequest;

class AdminCreateAccountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(Guard $auth)
    {
        return $auth->check() && $auth->user()->role=='admin';
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
            'phone' => array('nullable','regex:/^(?:0|\(?\+33\)?\s?|0033\s?)[1-79](?:[\.\-\s]?\d\d){4}$/'),
            'lastName' => 'required_without:enterprise,siret|max:255',
            'firstName' => 'nullable|max:255',
            'enterprise' => 'required_without:lastName|required_with:siret|nullable|max:100|string',
            'siret' => 'required_without:lastName|required_with:enterprise|nullable|size:14|alpha_num',
            'address' => 'required|min:3|max:38',
            'complement' => 'nullable|min:3|max:38',
            'zipCode' => 'required|max:99999|numeric',
            'town' => 'required|min:3|max:32',
            'password' => 'required|same:password_confirmation',
        ];
    }
}
