<?php

// Request created by Juan Escobar

namespace App\Http\Requests\Review;

use Illuminate\Foundation\Http\FormRequest;

class SaveReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:250',
        ];
    }

    public function messages(): array
    {
        return [
            'rating.required' => __('reviews.validation_rating_required'),
            'rating.min' => __('reviews.validation_rating_min'),
            'rating.max' => __('reviews.validation_rating_max'),
            'comment.required' => __('reviews.validation_comment_required'),
            'comment.max' => __('reviews.validation_comment_max'),
        ];
    }
}
