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

        $viewData['title'] = 'Reviews - '.$product->getName();
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

        $viewData['title'] = 'Review - '.$product->getName();
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

        $viewData['title'] = 'Write a Review - '.$product->getName();
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
                ->with('error', '¡Ya has reseñado este producto!');
        }

        Review::createReview(
            Auth::id(),
            $productId,
            $validatedData['comment'],
            $validatedData['rating']
        );

        return redirect()
            ->route('product.show', $productId)
            ->with('success', '¡Tu reseña ha sido enviada exitosamente!');
    }

    public function edit(int $productId, int $reviewId): View
    {
        $viewData = [];
        $product = Product::findOrFail($productId);
        $review = Review::where('product_id', $productId)->findOrFail($reviewId);

        if (! $review->canBeEditedBy(Auth::id())) {
            abort(403, 'No estás autorizado para editar esta reseña.');
        }

        $viewData['title'] = 'Edit Review - '.$product->getName();
        $viewData['product'] = $product;
        $viewData['review'] = $review;

        return view('review.edit')->with('viewData', $viewData);
    }

    public function update(UpdateReviewRequest $request, int $productId, int $reviewId): RedirectResponse
    {
        $validatedData = $request->validated();
        $review = Review::where('product_id', $productId)->findOrFail($reviewId);

        if (! $review->canBeEditedBy(Auth::id())) {
            abort(403, 'No estás autorizado para editar esta reseña.');
        }

        $review->updateReview($validatedData);

        return redirect()
            ->route('product.show', $productId)
            ->with('success', '¡Tu reseña ha sido actualizada exitosamente!');
    }

    public function delete(int $productId, int $reviewId): RedirectResponse
    {
        $review = Review::where('product_id', $productId)->findOrFail($reviewId);

        if (! $review->canBeDeletedBy(Auth::id(), Auth::user()->getRole())) {
            return redirect()
                ->route('product.show', $productId)
                ->with('error', '¡No estás autorizado para eliminar esta reseña!');
        }

        $review->delete();

        $message = Auth::user()->getRole() === 'admin'
            ? 'La reseña ha sido eliminada por un administrador.'
            : 'Tu reseña ha sido eliminada exitosamente.';

        return redirect()
            ->route('product.show', $productId)
            ->with('success', $message);
    }
}
