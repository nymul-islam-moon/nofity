<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUsersRequest extends FormRequest
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
            'email'                         => 'required|string|min:3|max:100|unique:users,email,' . $this->users->id,
            'phone'                         => 'required|string|min:11|max:11|unique:users,phone,' . $this->users->id,
            'status'                        => 'required|integer',
            'gender'                        => 'required|integer',
            'is_admin'                      => 'required|integer',
            'image'                         => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif',
            'address'                       => 'sometimes|nullable|string'
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
            'first_name.required'                   => 'User first name must be required',
            'last_name.required'                    => 'User last name must be required',
            'email.required'                        => 'User email must be required',
            'phone.required'                        => 'User phone must be required',
            'status.integer'                        => 'Select a valid status',
            'gender.integer'                        => 'Select a valid gender',
            'is_admin.integer'                      => 'Select a valid user type',
        ];
    }
}
