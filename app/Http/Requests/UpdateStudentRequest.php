<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
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
        // Assuming you have a route parameter named 'student' that contains the student's ID
        $studentId = $this->route('student');

        return [
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'email'         => 'required|email|unique:students,email,' . $studentId,
            'phone'         => 'required|string|unique:students,phone,' . $studentId,
            'student_id'    => 'required|string|unique:students,student_id,' . $studentId,
            'status'        => 'required|boolean',
            'address'       => 'nullable|string|max:255',
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
            'first_name.required' => 'First name is required.',
            'first_name.string' => 'First name must be a string.',
            'first_name.max' => 'First name must not exceed 255 characters.',
            
            'last_name.required' => 'Last name is required.',
            'last_name.string' => 'Last name must be a string.',
            'last_name.max' => 'Last name must not exceed 255 characters.',
            
            'email.required' => 'Email is required.',
            'email.email' => 'Email must be a valid email address.',
            'email.unique' => 'This email address is already in use.',
            
            'phone.required' => 'Phone number is required.',
            'phone.string' => 'Phone number must be a string.',
            'phone.unique' => 'This phone number is already in use.',
            
            'student_id.required' => 'Student ID is required.',
            'student_id.string' => 'Student ID must be a string.',
            'student_id.unique' => 'This student ID is already in use.',
            
            'status.required' => 'Status is required.',
            'status.boolean' => 'Status must be a boolean value (true or false).',
            
            'address.string' => 'Address must be a string.',
            'address.max' => 'Address must not exceed 255 characters.',
        ];
    }
}
