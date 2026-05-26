<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCourseReviewRequest extends FormRequest
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
            'course_id' => ['required', 'exists:courses,id', Rule::unique('course_reviews')->where(function ($query) {
                return $query->where('user_id', $this->user_id);
            }), ],
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|max:1000',
        ];
    }
}
