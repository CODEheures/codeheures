<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAccountAddressRequest extends FormRequest
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
            'address' => "min:3|max:38",
            'complement' => "nullable|min:3|max:38",
            'zipCode' => 'max:99999|numeric',
            'town' => "min:3|max:32",
            'type' => "in:shipping,invoice"
        ];
    }
}
