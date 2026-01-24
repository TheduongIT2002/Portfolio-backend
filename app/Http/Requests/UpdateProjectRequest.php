<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateProjectRequest
 * Validation rules cho việc cập nhật project
 */
class UpdateProjectRequest extends FormRequest
{
    /**
     * Xác định user có quyền thực hiện request này không
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true; // Có thể thay đổi sau khi implement authentication
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:255',
            'url' => 'nullable|url|max:255',
            'github_url' => 'nullable|url|max:255',
            'technologies' => 'nullable|array',
            'technologies.*' => 'string|max:100',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_featured' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Tiêu đề dự án là bắt buộc.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            'url.url' => 'URL không hợp lệ.',
            'github_url.url' => 'GitHub URL không hợp lệ.',
            'end_date.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu.',
            'sort_order.integer' => 'Thứ tự sắp xếp phải là số nguyên.',
            'sort_order.min' => 'Thứ tự sắp xếp phải lớn hơn hoặc bằng 0.',
        ];
    }
}
