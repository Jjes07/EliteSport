<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\SaveProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $viewData = [];
        $viewData['title'] = __('products.products_list');
        $viewData['products'] = Product::all();
        $viewData['showCleanButton'] = false;
        $viewData['categories'] = Category::all();

        return view('admin.product.index')->with('viewData', $viewData);
    }

    public function create(): View
    {
        $viewData = [];
        $viewData['title'] = __('forms.create_product');
        $viewData['categories'] = Category::all();

        return view('admin.product.create')->with('viewData', $viewData);
    }

    public function save(SaveProductRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        $product = new Product;
        $product->setName($validatedData['name']);
        $product->setDescription($validatedData['description']);
        $product->setPrice($validatedData['price']);
        $product->setStock($validatedData['stock']);
        $product->setImage($validatedData['image']);
        $product->setCategory($validatedData['category_id']);
        $product->save();

        return redirect()
            ->route('product.index')
            ->with('success', __('messages.product_created'));
    }

    /**
     * Display product details with reviews
     */
    public function show(int $id): View
    {
        $viewData = [];
        $product = Product::findOrFail($id);

        $viewData['title'] = $product->getName() . ' - ' . __('products.detail_title');
        $viewData['product'] = $product;
        $reviewsCollection = $product->getReviews()->load('user');
        $viewData['reviews'] = $reviewsCollection->sortByDesc('created_at');
        $viewData['reviewsLimit'] = $reviewsCollection->sortByDesc('created_at')->take(3);
        $viewData['totalReviews'] = $reviewsCollection->count();
        $viewData['userReview'] = Auth::check()
            ? $reviewsCollection->where('user_id', Auth::id())->first()
            : null;

        return view('product.show')->with('viewData', $viewData);
    }

    public function edit(int $id): View
    {
        $viewData = [];
        $product = Product::findOrFail($id);

        $viewData['title'] = $product->getName() . ' - ' . __('forms.edit_product');
        $viewData['product'] = $product;
        $viewData['categories'] = Category::all();

        return view('admin.product.edit')->with('viewData', $viewData);
    }

    public function update(UpdateProductRequest $request, int $id): RedirectResponse
    {
        $validatedData = $request->validated();
        $product = Product::findOrFail($id);

        $product->setName($validatedData['name']);
        $product->setDescription($validatedData['description']);
        $product->setPrice($validatedData['price']);
        $product->setStock($validatedData['stock']);
        $product->setImage($validatedData['image']);
        $product->setCategory($validatedData['category_id']);
        $product->save();

        return redirect()
            ->route('product.index')
            ->with('success', __('messages.product_updated'));
    }

    /**
     * Search products by name or category
     */
    public function search(Request $request): View
    {
        $viewData = [];
        $viewData['title'] = __('products.search_by_name');
        $viewData['categories'] = Category::all();

        $searchTerm = $request->input('name', '');
        $categoryId = $request->input('category', null);

        $viewData['searchTerm'] = $searchTerm;
        $viewData['selectedCategory'] = $categoryId;
        $viewData['showCleanButton'] = !empty($searchTerm) || !empty($categoryId);

        $viewData['products'] = Product::searchByNameAndCategory($searchTerm, $categoryId ? (string) $categoryId : null);

        return view('admin.product.index')->with('viewData', $viewData);
    }

    public function delete(int $id): RedirectResponse
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()
            ->route('product.index')
            ->with('success', __('messages.product_deleted'));
    }
}
