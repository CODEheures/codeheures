<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->sanitize();

        return [
            'description' =>'required|min:3',
            'url' => 'nullable|url',
            'price' => 'numeric',
            'tva' => 'numeric',
        ];
    }

    public function sanitize() {
        $input = $this->all();
        $input['price'] = (int)  ($input['price']*100);
        $input['tva'] = (int)  ($input['tva']*100);
        $this->replace($input);
    }
}
