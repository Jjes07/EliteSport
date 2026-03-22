<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ReviewController extends Controller
{
    /**
     * Display all reviews for a specific product
     */
    public function index(int $productId): View
    {
        $product = Product::findOrFail($productId);
        $reviews = $product->reviews()->with('user')->latest()->get();
        
        $viewData = [
            'product' => $product,
            'reviews' => $reviews,
            'title' => 'Reviews - ' . $product->getName(),
        ];

        return view('review.index')->with('viewData', $viewData);
    }

    /**
     * Display a specific review
     */
    public function show(int $productId, int $reviewId): View
    {
        $product = Product::findOrFail($productId);
        $review = Review::where('product_id', $productId)->findOrFail($reviewId);
        
        $viewData = [
            'product' => $product,
            'review' => $review,
            'ratingLabel' => $review->getRatingLabel(),
            'title' => 'Review - ' . $product->getName(),
        ];

        return view('review.show')->with('viewData', $viewData);
    }

    /**
     * Show form to create a review
     */
    public function create(int $productId): View
    {
        $product = Product::findOrFail($productId);
        
        // Check if user already reviewed this product
        $existingReview = Review::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();
        
        $viewData = [
            'product' => $product,
            'existingReview' => $existingReview,
            'title' => 'Write a Review - ' . $product->getName(),
        ];

        return view('review.create')->with('viewData', $viewData);
    }

    /**
     * Store a new review
     */
    public function store(SaveReviewRequest $request, int $productId): RedirectResponse
    {
        $product = Product::findOrFail($productId);
        
        // Check if user already reviewed this product
        $existingReview = Review::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();
            
        if ($existingReview) {
            return redirect()
                ->route('product.show', $productId)
                ->with('error', 'You have already reviewed this product!');
        }
        
        $review = new Review();
        $review->setComment($request->comment);
        $review->setRating($request->rating);
        $review->setUserId(Auth::id());
        $review->setProductId($productId);
        $review->save();
        
        return redirect()
            ->route('product.show', $productId)
            ->with('success', 'Your review has been submitted successfully!');
    }

    /**
     * Show form to edit a review (only the author)
     */
    public function edit(int $productId, int $reviewId): View
    {
        $product = Product::findOrFail($productId);
        $review = Review::where('product_id', $productId)->findOrFail($reviewId);
        
        // Check if the current user is the author
        if (Auth::id() !== $review->getUserId()) {
            abort(403, 'You are not authorized to edit this review.');
        }
        
        $viewData = [
            'product' => $product,
            'review' => $review,
            'title' => 'Edit Review - ' . $product->getName(),
        ];

        return view('review.edit')->with('viewData', $viewData);
    }

    /**
     * Update a review (only the author)
     */
    public function update(UpdateReviewRequest $request, int $productId, int $reviewId): RedirectResponse
    {
        $product = Product::findOrFail($productId);
        $review = Review::where('product_id', $productId)->findOrFail($reviewId);
        
        // Check if the current user is the author
        if (Auth::id() !== $review->getUserId()) {
            abort(403, 'You are not authorized to edit this review.');
        }
        
        if ($request->has('rating')) {
            $review->setRating($request->rating);
        }
        
        if ($request->has('comment')) {
            $review->setComment($request->comment);
        }
        
        $review->save();
        
        return redirect()
            ->route('product.show', $productId)
            ->with('success', 'Your review has been updated successfully!');
    }

    /**
     * Delete a review (only admin or author)
     */
    public function destroy(int $productId, int $reviewId): RedirectResponse
    {
        $review = Review::where('product_id', $productId)->findOrFail($reviewId);
        
        // Check if user is admin or the author
        if (Auth::user()->getRole() === 'admin' || Auth::id() === $review->getUserId()) {
            $review->delete();
            
            $message = Auth::user()->getRole() === 'admin' 
                ? 'Review has been deleted by admin.' 
                : 'Your review has been deleted successfully.';
                
            return redirect()
                ->route('product.show', $productId)
                ->with('success', $message);
        }
        
        return redirect()
            ->route('product.show', $productId)
            ->with('error', 'You are not authorized to delete this review!');
    }
}