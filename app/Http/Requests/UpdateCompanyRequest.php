<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest {
    public function authorize() { return true; }
    public function rules() {
        return [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'logo' => 'nullable|file|mimes:jpg,png|dimensions:min_width=100,min_height=100',
        ];
    }
}
