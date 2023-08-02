<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CurrencyConvertRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'amount' => 'required|regex:/^\$[0-9]{1,3}(?:,[0-9]{3})*(?:\.[0-9]{1,2})?$/',
            'source' => 'required|string|max:3',
            'target' => 'required|string|max:3'
        ];
    }

    /**
     * @param Validator $validator
     * @return void
     */
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->currencyConvertFail($validator->errors()->toArray())
        );
    }
}
