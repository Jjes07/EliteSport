<?php

namespace App\Http\Controllers;

use App\Interfaces\ProductCatalog;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $viewData = [];
        $viewData['title'] = __('products.products_list');
        $viewData['products'] = app(ProductCatalog::class)->getInStockProducts();
        $viewData['categories'] = Category::all();
        $viewData['showCleanButton'] = false;

        return view('product.index')->with('viewData', $viewData);
    }

    public function show(int $id): View
    {
        $viewData = [];
        $product = Product::findOrFail($id);

        $viewData['title'] = $product->getName().' - '.__('products.detail_title');
        $viewData['product'] = $product;

        $reviews = $product->reviews()->with('user')->latest()->get();
        $viewData['reviews'] = $reviews;
        $viewData['reviewsLimit'] = $reviews->take(3);
        $viewData['totalReviews'] = $reviews->count();
        $viewData['userReview'] = auth()->check()
            ? $reviews->where('user_id', auth()->id())->first()
            : null;

        return view('product.show')->with('viewData', $viewData);
    }

    public function search(Request $request): View
    {
        $viewData = [];
        $viewData['title'] = __('products.search_by_name');
        $viewData['categories'] = Category::all();

        $searchTerm = $request->input('name', '');
        $categoryId = $request->input('category', null);

        $viewData['searchTerm'] = $searchTerm;
        $viewData['selectedCategory'] = $categoryId;
        $viewData['showCleanButton'] = ! empty($searchTerm) || ! empty($categoryId);

        $viewData['products'] = Product::searchByNameAndCategory($searchTerm, $categoryId ? (string) $categoryId : null);

        return view('product.index')->with('viewData', $viewData);
    }
}
