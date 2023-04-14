<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreScheduleFormRequest extends FormRequest
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
            'advertiser_id' => 'required|integer',
            'contractor_zip_code' => 'required',
            'date' => 'required|date_format:Y-m-d',
            'starts_at' => 'required|date_format:Y-m-d H:i:s|before:finishes_at',
            'finishes_at' => 'required|date_format:Y-m-d H:i:s|after:starts_at'
        ];
    }
}
