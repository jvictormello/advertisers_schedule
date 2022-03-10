<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class SaleRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY)
        );
    }

    public function data(): array
    {
        return [
            'user_id' => $this->get('UserId'),
            'name' => $this->get('Name'),
            'payment_method_id' => $this->get('CreditCardId')
        ];
    }

    public function rules()
    {
        return [
            'UserId' => [
                'required'
            ],
            'Name' => [
                'required',
                'min:3',
                'max:150'
            ],
            'CreditCardId' => [
                'required'
            ]
        ];
    }

    public function messages()
    {
        return [
            'UserId.required' => 'Campo obrigatório',
            'Name.required' => 'Campo obrigatório',
            'Name.min' => 'O Nome deve ter no mínimo 3 caracteres',
            'Name.max' => 'O Nome deve ter no máximo 150 caracteres',
            'CreditCardId.required' => 'Campo obrigatório',
        ];
    }

    public function toSnakeCase(): Array
    {
       return [
            'user_id' => $this->get('UserId'),
            'name' => $this->get('Name'),
            'payment_method_id' => $this->get('CreditCardId')
       ];
    }
}
