<?php

// Request created by Juan Escobar

namespace App\Http\Requests\Review;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'rating' => 'sometimes|integer|min:1|max:5',
            'comment' => 'sometimes|string|max:250',
        ];
    }

    public function messages(): array
    {
        return [
            'rating.min' => __('reviews.validation_rating_min'),
            'rating.max' => __('reviews.validation_rating_max'),
            'comment.max' => __('reviews.validation_comment_max'),
        ];
    }
}
