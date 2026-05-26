<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLessonProgressRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'lesson_id' => 'required|exists:lessons,id',
            'lesson_id' => ['required', 'exists:lessons,id', Rule::unique('lesson_progresses')->where(function ($query) {
                return $query->where('user_id', $this->user_id);
            }), ],
            'watched_seconds' => 'required|integer',
            'is_completed' => 'required|boolean',
            'completed_at' => 'required|date',
        ];
    }
}
