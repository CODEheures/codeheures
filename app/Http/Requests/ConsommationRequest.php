<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConsommationRequest extends FormRequest
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
        return [
            'purchase_id' => 'required|numeric|exists:purchases,id',
            'value' => 'required|numeric|min:0.01',
            'comment' => 'required|string|min:3|max:200',
            'created_at' =>'required|date',
            'ratio_prestation' => 'nullable|numeric|max:99.99'
        ];
    }
}
