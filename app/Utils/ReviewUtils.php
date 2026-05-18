<?php

namespace App\Utils;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ReviewUtils
{
    public static function getReviewsWithFilters(Product $product, array $selectedRatings = []): Collection
    {
        $query = $product->reviews()->with('user')->latest();

        if (! empty($selectedRatings)) {
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

    public static function hasUserReviewedProduct(int $userId, int $productId): bool
    {
        return Review::where('user_id', $userId)
            ->where('product_id', $productId)
            ->exists();
    }

    public static function getUserReviewForProduct(int $userId, int $productId): ?Review
    {
        return Review::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();
    }

    public static function processFilters(Request $request): array
    {
        $selectedRatings = $request->query('ratings', []);

        if (! is_array($selectedRatings)) {
            $selectedRatings = [$selectedRatings];
        }

        return array_filter(array_map('intval', $selectedRatings), function ($rating) {
            return $rating >= 1 && $rating <= 5;
        });
    }
}