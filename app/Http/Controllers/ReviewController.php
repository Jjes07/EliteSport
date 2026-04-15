<?php

// Class created by Juan Escobar

namespace App\Http\Controllers;

use App\Http\Requests\Review\SaveReviewRequest;
use App\Http\Requests\Review\UpdateReviewRequest;
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

        $viewData['title'] = __('reviews.title').' - '.$product->getName();
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

        $viewData['title'] = __('reviews.title').' - '.$product->getName();
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

        $viewData['title'] = __('reviews.write_review').' - '.$product->getName();
        $viewData['product'] = $product;
        $viewData['existingReview'] = $existingReview;

        return view('review.create')->with('viewData', $viewData);
    }

    public function save(SaveReviewRequest $request, int $productId): RedirectResponse
    {
        $validatedData = $request->validated();

        if (Review::hasUserReviewedProduct(Auth::id(), $productId)) {
            return redirect()
                ->route('product.show', $productId)
                ->with('error', __('reviews.already_reviewed'));
        }

        $review = new Review();
        $review->setComment($validatedData['comment']);
        $review->setRating($validatedData['rating']);
        $review->setUserId(Auth::id());
        $review->setProductId($productId);
        $review->save();

        return redirect()
            ->route('product.show', $productId)
            ->with('success', __('reviews.review_submitted'));
    }

    public function edit(int $productId, int $reviewId): View
    {
        $viewData = [];
        $product = Product::findOrFail($productId);
        $review = Review::where('product_id', $productId)->findOrFail($reviewId);

        if (! $review->canBeEditedBy(Auth::id())) {
            abort(403, __('reviews.not_authorized_edit'));
        }

        $viewData['title'] = __('reviews.edit_review').' - '.$product->getName();
        $viewData['product'] = $product;
        $viewData['review'] = $review;

        return view('review.edit')->with('viewData', $viewData);
    }

    public function update(UpdateReviewRequest $request, int $productId, int $reviewId): RedirectResponse
    {
        $validatedData = $request->validated();
        $review = Review::where('product_id', $productId)->findOrFail($reviewId);

        if (! $review->canBeEditedBy(Auth::id())) {
            abort(403, __('reviews.not_authorized_edit'));
        }

        if (isset($validatedData['comment'])) {
            $review->setComment($validatedData['comment']);
        }
        if (isset($validatedData['rating'])) {
            $review->setRating($validatedData['rating']);
        }
        $review->save();

        return redirect()
            ->route('product.show', $productId)
            ->with('success', __('reviews.review_updated'));
    }

    public function delete(int $productId, int $reviewId): RedirectResponse
    {
        $review = Review::where('product_id', $productId)->findOrFail($reviewId);

        if (! $review->canBeDeletedBy(Auth::id(), Auth::user()->getRole())) {
            return redirect()
                ->route('product.show', $productId)
                ->with('error', __('reviews.not_authorized_delete'));
        }

        $review->delete();

        $message = Auth::user()->getRole() === 'admin'
            ? __('reviews.review_deleted_admin')
            : __('reviews.review_deleted');

        return redirect()
            ->route('product.show', $productId)
            ->with('success', $message);
    }
}
