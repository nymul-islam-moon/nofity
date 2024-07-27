<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNotificationRequest extends FormRequest
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
            'title'             => 'required|string|min:3|max:100',
            'tags'              => 'required|array',
            'status'            => 'required|boolean',
            'short_description' => 'required|string|min:20',
            'description'       => 'required|string|min:20',
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
            'title.required'              => 'Title must be required',
            'tags.required'               => 'Tag must be required',
            'status.required'             => 'Status must be required',
            'short_description.required'  => 'Short Description must be required',
            'description.required'        => 'Description must be required',
        ];
    }
}
