<?php

// Model created by Juan Escobar

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;

class Review extends Model
{
    use HasFactory;

    /**
     * REVIEW ATTRIBUTES
     * $this->attributes['id'] - integer - contains the review primary key (id)
     * $this->attributes['comment'] - string - contains the review comment
     * $this->attributes['rating'] - integer - contains the review rating (1-5)
     * $this->attributes['user_id'] - integer - contains the user who wrote the review
     * $this->attributes['product_id'] - integer - contains the product being reviewed
     * $this->attributes['created_at'] - timestamp - contains the review creation timestamp
     * $this->attributes['updated_at'] - timestamp - contains the review update timestamp
     *
     * REVIEW RELATIONSHIPS
     * $this->user - BelongsTo - the user who wrote the review
     * $this->product - BelongsTo - the product being reviewed
     */
    private const RATING_MAP = [
        5 => ['label' => 'reviews.rating_excellent', 'class' => 'bg-success'],
        4 => ['label' => 'reviews.rating_good', 'class' => 'bg-primary'],
        3 => ['label' => 'reviews.rating_average', 'class' => 'bg-warning'],
        2 => ['label' => 'reviews.rating_fair', 'class' => 'bg-orange'],
        1 => ['label' => 'reviews.rating_poor', 'class' => 'bg-danger'],
    ];

    protected $fillable = ['comment', 'rating', 'user_id', 'product_id'];

    /* Getters - Attributes */

    protected function casts(): array
    {
        return [
            'rating' => 'integer',
            'user_id' => 'integer',
            'product_id' => 'integer',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
    public function getId(): int
    {
        return $this->attributes['id'];
    }

    public function getComment(): string
    {
        return $this->attributes['comment'];
    }

    public function getRating(): int
    {
        return $this->attributes['rating'];
    }

    public function getUserId(): int
    {
        return $this->attributes['user_id'];
    }

    public function getProductId(): int
    {
        return $this->attributes['product_id'];
    }

    public function getCreatedAt(): string
    {
        return Carbon::parse($this->attributes['created_at'])->format('F d, Y');
    }

    public function getUpdatedAt(): string
    {
        return Carbon::parse($this->attributes['updated_at'])->format('F d, Y');
    }

    /* Setters - Attributes */
    public function setComment(string $comment): void
    {
        $this->attributes['comment'] = $comment;
    }

    public function setRating(int $rating): void
    {
        $this->attributes['rating'] = $rating;
    }

    public function setUserId(int $userId): void
    {
        $this->attributes['user_id'] = $userId;
    }

    public function setProductId(int $productId): void
    {
        $this->attributes['product_id'] = $productId;
    }

    /* Getters - Relationships */
    public function getUser(): User
    {
        return $this->user;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    /* Setters - Relationships */
    public function setUser(User $user): void
    {
        $this->user()->associate($user);
    }

    public function setProduct(Product $product): void
    {
        $this->product()->associate($product);
    }

    /* Relationships */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /* Rating helpers */
    public function getRatingLabel(): string
    {
        return __(self::RATING_MAP[$this->getRating()]['label'] ?? 'reviews.rating_unknown');
    }

    public function getRatingBadgeClass(): string
    {
        return self::RATING_MAP[$this->getRating()]['class'] ?? 'bg-secondary';
    }

    /* Filter methods */
    public static function getReviewsWithFilters(Product $product, ?array $selectedRatings = []): Collection
    {
        $query = $product->reviews()->with('user')->latest();

        if (!empty($selectedRatings)) {
            $query->whereIn('rating', $selectedRatings);
        }

        return $query->get();
    }

    public static function getRatingCounts(Product $product): array
    {
        return [
            5 => $product->reviews()->where('rating', 5)->count(),
            4 => $product->reviews()->where('rating', 4)->count(),
            3 => $product->reviews()->where('rating', 3)->count(),
            2 => $product->reviews()->where('rating', 2)->count(),
            1 => $product->reviews()->where('rating', 1)->count(),
        ];
    }

    /* Helper methods */
    public static function hasUserReviewedProduct(int $userId, int $productId): bool
    {
        return self::where('user_id', $userId)
            ->where('product_id', $productId)
            ->exists();
    }

    public static function getUserReviewForProduct(int $userId, int $productId): ?self
    {
        return self::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();
    }

    public function canBeEditedBy(int $userId): bool
    {
        return $this->getUserId() === $userId;
    }

    public function canBeDeletedBy(int $userId, string $userRole): bool
    {
        return $userRole === 'admin' || $this->getUserId() === $userId;
    }

    public function getDeleteSuccessMessage(string $role): string
    {
        return $role === 'admin'
            ? __('reviews.review_deleted_admin')
            : __('reviews.review_deleted');
    }

    public static function processFilters(Request $request): array
    {
        $selectedRatings = $request->query('ratings', []);

        if (!is_array($selectedRatings)) {
            $selectedRatings = [$selectedRatings];
        }

        return array_filter(array_map('intval', $selectedRatings), function ($rating) {
            return $rating >= 1 && $rating <= 5;
        });
    }
}
