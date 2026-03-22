<?php

# Class created by Juan Escobar

namespace App\Http\Controllers;

use App\Http\Requests\SaveReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function index(Request $request, int $productId): View
    {
        $viewData = [];
        $product = Product::findOrFail($productId);
        $selectedRatings = Review::processFilters($request);
        
        $viewData['title'] = 'Reviews - ' . $product->getName();
        $viewData['product'] = $product;
        $viewData['reviews'] = Review::getReviewsWithFilters($product, $selectedRatings);
        $viewData['selectedRatings'] = $selectedRatings;
        $viewData['ratingCounts'] = Review::getRatingCounts($product);

        return view('review.index')->with('viewData', $viewData);
    }

    public function show(int $productId, int $reviewId): View
    {
        $viewData = [];
        $product = Product::findOrFail($productId);
        $review = Review::where('product_id', $productId)->findOrFail($reviewId);
        
        $viewData['title'] = 'Review - ' . $product->getName();
        $viewData['product'] = $product;
        $viewData['review'] = $review;
        $viewData['ratingLabel'] = $review->getRatingLabel();

        return view('review.show')->with('viewData', $viewData);
    }

    public function create(int $productId): View
    {
        $viewData = [];
        $product = Product::findOrFail($productId);
        $existingReview = Review::getUserReviewForProduct(Auth::id(), $productId);
        
        $viewData['title'] = 'Write a Review - ' . $product->getName();
        $viewData['product'] = $product;
        $viewData['existingReview'] = $existingReview;

        return view('review.create')->with('viewData', $viewData);
    }

    public function save(SaveReviewRequest $request, int $productId): RedirectResponse
    {
        $validatedData = $request->validated();

        // Check if user already reviewed this product
        if (Review::hasUserReviewedProduct(Auth::id(), $productId)) {
            return redirect()
                ->route('product.show', $productId)
                ->with('error', 'You have already reviewed this product!');
        }
        
        Review::createReview(
            Auth::id(),
            $productId,
            $validatedData['comment'],
            $validatedData['rating']
        );

        return redirect()
            ->route('product.show', $productId)
            ->with('success', 'Your review has been submitted successfully!');
    }

    public function edit(int $productId, int $reviewId): View
    {
        $viewData = [];
        $product = Product::findOrFail($productId);
        $review = Review::where('product_id', $productId)->findOrFail($reviewId);
        
        if (!$review->canBeEditedBy(Auth::id())) {
            abort(403, 'You are not authorized to edit this review.');
        }
        
        $viewData['title'] = 'Edit Review - ' . $product->getName();
        $viewData['product'] = $product;
        $viewData['review'] = $review;

        return view('review.edit')->with('viewData', $viewData);
    }

    public function update(UpdateReviewRequest $request, int $productId, int $reviewId): RedirectResponse
    {
        $validatedData = $request->validated();
        $review = Review::where('product_id', $productId)->findOrFail($reviewId);
        
        if (!$review->canBeEditedBy(Auth::id())) {
            abort(403, 'You are not authorized to edit this review.');
        }
        
        $review->updateReview($validatedData);

        return redirect()
            ->route('product.show', $productId)
            ->with('success', 'Your review has been updated successfully!');
    }

    public function delete(int $productId, int $reviewId): RedirectResponse
    {
        $review = Review::where('product_id', $productId)->findOrFail($reviewId);
        
        if (!$review->canBeDeletedBy(Auth::id(), Auth::user()->getRole())) {
            return redirect()
                ->route('product.show', $productId)
                ->with('error', 'You are not authorized to delete this review!');
        }
        
        $review->delete();
        
        $message = Auth::user()->getRole() === 'admin'
            ? 'Review has been deleted by admin.'
            : 'Your review has been deleted successfully.';

        return redirect()
            ->route('product.show', $productId)
            ->with('success', $message);
    }
}