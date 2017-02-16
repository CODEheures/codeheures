<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LineQuoteRequest extends FormRequest
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
            'quotation_id' => 'required|numeric|exists:quotations,id',
            'product_id' => 'required|numeric|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'discount' => 'nullable|numeric',
            'discount_type' =>'required'
        ];
    }

    public function sanitize() {
        $input = $this->all();
        $input['discount'] = (int) round(($input['discount']*100),0);
        $this->replace($input);
    }
}
