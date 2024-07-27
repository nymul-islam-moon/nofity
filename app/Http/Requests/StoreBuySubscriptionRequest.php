<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBuySubscriptionRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'user_id'                   => 'sometimes|nullable|integer',
            'subscription_id'           => 'required|integer',
            'phone_num'                 => 'required|string',
            'trans_num'                 => 'required|string',

        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'subscription_id.required'         => 'Select a valid subscription id',
            'phone_num.required'               => 'Phone Number must be require',
            'trans_num.required'               => 'Transaction Number must be require',

        ];
    }
}
