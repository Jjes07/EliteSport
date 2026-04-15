<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display home page with products and search functionality
     */
    public function index(Request $request): View
    {
        $viewData = [];
        $viewData['title'] = __('products.title');
        $viewData['categories'] = Category::all();

        $searchTerm = $request->input('name', '');
        $categoryId = $request->input('category', '');

        $viewData['searchTerm'] = $searchTerm;
        $viewData['selectedCategory'] = $categoryId;
        $viewData['showCleanButton'] = !empty($searchTerm) || !empty($categoryId);

        if ($searchTerm || $categoryId) {
            $viewData['products'] = Product::searchByNameAndCategory($searchTerm, $categoryId ?: null);
        } else {
            $viewData['products'] = Product::all();
        }

        return view('home.index')->with('viewData', $viewData);
    }
}

