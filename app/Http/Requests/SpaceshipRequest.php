<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SpaceshipRequest extends FormRequest
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
            'name'        => 'required|max:255',
            'description' => 'required|max:255',
            'capacity'    => 'nullable|integer'
        ];
    }

    public function failedValidation(Validator $validator) { 
        throw new HttpResponseException(response()->json([
            'message' => 'Field verification failed.',
            'data'    => $validator->messages()
        ], 422));
   }
}
