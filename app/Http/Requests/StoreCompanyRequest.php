<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyRequest extends FormRequest {
    public function authorize() { return true; }

    public function rules() {
        return [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            // logo must be jpg or png and optional
            'logo' => 'nullable|file|mimes:jpg,png|dimensions:min_width=100,min_height=100',
        ];
    }

    public function messages() {
        return [
            'logo.mimes' => 'Logo must be a jpg or png.',
            'logo.dimensions' => 'Logo must be at least 100x100 pixels.',
        ];
    }
}
