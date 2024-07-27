<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRegistrationRequest extends FormRequest
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
            'first_name'                    => 'required|string|min:3|max:100',
            'last_name'                     => 'required|string|min:3|max:100',
            'email'                         => 'required|string|min:3|max:100|unique:users,email',
            'phone'                         => 'required|string|min:11|max:11|unique:users,phone',
            'gender'                        => 'required|integer',
            'address'                       => 'sometimes|nullable|string',
            'password'                      => 'required|confirmed|min:6',
            'password_confirmation'         => 'required'
        ];
    }
}
