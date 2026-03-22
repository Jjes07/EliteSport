<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function index(): View
    {
        $viewData = [];
        $viewData['reviews'] = Review::all();

        return view('review.index')->with('viewData', $viewData);
    }

    public function show(int $id): View
    {
        $viewData = [];
        $review = Review::findOrFail($id);
        $viewData['review'] = $review;
        $viewData['ratingLabel'] = $review->getRatingLabel();

        return view('review.show')->with('viewData', $viewData);
    }

    public function create(): View
    {
        return view('review.create');
    }

    public function save(Request $request): RedirectResponse
    {
        Review::validate($request);

        Review::create($request->only(['comment', 'rating']));

        $viewData = [];
        $viewData['success'] = 'Review submitted successfully!';

        return redirect()->route('review.index')->with('success', $viewData['success']);
    }

    public function destroy(int $id): RedirectResponse
    {
        $review = Review::findOrFail($id);
        $review->delete();

        $viewData = [];
        $viewData['success'] = 'Review deleted successfully!';

        return redirect()->route('review.index')->with('success', $viewData['success']);
    }
}
