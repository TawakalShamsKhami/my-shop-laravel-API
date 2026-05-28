<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Helpers\ApiResponse;

class CompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'address' => 'required',
            'licence_number' => 'required|unique:companies,licence_number',
            'tin_number' => 'required|unique:companies,tin_number',
            'phone' => 'required',
            'email' => 'required|email',
            'owner_ship_type_id' => 'required|integer',
            'tax_id' => 'required|exists:taxes,id'

        ];
    }

        protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            ApiResponse::error(
                400,
                $validator->errors()->first(),
                '400'
            )
        );
    }
}
