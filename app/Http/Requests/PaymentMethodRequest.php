<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentMethodRequest extends FormRequest
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
            'card_number' => [
                'required',
                'string',
                'unique:payment_methods,card_number'
            ],
            'brand' => [
                'required',
                'string'
            ],
            'expiration_date' => [
                'required',
                'string'
            ],
            'security_code' => [
                'required',
                'int'
            ],
            'holder' => [
                'required',
                'string'
            ]
            
        ];
    }

    public function messages()
    {
        return [
            'card_number.required' => 'Preencha o campo obrigatório',
            'expiration_date.required' => 'Não foi possível completar a operação',
            'holder.string' => 'Não foi possível completar a operação',
            'security_code.string' => 'Não foi possível completar a operação',
        ];
    }
}
