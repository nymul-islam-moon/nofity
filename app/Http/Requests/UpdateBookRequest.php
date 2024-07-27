<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
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
            'name'                  => 'required|string|min:3|max:100|unique:books,name,' . $this->books->id,
            'books_category_id'     => 'required|integer',
            'status'                => 'required|integer',
            'file'                  => 'file|mimes:pdf,doc,docx',
            'img'                   => 'image|mimes:jpeg,png,jpg,gif'
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
            'name.required'                 => 'Books name must be required',
            'books_category_id.required'    => 'Books category must be required',
            'name.unique'                   => 'Books name already exists',
            'status.integer'                => 'Select a valid status',
            'status.required'               => 'Books category must be required'
        ];
    }
}
