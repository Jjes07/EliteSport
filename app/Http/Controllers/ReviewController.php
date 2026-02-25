<?php
 
namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\Review;
 
class ReviewController extends Controller
{
    public function index(): View
    {
        $viewData = [];
        $viewData["reviews"] = Review::all();
        return view('review.index')->with("viewData", $viewData);
    }

        public function show(string $id) : View
    {
        $viewData = [];
        $review = Review::findOrFail($id);
        $viewData["review"] = $review;
        $viewData["ratingLabel"] = $review->getRatingLabel();
        return view('review.show')->with("viewData", $viewData);
    }

        public function create(): View
    {
        $viewData = [];

        return view('review.create')->with("viewData",$viewData);
    }

    public function save(Request $request) : \Illuminate\Http\RedirectResponse
    {
        $request->validate([

            "rating" => "required|numeric|min:1|max:5",
            "comment" => "required|string|max:250"

        ]);

        Review::create($request->only(["comment", "rating"]));
        
        $viewData = [];
        $viewData["success"] = "Review submitted successfully!";
        
        return redirect()->route('review.index')->with('success', $viewData["success"]);
    }

    public function destroy(string $id) : \Illuminate\Http\RedirectResponse
    {
        $review = Review::findOrFail($id);
        $review->delete();

        $viewData = [];
        $viewData["success"] = "Review deleted successfully!";

        return redirect()->route('review.index')->with('success', $viewData["success"]);
    }

}
