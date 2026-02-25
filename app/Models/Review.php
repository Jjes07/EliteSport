<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    /**
     * REVIEW ATTRIBUTES
     * $this->attributes['id'] - int - contains the review primary key (id)
     * $this->attributes['comment'] - string - contains the review comment
     * $this->attributes['rating'] - int - contains the review rating (1-5)
     */

    /**
     * RATING_MAP is a constant array that maps each rating value (1-5) to a label and a CSS class for styling.
     * This can be used in views to display the appropriate label and styling based on the review's rating.
     */
    private const RATING_MAP = [
        5 => ['label' => 'Excellent', 'class' => 'bg-success'],
        4 => ['label' => 'Good',      'class' => 'bg-primary'],
        3 => ['label' => 'Average',   'class' => 'bg-warning'],
        2 => ['label' => 'Fair',      'class' => 'bg-orange'],
        1 => ['label' => 'Poor',      'class' => 'bg-danger'],
    ];

    protected $fillable = ['comment', 'rating'];

    public function getId(): int
    {
        return $this->attributes['id'];
    }

    public function setId($id): void
    {
        $this->attributes['id'] = $id;
    }

    public function getComment(): string
    {
        return $this->attributes['comment'];
    }

    public function setComment($comment): void
    {
        $this->attributes['comment'] = $comment;
    }

    public function getRating(): int
    {
        return $this->attributes['rating'];
    }

    public function setRating($rating): void
    {
        $this->attributes['rating'] = $rating;
    }

    /* Custom method to get a human-readable label for the rating */
    public function getRatingLabel(): string
    {
        return self::RATING_MAP[$this->rating]['label'] ?? 'Unknown';
    }

    /* Custom method to get the CSS class for the rating badge */
    public function getRatingBadgeClass(): string
    {
        return self::RATING_MAP[$this->rating]['class'] ?? 'bg-secondary';
    }
}
