<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Services\ProductCatalogService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductCatalogService $catalogService
    ) {}

    public function index(): View
    {
        $viewData = [];
        $viewData['title'] = __('products.products_list');
        $viewData['products'] = $this->catalogService->getInStock();
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

        $reviewsCollection = $product->getReviews()->load('user');
        $viewData['reviews'] = $reviewsCollection->sortByDesc('created_at');
        $viewData['reviewsLimit'] = $reviewsCollection->sortByDesc('created_at')->take(3);
        $viewData['totalReviews'] = $reviewsCollection->count();
        $viewData['userReview'] = auth()->check()
            ? $reviewsCollection->where('user_id', auth()->id())->first()
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

        // Aquí usamos el buscador del modelo
        $viewData['products'] = Product::searchByNameAndCategory($searchTerm, $categoryId ? (string) $categoryId : null);

        return view('product.index')->with('viewData', $viewData);
    }
}
    