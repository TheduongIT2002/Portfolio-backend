<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePersonalInfoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Tạm thời cho phép update (sau này có auth admin thì dùng middleware)
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'full_name' => 'required|string|max:255',
            'slogan' => 'required|string|max:255',
            'short_intro' => 'required|string',
            // avatar và cv_file là file upload, không bắt buộc
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'cv_file' => 'nullable|mimes:pdf,doc,docx|max:5120',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string|max:255',
            'social_links' => 'nullable|array',
            'social_links.*.type' => 'required_with:social_links|string|max:50',
            'social_links.*.label' => 'required_with:social_links|string|max:100',
            'social_links.*.url' => 'required_with:social_links|url|max:255',
        ];
    }
}
