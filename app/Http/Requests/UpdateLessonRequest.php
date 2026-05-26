<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateLessonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // 'course_id' => 'required',
            // 'title'     => 'required|string|max:255',
            // 'video'     => 'nullable|file|mimes:mp4,mov,avi,webm',
            // 'content'   => 'required|string',
            // 'duration'  => 'required|integer|min:1',
            // 'order'     => 'required|numeric|min:0',
            // 'is_preview' => 'required|numeric'
        ];
    }
}
