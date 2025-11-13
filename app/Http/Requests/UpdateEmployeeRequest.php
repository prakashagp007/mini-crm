<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'company_id' => 'nullable|exists:companies,id',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'document' => 'nullable|file|mimes:pdf|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'document.mimes' => 'Only pdf documents are allowed.',
        ];
    }
}
