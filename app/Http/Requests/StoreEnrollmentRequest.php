<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEnrollmentRequest extends FormRequest
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

        return
            [
                'user_id' => 'required|exists:users,id',
                // 'course_id' => 'required|exists:courses,id',
                'course_id' => ['required', 'exists:courses,id', Rule::unique('enrollments')->where(function ($query) {
                    return $query->where('user_id', $this->user_id);
                }), ],
                'enrolled_at' => 'required|string',
                'progress_percentage' => 'required|integer',
                'completed_at' => 'nullable|date',
            ];
    }
}
