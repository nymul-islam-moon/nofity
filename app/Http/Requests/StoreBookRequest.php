<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
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
            'name'                  => 'required|string|min:3|max:100|unique:books,name',
            'books_category_id'     => 'required|integer',
            'status'                => 'required|integer',
            'file'                  => 'required|file|mimes:pdf,doc,docx',
            'img'                   => 'required|image|mimes:jpeg,png,jpg,gif'
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
            'name.required'                 => 'Book name must be required',
            'books_category_id.required'    => 'Book category must be required',
            'name.unique'                   => 'Book name already exists',
            'status.integer'                => 'Select a valid status',
            'name.file'                     => 'Books file must be required',
            'name.img'                      => 'Books img must be required',
        ];
    }
}
